<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\ProductCategoryPropertyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateProductCategoryPropertyRequest;
use App\Http\Requests\AdminPanel\UpdateProductCategoryPropertyRequest;
use App\Models\AdminPanel\ProductCategoryProperty;
use App\Services\AdminPanel\AjaxService;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductCategoryPropertyController extends Controller
{
    public function index(ProductCategoryPropertyDataTable $dataTable)
    {
        return $dataTable->render('admin-panel.properties.index');
    }

    public function ajax(Request $request)
    {
        return (new AjaxService(
            $request,
            new ProductCategoryProperty
        ))->ajax();
    }

    public function store(CreateProductCategoryPropertyRequest $request)
    {
        $slug = Str::slug($request->get('name'));

        ProductCategoryProperty::create([
            'slug' => $slug,
            ...$request->safe()->toArray(),
        ]);

        return response([
            'message' => 'Свойство было добавлено!'
        ]);
    }

    public function update(UpdateProductCategoryPropertyRequest $request, ProductCategoryProperty $property)
    {
        $slug = [];
        $name = $request->get('name');

        if ($name) {
            $slug = ['slug' => Str::slug($name)];
        }
        $property->update([
            ...$request->safe()->toArray(),
            ...$slug,
        ]);

        return response([
            'message' => 'Свойство было обновлено!'
        ]);
    }

    public function delete(Request $request, ProductCategoryProperty $property)
    {
        $count = ProductCategoryProperty::where('id', $property->id)->withCount(['values', 'categoryies'])->firstOrFail();

        if ($count->values_count != 0 or $count->categoryies_count != 0) {
            return response([
                'message' => "Вы не можете удалить свойство! Значения: {$count->values_count} Категории: {$count->categoryies_count}"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $count->delete();

        return response([
            'message' => 'Свойство было удалено!'
        ]);
    }
}
