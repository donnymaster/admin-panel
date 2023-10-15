<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\DataTables\AdminPanel\ProductsDataTable;
use App\DataTables\AdminPanel\ProductUniquePropertyDataTable;
use App\DataTables\AdminPanel\ProductVariantsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateProductRequest;
use App\Http\Requests\AdminPanel\CreateProductUniquePropertyRequest;
use App\Http\Requests\AdminPanel\UpdateProductRequest;
use App\Http\Requests\AdminPanel\UpdateProductUniquePropertyRequest;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\ProductCategoryProperty;
use App\Models\AdminPanel\ProductUniqueValue;
use App\Models\AdminPanel\ProductVariant;
use App\Models\AdminPanel\ProductVariantImage;
use App\Services\AdminPanel\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $productService = null;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index(ProductsDataTable $productsDataTable, Request $request)
    {
        $category = null;
        $categoryId = $request->get('category');

        if ($categoryId) {
            $category = ProductCategory::where('id', $categoryId)->first();
        }

        return $productsDataTable->setCategory($category)->render('admin-panel.products.index', compact('category'));
    }

    public function create(Request $request)
    {
        $categoryId = $request->get('category-id');
        $parentProductId = $request->get('parent-id');

        $categories = ProductCategory::all(['id', 'name', 'parent_id']);

        $parent = Product::where('id', $parentProductId)->first();
        $category = ProductCategory::where('id', $categoryId)->first();

        return view('admin-panel.products.create', compact('categories', 'categories', 'parent', 'category'));
    }

    public function show(
        Request $request,
        $id,
        ProductVariantsDataTable $productVariantsDataTable,
        ProductUniquePropertyDataTable $productUniquePropertyDataTable
    ) {
        $product = Product::where('id', $id)->with(['category'])->firstOrFail();

        $countProperties = $this->getCountProperties(ProductCategory::where('id', $product->category_id)->first());

        if ($request->get('table') == 'variants') {
            return $productVariantsDataTable->setProduct($product)->render('admin-panel.products.product');
        }

        if ($request->get('table') == 'unique') {
            return $productUniquePropertyDataTable->setProduct($product)->render('admin-panel.products.product');
        }


        return view(
            'admin-panel.products.product',
            [
                'countProperties' => $countProperties,
                'product' => $product,
                'variantsTable' => $productVariantsDataTable->setProduct($product)->html()->ajax('?table=variants'),
                'productUniquePropertyTable' => $productUniquePropertyDataTable->setProduct($product)->html()->ajax('?table=unique')
            ]
        );
    }

    private function getCountProperties(ProductCategory $category)
    {
        $countProperties = 0;

        $countProperties = ProductCategory::where('id', $category->id)->withCount('properties')->first()->properties_count;

        if ($category->parent_id) {
            $countProperties += $this->getCountProperties(
                ProductCategory::where('id', $category->parent_id)->first()
            );
        }

        return $countProperties;
    }

    public function store(CreateProductRequest $request)
    {
        $product = $this->productService
            ->create($request)
            ->createStatusProduct($request)
            ->updatePositionProduct($request->get('position_in_category'))
            ->createUnuqieProperty($request)
            ->getProduct();

        return redirect()->route('admin.products.show', ['product' => $product->id]);
    }

    public function remove(Product $product)
    {
        $product->variants()->get()->each(function ($variant) {
            $images = ProductVariantImage::where('product_variant_id', $variant->id)->get();

            foreach ($images as $image) {
                Storage::delete('public/'.$image->path);
            }

            $variant->values()->delete();
        });

        $product->delete();

        return [
            'message' => 'Продукт был удален!'
        ];
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $product->update($request->safe()->toArray());

        if ($request->isJson()) {
            return [
                'message' => 'Товар был обновлен!'
            ];
        }

        return back()->with('successfully', 'Товар была обновлена!');
    }

    public function productVariants(Request $request)
    {
        $limit = $request->get('limit', 10);

        $search = $request->get('search');

        $variants = ProductVariant::select('id', 'title')->limit($limit)->when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%$search%");
        })->get();

        return response($variants);
    }

    public function createUniqueProperty(CreateProductUniquePropertyRequest $request, $id)
    {
        ProductUniqueValue::create(
            array_merge(
                $request->safe()->toArray(),
                [
                    'unique_slug' => Str::slug($request->get('unique_name')),
                    'product_id' => $id,
                ],
            )
        );

        return [
            'message' => 'Уникальное свовойство было добавлено!'
        ];

    }

    public function deleteUniqueProperty($id, ProductUniqueValue $property)
    {
        $property->delete();

        return [
            'message' => 'Уникальное свойство было удалено!'
        ];
    }

    public function updateUniqueProperty(UpdateProductUniquePropertyRequest $request, $id, ProductUniqueValue $property)
    {
        $property->update($request->except(['unique_name']));
        $name = $request->get('unique_name');

        if ($name) {
            $searchProperty = ProductUniqueValue::where('unique_name', $name)->first();

            if ($searchProperty) {
                if ($searchProperty->id != $property->id) {
                    return response([
                        'message' => 'Имя должно быть уникальным!'
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }

            $property->update(['unique_slug' => Str::slug($name)]);
        }



        return [
            'message' => 'Уникальное свойство было обновлено!'
        ];
    }
}
