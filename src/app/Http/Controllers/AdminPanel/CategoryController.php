<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\CategoryDataTable;
use App\DataTables\AdminPanel\ProductCategoryPropertiesDataTable;
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

    public function create()
    {
        return view('admin-panel.catalogs.category-create');
    }

    public function show(ProductCategoryPropertiesDataTable $dataTable, $id)
    {
        $categories = ProductCategory::select('id', 'name')->get();
        $category = ProductCategory::where('id', $id)->with(['parent', 'children'])->first();

        return $dataTable->setIdCategory($id)->render('admin-panel.catalogs.category', compact('category', 'categories'));
    }

    public function products(Request $request, $categoryId)
    {
        return $this->service->getProductsByCategoryId($categoryId);
    }

    public function page(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('admin-panel.catalogs.category-table');
    }
}
