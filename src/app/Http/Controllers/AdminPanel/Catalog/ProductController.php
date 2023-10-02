<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\DataTables\AdminPanel\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductCategoryProperty;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductsDataTable $productsDataTable, Request $request)
    {
        $category = null;
        $categoryId = $request->get('category');

        if ($categoryId) {
            $category = ProductCategory::where('id', $categoryId)->first();
        }

        return $productsDataTable->setCategory($category)->render('admin-panel.products.index', compact('category'));
    }

    public function create(Request $request)
    {
        $categoryId = $request->get('category-id');
        $parentProductId = $request->get('parent');

        $categories = ProductCategory::all(['id', 'name', 'parent_id']);
        $parent = Product::where('id', $parentProductId)->first();
        $category = ProductCategory::where('id', $categoryId)->first();

        return view('admin-panel.products.create', compact('categories', 'categories', 'parent', 'category'));
    }

    public function show(Request $request, $id)
    {
        $product = Product::where('id', $id)->with(['category'])->firstOrFail();
        $properties = ProductCategoryProperty::where('product_category_id', $product->category_id)->get();

        return view('admin-panel.products.product', compact('product', 'properties'));
    }
}
