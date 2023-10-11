<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\AdminPanel\Product;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function create(Product $product)
    {
        return view('admin-panel.variants.create');
    }
}
