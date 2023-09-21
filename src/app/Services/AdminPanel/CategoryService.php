<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;

class CategoryService
{
    const PER_PAGE_PRODUCTS = 2;

    public function getCategoryWithPaginate()
    {
        return ProductCategory::with('products')->select(['id', 'parent_id', 'name', 'slug'])->get();
    }

    public function getCatgoryWithPaginateWithSearchByProduct(string $search)
    {
        return ProductCategory::orWhereHas('products', function($query) use ($search) {
            $query->where('name', 'like', "%$search%");
        })->select(['id', 'parent_id', 'name', 'slug'])->get();
    }

    public function getProductsByCategoryId(int $categoryId)
    {
        return Product::where('category_id', $categoryId)->simplePaginate(self::PER_PAGE_PRODUCTS);
    }

    public function getProductsByCategoryIdWithSearch(int $categoryId, string $search)
    {
        return Product::where([
            ['category_id', $categoryId],
            ['name', 'like', "%$search%"]
        ])->simplePaginate(self::PER_PAGE_PRODUCTS)->appends(['search' => $search]);
    }
}
