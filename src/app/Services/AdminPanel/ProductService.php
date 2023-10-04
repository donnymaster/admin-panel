<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Product;

class ProductService
{
    const STATUS_PRODUCT_NEW = 'new';

    const STATUS_PRODUCT_TOP_SELLERS = 'top_sellers';

    const STATUS_PRODUCT_POPULAR = 'popular';

    private $product = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


}
