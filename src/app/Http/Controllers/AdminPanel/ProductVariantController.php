<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductVariantController extends Controller
{
    public function create(Product $product)
    {
        $properties = $this->getPropertiesCategory(
            ProductCategory::with('properties:id,name,description,product_category_id')->where('id', $product->category_id)->first()
        );

        dd(array_reverse(Arr::flatten($properties)));

        return view('admin-panel.variants.create', compact('product'));
    }

    private function getPropertiesCategory(ProductCategory $category)
    {
        $properties = [];

        array_push($properties, $category);

        if ($category->parent_id) {
            $properties[] = $this->getPropertiesCategory(
                ProductCategory::with('properties:id,name,description,product_category_id')->where('id', $category->parent_id)->first(),
            );

        //    $cat = ProductCategory::with('properties:id,name,description,product_category_id')->where('id', $category->parent_id)->first();

        //    if ($cat) {
        //     $properties[] = $cat;
        //    }
        }

        return $properties;
    }
}
