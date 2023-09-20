<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\AdminPanel\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin-panel.catalogs.categories');
    }

    public function list(Request $request)
    {
        $query = $request->get('search');

        return ProductCategory::with('products')->select(['id', 'parent_id', 'name', 'slug'])->simplePaginate();


    }
}
