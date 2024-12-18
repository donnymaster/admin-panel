<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateProductVariantRequest;
use App\Http\Requests\AdminPanel\UpdateProductVariantRequest;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductVariant;
use App\Models\AdminPanel\ProductVariantImage;
use App\Models\AdminPanel\PropertyValue;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    public function create(Product $product)
    {
        $categories = [];

        $this->getPropertiesCategory(
            ProductCategory::with('properties:id,name,description')
                ->where('id', $product->category_id)->first(),
            $categories
        );

        $categories = array_reverse($categories);

        return view('admin-panel.variants.create', compact('product', 'categories'));
    }

    public function store(CreateProductVariantRequest $request, $productId)
    {
        $val = array_merge(
            $request->safe()->toArray(),
            ['product_id' => $productId]
        );
        $variant = ProductVariant::create($val);

        foreach ($request->get('properties') as $arrays) {
            foreach ($arrays as $property) {
                if ($property['property-value']) {
                    $variant->values()->create([
                        'value' => $property['property-value'],
                        'product_category_property_id' => $property['property-id'],
                    ]);
                }
            }
        }

        // foreach ($request->get('images', []) as $arrays) {
        //     foreach ($arrays as $image) {
        //         ProductVariantImage::where('id', $image['id'])->update(['product_variant_id' => $variant->id]);
        //     }
        // }

        return redirect()->route('admin.products.show', ['product' => $productId]);
    }

    public function remove($productId, ProductVariant $variant)
    {
        // удалить картинки
        // $images = ProductVariantImage::where('product_variant_id', $variant->id)->get();

        // if ($images) {
        //     foreach ($images as $image) {
        //         Storage::delete('public/' . $image->path);
        //     }
        // }

        $variant->delete();

        return [
            'message' => 'Вариант был удален!'
        ];
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        $categories = [];
        $propertyWithCategory = [];

        $this->getPropertiesCategory(
            ProductCategory::with('properties:id,name,description')->where('id', $product->category_id)->first(),
            $categories
        );

        $variantProperty = $variant->values()->get();

        foreach ($categories as $category) {
            $propertyWithCategory[$category->id]['category'] = $category;

            $propertyWithCategory[$category->id]['properties']
                = $category->properties->map(function ($propertyCategory) use ($variantProperty) {

                $search = $variantProperty
                    ->first(fn ($item) => $item->product_category_property_id == $propertyCategory->pivot->property_id);

                if ($search) {
                    $propertyCategory->value = $search;
                    return [
                        $propertyCategory,
                        $search,
                    ];
                }

                return $propertyCategory;
            });
        }

        $propertyWithCategory = array_reverse($propertyWithCategory);

        $imagesRaw = $variant->images()->where('parent_id', null)->with('children')->get();
        $images = [];

        foreach ($imagesRaw as $key => $image) {
            $path = Storage::path('public/' . $image->path);
            list($w, $h) = getimagesize($path);

            $images[$key] = [
                'id' => $image->id,
                'path' => $image->path,
                'size' => $this->formatBytes(Storage::size('public/' . $image->path)),
                'url-path' => Storage::url($image->path),
                'width' => $w,
                'heigth' => $h,
            ];

            foreach ($image->children as $childrenKey => $childrenValue) {
                $pathChildren = Storage::path('public/' . $childrenValue->path);
                list($wC, $hC) = getimagesize($pathChildren);

                $images[$key]['children'][] = [
                    'id' => $childrenValue->id,
                    'path' => $childrenValue->path,
                    'size' => $this->formatBytes(Storage::size('public/' . $childrenValue->path)),
                    'url-path' => Storage::url($childrenValue->path),
                    'width' => $wC,
                    'heigth' => $hC,
                ];
            };
        }

        return view('admin-panel.variants.edit', compact('variant', 'propertyWithCategory', 'images'));
    }

    public function update(UpdateProductVariantRequest $request, $product, ProductVariant $variant)
    {
        $variant->update($request->safe()->toArray());

        foreach ($request->get('properties', []) as $values) {
            foreach ($values as $value) {
                if (isset($value['property-value-id']) && $value['property-value'] != null) {
                    PropertyValue::where('id', $value['property-value-id'])->update(['value' => $value['property-value']]);
                } else if (isset($value['property-value-id']) && $value['property-value'] == null) {
                    PropertyValue::where('id', $value['property-value-id'])->delete();
                }

                if (isset($value['property-value']) && !isset($value['property-value-id'])) {
                    $variant->values()->create([
                        'value' => $value['property-value'],
                        'product_category_property_id' => $value['property-id'],
                    ]);
                }
            }
        }

        // foreach ($request->get('images', []) as $imageList) {
        //     foreach ($imageList as $image) {
        //         ProductVariantImage::where('id', $image['id'])->update(['product_variant_id' => $variant->id]);
        //     }
        // }

        return back()->with('successfully', 'Вариант был обновлен');
    }

    private function getPropertiesCategory(ProductCategory $category, &$array = null)
    {
        array_push($array, $category);

        if ($category->parent_id) {
            $this->getPropertiesCategory(
                ProductCategory::with('properties:id,name,description')
                    ->where('id', $category->parent_id)->first(),
                $array
            );
        }
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
