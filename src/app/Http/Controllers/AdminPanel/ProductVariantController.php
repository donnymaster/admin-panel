<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateProductVariantRequest;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductVariant;
use App\Models\AdminPanel\ProductVariantImage;
use App\Models\AdminPanel\PropertyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    public function create(Product $product)
    {
        $categories = [];

        $this->getPropertiesCategory(
             ProductCategory::with('properties:id,name,description,product_category_id')->where('id', $product->category_id)->first(),
            $categories
        );

        $categories = array_reverse($categories);

        return view('admin-panel.variants.create', compact('product', 'categories'));
    }

    public function store(CreateProductVariantRequest $request, $productId)
    // public function store(Request $request)
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

        foreach ($request->get('images', []) as $arrays) {
            foreach ($arrays as $image) {
                ProductVariantImage::where('id', $image['id'])->update(['product_variant_id' => $variant->id]);
            }
        }

        return redirect()->route('admin.products.show', ['product' => $productId]);

    }

    public function remove($productId, ProductVariant $variant)
    {
        // удалить картинки
        $images = ProductVariantImage::where('product_variant_id', $variant->id)->get();

        if ($images) {
            foreach ($images as $image) {
                Storage::delete('public/'.$image->path);
            }
        }

        $variant->delete();

        return [
            'message' => 'Вариант был удален!'
        ];
    }

    private function getPropertiesCategory(ProductCategory $category, &$array = null)
    {
        array_push($array, $category);

        if ($category->parent_id) {
            $this->getPropertiesCategory(
                ProductCategory::with('properties:id,name,description,product_category_id')->where('id', $category->parent_id)->first(),
                $array
            );
        }
    }

}
