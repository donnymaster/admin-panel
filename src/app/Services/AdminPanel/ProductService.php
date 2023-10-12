<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductUniqueValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductService
{
    const STATUS_PRODUCT_NEW = 'new';

    const STATUS_PRODUCT_TOP_SELLERS = 'top_sellers';

    const STATUS_PRODUCT_POPULAR = 'popular';

    const FIELDS_DEFAULT_CREATE = [
        'title',
        'slug',
        'page_title',
        'vendor_code',
        'category_id',
        'name_tile',
        'page_description',
        'keywords',
        'description',
        'visible',
    ];

    private $product = null;

    public function __construct(Product $product = null)
    {
        $this->product = $product;
    }

    public function create(Request $request)
    {
        $this->product = Product::create(
            $request->only(self::FIELDS_DEFAULT_CREATE)
        );

        return $this;
    }

    public function setVisibleProduct($status)
    {
        $this->product->update(['visible' => $status]);

        return $this;
    }

    public function when($val, $callback)
    {
        if ($val) {
            $callback($this);
        }

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function updatePositionProduct($position, Product $product = null)
    {
        $currentProduct = $product ? $product : $this->product;
        $categoryId = $currentProduct->category_id;

        $maxPosition = Product::where('category_id', $categoryId)->max('position_in_category');

        if ($maxPosition == 0) {
            $currentProduct->update(['position_in_category' => 1]);
            return $this;
        }

        $direction = $maxPosition < $position ? 'right' : 'left';

        if ($direction == 'right') {
            Product::where('category_id', $categoryId)
                ->whereBetween('position_in_category', [$maxPosition, $position])->decrement('position_in_category');
            $currentProduct->update(['position_in_category' => $position]);
        } else {
            Product::where('category_id', $categoryId)
                ->whereBetween('position_in_category', [$position, $maxPosition])->increment('position_in_category');
            $currentProduct->update(['position_in_category' => $position]);
        }

        return $this;
    }

    public function createStatusProduct($data, Product $product = null)
    {
        $currentProduct = $product ? $product : $this->product;

        if (!$currentProduct) {
            return $this;
        }

        if (isset($data['product-type-new'])) {
            ProductUniqueValue::create([
                'product_id' => $currentProduct->id,
                'unique_name' => 'новый',
                'unique_slug' => self::STATUS_PRODUCT_NEW,
                'unique_value' => true,
            ]);
        }

        if (isset($data['product-type-top-sellers'])) {
            ProductUniqueValue::create([
                'product_id' => $currentProduct->id,
                'unique_name' => 'топ продаж',
                'unique_slug' => self::STATUS_PRODUCT_TOP_SELLERS,
                'unique_value' => true,
            ]);
        }

        if (isset($data['product-type-popular'])) {
            ProductUniqueValue::create([
                'product_id' => $currentProduct->id,
                'unique_name' => 'популярный',
                'unique_slug' => self::STATUS_PRODUCT_POPULAR,
                'unique_value' => true,
            ]);
        }

        return $this;
    }

    public function createUnuqieProperty(Request $request)
    {
        $properties = $request->get('product-unique-property');

        if ($properties) {
            foreach ($properties as $propertry) {
                ProductUniqueValue::create([
                    'product_id' => $this->product->id,
                    'unique_name' => $propertry['name'],
                    'unique_slug' => Str::slug($propertry['name']),
                    'unique_value' => $propertry['value'],
                ]);
            }
        }

        return $this;
    }
}
