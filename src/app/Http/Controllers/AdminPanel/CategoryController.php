<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\CategoryDataTable;
use App\DataTables\AdminPanel\ProductCategoryPropertiesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateProductCategoryRequest;
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

    public function create(Request $request)
    {
        $selectedCategoryId = $request->get('category_id');
        $selectedCategory = ProductCategory::where('id', $selectedCategoryId)->first();
        $categories = ProductCategory::all();
        $maxPosition = ProductCategory::max('position');
        $minPosition = ProductCategory::min('position');

        return view(
            'admin-panel.catalogs.category-create',
            compact('categories', 'selectedCategory', 'maxPosition', 'minPosition')
        );
    }

    public function store(CreateProductCategoryRequest $request)
    {
        // сохранить кратинку

        // создать категорию
        $category = $this->service->createDefaultCategory($request, true);

        // поменять позиции для других категория
        $this->service->positionRecalculationByCreate($category, $request->get('position'));

        // создать свойства если они существуют
        $this->service->createProductCategoryPropertiesByCategoryId($request, $category->id);

        return redirect()->back()->with('successfully-created', 'Категория успешно создана!');
        dd($request->all());
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

    public function properties(int $id)
    {
        return ProductCategory::where('id', $id)->with('properties')->first();
    }
}
