<?php

namespace App\Http\Controllers\AdminPanel;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageProcessingController extends Controller
{
    public function save(Request $request)
    {
        $filePath = '';

        if ($request->get('type') == 'variant') {
            $filePath = $request->file('image')->store($this->getPathProductVariant(
                $request->get('product-id'),
            ), 'public');
        }

        $path = Storage::path('public/' . $filePath);
        $fileName = pathinfo(basename($path), PATHINFO_FILENAME);
        $pathWebp = $this->getPathProductVariant($request->get('product-id'))."/$fileName.webp";
        list($w, $h) = getimagesize($path);

        Image::load($path)
            ->format(Manipulations::FORMAT_WEBP)
            ->optimize()
            ->save('./storage'.$pathWebp);

        Storage::delete('public/'.$filePath);

        return [
            'message' => 'Картинка была добавлена',
            'data' => [
                'path-image' => substr($pathWebp, 1),
                'url-image' => Storage::url(substr($pathWebp, 1)),
                'width' => $w,
                'heigth' => $h,
                'size' => $this->formatBytes(Storage::size('public'.$pathWebp))
            ]
        ];
    }

    public function saveResizeImage(Request $request)
    {
        $imagePath = $request->get('image-path');
        $imageWidth = $request->get('image-width');
        $imageHeight = $request->get('image-height');

        $filename = pathinfo($imagePath)['filename'];

        $path = Storage::path('public/' . $imagePath);
        $pathNewImage = pathinfo($imagePath)['dirname'] . '/' . md5($filename . time()) . '.webp';

        Image::load($path)
            ->width($imageWidth)
            ->height($imageHeight)
            ->save('./storage/' . $pathNewImage);

        return [
            'path' => $pathNewImage,
            'url-image' => Storage::url($pathNewImage),
            'size' => $this->formatBytes(Storage::size('public/'.$pathNewImage))
        ];
    }

    public function delete(Request $request)
    {
        $imagePath = $request->get('image-url');

        if (is_array($imagePath)) {
            foreach ($imagePath as $path) {
                Storage::delete('public/'.$path);
            }

            return [
                'message' => 'Картинки была удалены!'
            ];
        } else {
            Storage::delete('public/'.$imagePath);

            return [
                'message' => 'Картинка была удалена!'
            ];
        }

    }

    private function getPathProductVariant($productId)
    {
        return "/product/{$productId}/variants";
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1000, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
