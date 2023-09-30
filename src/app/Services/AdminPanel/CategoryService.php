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

    const REQUEST_FIELD_CATEGORY_PROPERTY = 'category-property';

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
        $maxPosition = ProductCategory::max('position');

        $direction = $maxPosition < $position ? 'right' : 'left';

        if ($direction == 'right') {
            ProductCategory::whereBetween('position', [$maxPosition, $position])->decrement('position');
            $category->update(['position' => $position]);
        } else {
            ProductCategory::whereBetween('position', [$position, $maxPosition])->increment('position');
            $category->update(['position' => $position]);
        }
    }

    public function createProductCategoryPropertiesByCategoryId(Request $request, int $categoryId): void
    {
        $properties = $request->get(self::REQUEST_FIELD_CATEGORY_PROPERTY);

        if (!$properties) {
            return;
        }

        foreach ($properties as $property) {
            ProductCategoryProperty::create([
                'name' => $property['name'],
                'description' => $property['description'],
                'product_category_id' => $categoryId,
                'slug' => Str::slug($property['name']),
            ]);
        }
    }
}
