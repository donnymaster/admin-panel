<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductCategoryProperty;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DataEchange1C
{
    private const XML_MAPPER = [
        'СвойствоНоменклатуры',
        'ЗначенияСвойства',
        'ЗначенияСвойств',
        'Классификатор',
        'Группы',
        'Ид',
        'Наименование',
        'Свойства',
        'Каталог',
        'Товары',
        'Товар',
        'ШтрихКод',
        'Картинка',
        'Артикул',
        'Группа',
        'Значение',
        'ПакетПредложений',
        'Предложения',
        'Предложение',
        'Количество',
        'ЦенаЗаЕдиницу',
        'Цены',
        'Цена',
        'Модель',
    ];

    private const XML_MAPPER_ENG = [
        'property',
        'itemProperty',
        'itemProperties',
        'classificator',
        'categories',
        'id',
        'title',
        'properties',
        'catalog',
        'items',
        'item',
        'sku',
        'image',
        'art',
        'category',
        'value',
        'info',
        'items',
        'item',
        'quantity',
        'currentPrice',
        'prices',
        'price',
        'model',
    ];

    private const FILE_IMPORT = 'import.xml';

    private const FILE_OFFERS = 'offers.xml';

    private const IMPORT_FILES = '/import_files';

    private const FOLDER = '/1c';

    public function __construct()
    {
        if (!$this->checkExistsFiles()) {
            throw new Exception('Файлы экспорта отсутствуют!');
            return;
        }
    }

    public function exchange()
    {
        $messages = [];

        $xmlObjectImport = $this->generateXmlObject(self::FILE_IMPORT);
        $xmlObjectOffers = $this->generateXmlObject(self::FILE_OFFERS);

        $messages[] = $this->handlerCategories(((array) $xmlObjectImport->classificator->categories)['category']);
        $messages[] = $this->handlerProperties(((array) $xmlObjectImport->classificator->properties)['property']);
        $messages[] = $this->handlerProduct(((array) $xmlObjectImport->catalog->items)['item']);

    }

    private function checkExistsFiles(): bool
    {
        return Storage::exists(self::FOLDER . '/' . self::FILE_IMPORT)
            && Storage::exists(self::FOLDER . '/' . self::FILE_OFFERS)
            && Storage::exists(self::FOLDER . '/' . self::IMPORT_FILES);
    }

    private function generateXmlObject($file): \SimpleXMLElement
    {
        $xmlStringOld = file_get_contents(Storage::path(self::FOLDER . '/' . $file));
        $xmlStringNew = str_replace(self::XML_MAPPER, self::XML_MAPPER_ENG, $xmlStringOld);

        return new \SimpleXMLElement(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xmlStringNew));
    }

    private function handlerCategories($categories = [], $parent = []): array
    {
        foreach ($categories as $category) {
            $parentCategory = ProductCategory::where('sync_id', $category->id)->first();

            if (!$parentCategory) {
                $parentCategory = ProductCategory::create([
                    'name' => $category->title,
                    'slug' => Str::slug($category->title),
                    'position' => $this->getNewPositionProductCategory($parent['parent_id'] ?? null),
                    'sync_id' => $category->id,
                    ...$parent,
                ]);
            } else {
                $parentCategory->update([
                    'name' => $category->title,
                    'slug' => Str::slug($category->title),
                    ...$parent,
                ]);
            }

            if ($category->categories) {
                 $this->handlerCategories(
                    ((array) $category->categories)['category'],
                    ['parent_id' => $parentCategory->id]
                );
            }
        }

        return [ '' ];
    }

    private function getNewPositionProductCategory($parent_id = null): int
    {
        return ProductCategory::when($parent_id, fn($query) => $query->where('parent_id', $parent_id))
            ->max('position') + 1;
    }

    private function getCategoryPropertyRelations($properties): Collection
    {
        $f = collect(((array) $properties->catalog->items)['item']);

        $result = [];

        $val = $f->groupBy(['categories.id'])
            ->map(fn ($items) => $items->filter(fn ($item) => isset($item->itemProperties)));


        foreach ($val as $category => $products) {
            $result[$category] = [];
            foreach ($products as $key => $product) {
                foreach ($product->itemProperties->itemProperty as $property) {
                    $val = (string) $property->id;
                    if(!in_array($val, $result[$category])) $result[$category][] = $val;
                }
            }
        }

        return collect($result)->filter( fn ($items) => count($items) >= 1);
    }

    private function handlerProperties($properties)
    {
        $countCreate = 0;
        $countUpdate = 0;

        foreach ($properties as $property) {
            $id = (string) $property->id;
            $dbProperty = ProductCategoryProperty::where('sync_id', $id)->first();

            if ($dbProperty) {
                $dbProperty->update([
                    'name' => $property->title,
                    'slug' => Str::slug($property->title),
                ]);
                ++$countUpdate;
            } else {
                ProductCategoryProperty::create([
                    'name' => $property->title,
                    'slug' => Str::slug($property->title),
                    'description' => $property->title,
                    'sync_id' => $id,
                ]);
                ++$countCreate ;
            }

        }

        return [
            "Количество добавленных свойств: $countCreate\n",
            "Количество обновленных свойств: $countUpdate\n",
        ];
    }

    private function handlerProduct($items)
    {
        $images = [];
        // foreach ($items as $item) {
        //     $imagePath = (string) $item->image;

        //     if (!$imagePath) continue;


        // }

        for ($iter = 0; $iter < 50; $iter++) {
            $imagePath = (string) $items[$iter]->image;

            if (!$imagePath) continue;

            $images[] = $items[$iter];
        }

        dd($images);
    }
}
