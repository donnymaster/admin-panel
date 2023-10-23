<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductCategoryProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryService
{
    const PER_PAGE_PRODUCTS = 10;

    const EXCLUDED_FIELDS_CREATE_PRODUCT_CATEGORY = [
        'image',
        'category-property',
    ];

    const REQUEST_FIELD_CATEGORY_PROPERTY = 'categories-properties';

    public function getCategory()
    {
        return ProductCategory::select(['id', 'parent_id', 'name', 'slug', 'position'])->get();
    }

    public function getCatgoryWithSearchByProduct(string $search)
    {
        return ProductCategory::orWhereHas('products', function($query) use ($search) {
            $query->where('name', 'like', "%$search%");
        })->select(['id', 'parent_id', 'name', 'slug'])->get();
    }

    public function getProductsByCategoryId(int $categoryId)
    {
        return Product::where('category_id', $categoryId)->paginate(self::PER_PAGE_PRODUCTS);
    }

    public function getProductsByCategoryIdWithSearch(int $categoryId, string $search)
    {
        return Product::where([
            ['category_id', $categoryId],
            ['name', 'like', "%$search%"]
        ])->simplePaginate(self::PER_PAGE_PRODUCTS)->appends(['search' => $search]);
    }

    public function createDefaultCategory(Request $request, bool $isShadowPosition = false): ProductCategory
    {
        $data = $request->except(self::EXCLUDED_FIELDS_CREATE_PRODUCT_CATEGORY);

        if ($isShadowPosition) {
            $data['position'] = 0;
        }

        return ProductCategory::create($data);
    }

    public function positionRecalculationByCreate(ProductCategory $category, int $position): void
    {
        $maxPosition = 0;
        $categoryId = $category->parent_id;

        if ($categoryId ) {
            $maxPosition = ProductCategory::where('parent_id', $categoryId)->max('position');
        } else {
            $maxPosition = ProductCategory::max('position');
        }

        if ($maxPosition == 0) {
            $category->update(['position' => 1]);
            return;
        }

        $direction = $maxPosition < $position ? 'right' : 'left';

        if ($direction == 'right') {
            ProductCategory::when($categoryId , function($query) use ($categoryId) {
                $query->where('parent_id', $categoryId);
            })->whereBetween('position', [$maxPosition, $position])->decrement('position');
            $category->update(['position' => $position]);
        } else {
            ProductCategory::when($categoryId, function($query) use ($categoryId) {
                $query->where('parent_id', $categoryId);
            })->whereBetween('position', [$position, $maxPosition])->increment('position');
            $category->update(['position' => $position]);
        }
    }

    public function createProductCategoryPropertiesByCategoryId(Request $request, ProductCategory $category): void
    {
        $properties = $request->get(self::REQUEST_FIELD_CATEGORY_PROPERTY);

        if (!$properties) {
            return;
        }

        foreach ($properties as $propertyId) {
            $category->properties()->attach($propertyId);
        }
    }
}
