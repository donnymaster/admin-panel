<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\DataExchange;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductCategoryProperty;
use App\Models\AdminPanel\ProductVariant;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
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

    /**
     * @var Collection;
     */
    private  $categoryIds;

    /**
     * @var Collection;
     */
    private $categoryPropertyids;

    /**
     * @var Collection;
     */
    private $productVariantsIds;

    /**
     * @var array;
     */
    private $relationProductCategoryToProperty = [];

    /**
     * @var array;
     */
    private $listProductModel = [];

    public function __construct()
    {
        if (!$this->checkExistsFiles()) {
            throw new Exception('Файлы экспорта отсутствуют!');
            return;
        }

        $this->categoryIds = collect();
        $this->categoryPropertyids = collect();
        $this->productVariantsIds = collect();
    }

    public function exchange(): void
    {
        $messages = [];

        $xmlObjectImport = $this->generateXmlObject(self::FILE_IMPORT);
        $xmlObjectOffers = $this->generateXmlObject(self::FILE_OFFERS);

        $messages[] = $this->handlerCategories(((array) $xmlObjectImport->classificator->categories)['category']);

        $messages[] = $this->handlerProperties(((array) $xmlObjectImport->classificator->properties)['property']);

        $messages[] = $this->handlerProduct(
            ((array) $xmlObjectImport->catalog->items)['item'],
            collect(((array) $xmlObjectOffers->info->items)['item'])
        );

        $this->tieCategoryToProperty();
    }

    public function checkStatusFiles(): array
    {
        return [
            'offers' => Storage::exists(self::FOLDER . '/' . self::FILE_OFFERS),
            'import' => Storage::exists(self::FOLDER . '/' . self::FILE_IMPORT),
            'files'  => Storage::exists(self::FOLDER . '/' . self::IMPORT_FILES),
        ];
    }

    public function makeModel($status)
    {
        $xmlObjectImport = (array) $this->generateXmlObject(self::FILE_IMPORT);
        $xmlObjectOffers = (array) $this->generateXmlObject(self::FILE_OFFERS);

        return DataExchange::create([
            'status' => $status,
            'version_schema_import_file' => $xmlObjectImport['@attributes']['ВерсияСхемы'],
            'version_schema_offers_file' => $xmlObjectOffers['@attributes']['ВерсияСхемы'],
            'data_formations_import_file' => $xmlObjectImport['@attributes']['ДатаФормирования'],
            'data_formations_offers_file' => $xmlObjectOffers['@attributes']['ДатаФормирования'],
            'uniique_id' => Hash::make(
                (string) $xmlObjectImport['classificator']->id . (string) $xmlObjectOffers['info']->id
            ),
        ]);
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
            $id = (string) $category->id;

            if (!$parentCategory) {
                $parentCategory = ProductCategory::create([
                    'name' => $category->title,
                    'slug' => Str::slug($category->title),
                    'position' => $this->getNewPositionProductCategory($parent['parent_id'] ?? null),
                    'sync_id' => $id,
                    ...$parent,
                ]);
            } else {
                $parentCategory->update([
                    'name' => $category->title,
                    'slug' => Str::slug($category->title),
                    ...$parent,
                ]);
            }

            $this->categoryIds->push([
                'sync_id' => $id,
                'db_id' => $parentCategory->id,
            ]);

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

    private function handlerProperties($properties): array
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
                $dbProperty = ProductCategoryProperty::create([
                    'name' => $property->title,
                    'slug' => Str::slug($property->title),
                    'description' => $property->title,
                    'sync_id' => $id,
                ]);
                ++$countCreate;
            }

            $this->categoryPropertyids->push([
                'sync_id' => $id,
                'db_id' => $dbProperty->id,
            ]);

        }

        return [
            "Количество добавленных свойств: $countCreate\n",
            "Количество обновленных свойств: $countUpdate\n",
        ];
    }

    private function handlerProduct($items, Collection $informationList): void
    {
        list($products, $productsWithVariants) = collect($items)
            ->filter( fn ($item) => !empty($item->image))
            ->groupBy('model')
            ->partition( fn ($item, $key) => empty($key));

        foreach ($productsWithVariants as $variants)
        {
            foreach ($variants as $variant) {
                $product = $this->createOrUpdateProduct($variant);
                $variant = $this->createOrUpdateProductVariant($variant, $product->id, $informationList);
            }
        }

        foreach ($products->first() as $variant)
        {
            $product = $this->createOrUpdateProduct($variant);
            $variant = $this->createOrUpdateProductVariant($variant, $product->id, $informationList);
        }

    }

    private function createOrUpdateProduct($xmlProduct): Product
    {
        $dbCategory = $this->categoryIds
            ->first( fn ($items) => $items['sync_id'] == (string) $xmlProduct->categories->id);

        $product = Product::where('sync_model', $xmlProduct->model)->first();

        $model = $this->getModel($xmlProduct);

        if ($product) {
            $product->update([
                'title' => (string) $xmlProduct->title,
                'slug' => Str::slug((string) $xmlProduct->title),
                'page_title' => (string) $xmlProduct->title,
                'category_id' => $dbCategory['db_id'],
            ]);
        } else {
            $product = Product::create([
                'title' => (string) $xmlProduct->title,
                'slug' => Str::slug((string) $xmlProduct->title),
                'page_title' => (string) $xmlProduct->title,
                'category_id' => $dbCategory['db_id'],
                'sync_model' => $this->getModel($xmlProduct),
                'visible' => false,
            ]);
        }

        $this->listProductModel[] = [
            'product_id' => $product->id,
            'model' => $model,
        ];

        return $product;
    }

    private function getModel($xml)
    {
        if (!empty($xml->model)) return (string) $xml->model;

        return Hash::make($xml->title . $xml->categories->id);
    }

    private function createOrUpdateProductVariant($xmlVariant, $productId, Collection $informationList): ProductVariant
    {
        $id = (string) $xmlVariant->id;

        $information = $informationList->first( fn ($item) => (string) $item->id == $id);

        $variant = ProductVariant::where('sync_id', $id)
            ->where('product_id', $productId)
            ->first();

        $model = !empty($xmlVariant->model)
            ? (string) $xmlVariant->model
            :  collect($this->listProductModel)->first( fn ($item) => $item['product_id'] == $productId)['model'];

        $quantity = !isset($information->quantity) ? 0 : (string) $information->quantity;
        $price = !isset($information->prices->price->currentPrice) ? 0 : (string) $information->prices->price->currentPrice;

        if ($variant) {
            $variant->update([
                'title' => (string) $xmlVariant->title,
                'name_tile' => (string) $xmlVariant->title,
                'slug' => Str::slug((string) $xmlVariant->title),
                'count' => $quantity,
                'price' => $price,
            ]);
        } else {
            $variant = ProductVariant::create([
                'product_id' => $productId,
                'vendor_code' => (string) $xmlVariant->art,
                'model' => $model,
                'title' => (string) $xmlVariant->title,
                'name_tile' => (string) $xmlVariant->title,
                'slug' => Str::slug((string) $xmlVariant->title),
                'count' => $quantity,
                'price' => $price,
                'sync_id' => $id,
            ]);
        }

        $this->productVariantsIds->push([
            'sync_id' => $id,
            'db_id' => $variant->id,
        ]);

        $this->createOrUpdateProductVariantProperty($xmlVariant, $variant, $xmlVariant->categories->id);

        // TODO: сохранение картинок
        $this->createOrUpdateImage($xmlVariant);

        return $variant;
    }

    private function createOrUpdateProductVariantProperty($xmlVariant, $variant, $categoryId): void
    {
        if (!isset($xmlVariant->itemProperties)) return;

        $properties = ((array) $xmlVariant->itemProperties)['itemProperty'];

        $dbCategory = $this->categoryIds
            ->first( fn ($items) => $items['sync_id'] == (string) $categoryId);

        foreach ($properties as $property) {
            $dbProperty = $this->categoryPropertyids
                ->first( fn ($items) => $items['sync_id'] == (string) $property->id);

            if ($dbProperty == null) continue;

            $this->push_unique(
                $this->relationProductCategoryToProperty[$dbCategory['db_id']],
                $dbProperty['db_id']
            );

            $variant->values()->updateOrCreate([
                'product_category_property_id' => $dbProperty['db_id'],
                'value' => (string) $property->value,
            ]);
        }
    }

    private function push_unique(&$array, $value): void
    {
        $array ??= [];

        if (in_array($value, $array)) return;

        $array[] = $value;
    }

    private function tieCategoryToProperty(): void
    {
        foreach ($this->relationProductCategoryToProperty as $categoryId => $properties) {
            $category = ProductCategory::where('id', $categoryId)->first();

            if (!$category) continue;

            $category->properties()->attach($properties);
        }
    }

    private function createOrUpdateImage($xmlVariant): void
    {

    }
}
