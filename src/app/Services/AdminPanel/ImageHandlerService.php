<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Image;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductVariant;
use App\Models\AdminPanel\SiteSetting;
use Error;
use Spatie\Image\Image as SpatieImage;
use Spatie\Image\Manipulations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHandlerService
{
    private $slug_db = 'variant_image';

    private const FIELDS = [
        'model-type',
        'model-id',
        'image',
        'image-name',
    ];

    private const DEFAULT_FOLDER = 'site-images';

    private const STORAGE = 'public';

    public function create(Request $request): array
    {
        $images = null;

        $data = $request->only(self::FIELDS);

        $data['image-name'] ??= Str::random(5);

        $filePath = $this->save(
            $data['image'],
            $this->getPath($data['model-type'], $data['model-id']),
            true
        );

        $extension = pathinfo($filePath)['extension'];

        $imageDb = Image::create([
            'name' => $data['image-name'],
            'slug' => Str::slug($data['image-name']),
            'path' => $filePath,
            'size' => $this->getSizeString(Storage::size('public/' . $filePath)),
            'extension' => $extension,
            'width' => $this->getWidthHeigth($filePath)[0],
            'heigth' => $this->getWidthHeigth($filePath)[1],
        ]);

        $imageDb->update(['slug' => $imageDb->slug . '-' . $imageDb->id]);

        if (!empty($data['model-type']) and !empty($data['model-id']))
        {
            $imageDb = $this->attachImageToModel($imageDb, $data['model-type'], $data['model-id']);
            $images = $this->generateVariationsImages($imageDb, $data['model-type']);
        }

        return [
            'image' => $imageDb,
            'variants-image' => $images,
        ];
    }

    public function getPath($path, $id): string
    {
        if (!empty($path) and !empty($id))
        {
            return $path . '/' . $id;
        }

        return self::DEFAULT_FOLDER;
    }

    private function save(UploadedFile $image, $folder, $optimize = false): string
    {
        $path = $image->store($folder, self::STORAGE);

        if ($optimize) {
            return $this->saveWithOptimized($path, true);
        }

        return $path;
    }

    private function saveWithOptimized($path, $withDeleteOldImage = false): string
    {
        $pathDisk = Storage::path('public/' . $path);

        $newPath = pathinfo($path)['dirname'] . '/' .pathinfo($path)['filename'] . '.webp';

        SpatieImage::load($pathDisk)
            ->format(Manipulations::FORMAT_WEBP)
            ->optimize()
            ->save('./storage/' . $newPath);

        if ($withDeleteOldImage) {
            Storage::delete('public/'. $path);
        }

        return $newPath;
    }

    private function getWidthHeigth($path)
    {
        $pathDisk = Storage::path('public/' . $path);

        return getimagesize($pathDisk);
    }

    private function getSizeString($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1000, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    private function getSearchConfig($strModel)
    {
        if (empty($strModel)) return throw new Error('empty name model in getSearchConfig()');

        $searchPattern = "%basilisk[$strModel]%";

        return SiteSetting::where('setting_key', 'like', $searchPattern)->get();
    }

    private function attachImageToModel($image, $modelType, $modelId)
    {
        $model = $this->getSupportModels($modelType);

        if (is_null($model)) return null;

        $modelDb = $model->newQuery()->where('id', $modelId)->first();

        if (is_null($modelDb)) return null;

        $image->imageable()->associate($modelDb);
        $image->save();

        return $image;
    }

    private function generateVariationsImages($image, $typeModel)
    {
        $images = [];
        $config = $this->getSearchConfig($typeModel);

        if ($config->count() == 0) return null;

        $sizes = $config->map( fn ($item) => explode('x', $item->setting_value));

        foreach ($sizes as $size) {
            $images[] = $this->generateVariantImage($size[0], $size[1], $image);
        }

        return $images;
    }

    private function generateVariantImage($w, $h, $image)
    {
        $parentId = $image->id;
        $path = Storage::path('public/' . $image->path);
        $imageVariantPath = pathinfo($image->path)['dirname'] . '/' . Str::random(40) . '.webp';

        $newSize = $this->calculateNewSizeWithSaveProportions($w, $h, $image->width, $image->heigth);

        SpatieImage::load($path)
            ->width($newSize['w'])
            ->height($newSize['h'])
            ->save('./storage/' . $imageVariantPath);

        $newImage = $image->replicate()->fill([
            'parent_id' => $parentId,
            'width' => $newSize['w'],
            'heigth' => $newSize['h'],
            'path' => $imageVariantPath,
            'slug' => $image->slug . '-' . $newSize['w'] . '-' . $newSize['h'],
            'name' => Str::random(5),
            'size' => $this->getSizeString(Storage::size('public/' . $imageVariantPath)),
        ]);

        $newImage->save();

        return $newImage;
    }

    private function calculateNewSizeWithSaveProportions($widthOld, $heigthOld, $widthNew, $heigthNew)

    {
        $ratio = max($widthNew / $widthOld, $heigthNew / $heigthOld);

        $h = ceil($heigthNew / $ratio);

        $w = ceil($widthNew / $ratio);

        return ['w' => $w, 'h' => $h];
    }

    private function getSupportModels(string $strModel = null)
    {
        return match ($strModel) {
            'variant' => new ProductVariant,
            'category' => new ProductCategory,
            default => null
        };
    }
}
