<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\CategoryDataTable;
use App\DataTables\AdminPanel\ProductCategoryPropertiesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateProductCategoryPropertyRequest;
use App\Http\Requests\AdminPanel\CreateProductCategoryRequest;
use App\Http\Requests\AdminPanel\UpdateProductCategoryPropertyRequest;
use App\Http\Requests\AdminPanel\UpdateProductCategoryRequest;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductCategoryProperty;
use App\Models\AdminPanel\ProductVariant;
use App\Services\AdminPanel\CategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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

    public function update(UpdateProductCategoryRequest $request, ProductCategory $category)
    {
        $category->update($request->safe()->toArray());

        return back()->with('successfully', 'Категория была обновлена!');
    }

    public function create(Request $request)
    {
        $selectedCategoryId = $request->get('category_id');
        $selectedCategory = ProductCategory::where('id', $selectedCategoryId)->first();
        $categories = ProductCategory::all();
        $maxPosition = ProductCategory::max('position', 0);
        $minPosition = ProductCategory::min('position', 0);

        $maxPosition = !$maxPosition ? 0 : $maxPosition;
        $minPosition = !$minPosition ? 1 : $minPosition;

        return view(
            'admin-panel.catalogs.category-create',
            compact('categories', 'selectedCategory', 'maxPosition', 'minPosition')
        );
    }

    public function store(CreateProductCategoryRequest $request)
    {
        //TODO: сохранить кратинку
        // создать категорию
        $category = $this->service->createDefaultCategory($request, true);

        // поменять позиции для других категория
        $this->service->positionRecalculationByCreate($category, $request->get('position'));

        // создать свойства если они существуют
        $this->service->createProductCategoryPropertiesByCategoryId($request, $category);

        return redirect()->route('admin.catalog.categories.page.list');
        // return redirect()->back()->with('successfully-created', 'Категория успешно создана!');
    }

    public function edit(ProductCategoryPropertiesDataTable $dataTable, $id)
    {
        $categories = ProductCategory::where('id', '!=', $id)->select('id', 'name')->get();
        $category = ProductCategory::where('id', $id)->with(['parent', 'children'])->first();

        return $dataTable->setIdCategory($id)->render('admin-panel.catalogs.category', compact('category', 'categories'));
    }

    public function addProperty(ProductCategory $category, int $property)
    {
        $category->properties()->syncWithoutDetaching([$property]);

        return [
            'message' => 'Свойство создано!',
        ];
    }

    public function deleteProperty(ProductCategory $category, ProductCategoryProperty $property)
    {

        $count = Product::where('category_id', $category->id)
            ->whereRelation('variants.values', 'product_category_property_id', $property->id)->count();

        if ($count >= 1) {
            return response(
                ['message' => "Вы не можете отвязать это свойство, потому что оно используется в $count товарах!"],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $category->properties()->detach($property->id);

        return [
            'message' => 'Свойство было удалено!'
        ];
    }

    public function updateProperty(UpdateProductCategoryPropertyRequest $request, $categoryId, ProductCategoryProperty $property)
    {
        $property->update($request->safe()->toArray());

        $property->update(['slug' => Str::slug($request->get('name'))]);

        return [
            'message' => 'Свойство было обновлено!'
        ];
    }

    public function products(Request $request, $categoryId)
    {
        return $this->service->getProductsByCategoryId($categoryId);
    }

    public function page(Request $request, CategoryDataTable $categoryDataTable)
    {

        return $categoryDataTable->setParentId($request->get('parent'))->render('admin-panel.catalogs.category-table');
    }

    public function positionBoundaries()
    {

    }

    public function properties(int $id)
    {
        return ProductCategory::where('id', $id)->with(['properties', 'parent'])->first();
    }

    public function delete(ProductCategory $category)
    {
        $category->properties()->detach();

        try {
            $category->delete();
        } catch (QueryException $th) {
            return response(
                ['message' => 'Ошибка при удалении категории, категория является родительской для другой категории!'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return [
            'message' => 'Категория была удалена!'
        ];
    }
}
