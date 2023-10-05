<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductUniqueValue;
use Illuminate\Http\Request;

class ProductService
{
    const STATUS_PRODUCT_NEW = 'new';

    const STATUS_PRODUCT_TOP_SELLERS = 'top_sellers';

    const STATUS_PRODUCT_POPULAR = 'popular';

    const FIELDS_DEFAULT_CREATE = [
        'name',
        'slug',
        'page_title',
        'vendor_code',
        'category_id',
        'name_tile',
        'page_description',
        'keywords',
        'description',
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

    public function createStatusProduct($data, Product $product = null)
    {
        $currentProduct = $product ? $product : $this->product;

        if (!$currentProduct) {
            return $this;
        }

        if (isset($data['product-type-new'])) {
            ProductUniqueValue::create([
                'product_id' => $currentProduct->id,
                'unique_name' => self::STATUS_PRODUCT_NEW,
                'unique_value' => true,
            ]);
        }

        if (isset($data['product-type-top-sellers'])) {
            ProductUniqueValue::create([
                'product_id' => $currentProduct->id,
                'unique_name' => self::STATUS_PRODUCT_TOP_SELLERS,
                'unique_value' => true,
            ]);
        }

        if (isset($data['product-type-popular'])) {
            ProductUniqueValue::create([
                'product_id' => $currentProduct->id,
                'unique_name' => self::STATUS_PRODUCT_POPULAR,
                'unique_value' => true,
            ]);
        }

        return $this;
    }
}
