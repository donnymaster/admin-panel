<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Services\AdminPanel\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $service = null;

    public function __construct() {
        $this->service = new CategoryService();
    }

    public function index()
    {
        return view('admin-panel.catalogs.categories');
    }

    public function list(Request $request)
    {
        $search = $request->get('search', '');

       if ($search) {
            return $this->service->getCatgoryWithSearchByProduct($search);
       }

       return $this->service->getCategory();

        // return $this->service->getProductsByCategoryIdWithSearch(1, $search);
    }

    public function products(Request $request, $categoryId)
    {
        return $this->service->getProductsByCategoryId($categoryId);
    }
}
