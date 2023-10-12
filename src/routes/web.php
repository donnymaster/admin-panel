<?php

use App\Http\Controllers\AdminPanel\AccountController;
use App\Http\Controllers\AdminPanel\ApplicationController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogController;
use App\Http\Controllers\AdminPanel\Catalog\ProductController;
use App\Http\Controllers\AdminPanel\CategoryController;
use App\Http\Controllers\AdminPanel\DataExchangeController;
use App\Http\Controllers\AdminPanel\ImageProcessingController;
use App\Http\Controllers\AdminPanel\OrderController;
use App\Http\Controllers\AdminPanel\PagesController;
use App\Http\Controllers\AdminPanel\ProductReviewController;
use App\Http\Controllers\AdminPanel\ProductVariantController;
use App\Http\Controllers\AdminPanel\PromocodeController;
use App\Http\Controllers\AdminPanel\ReviewController;
use App\Http\Controllers\AdminPanel\SettingSiteController;
use App\Http\Controllers\AdminPanel\StatisticController;
use App\Http\Controllers\AdminPanel\UserController;
use App\Models\AdminPanel\AdminRole;
use App\Models\AdminPanel\MenuLink;
use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use App\Models\AdminPanel\Review;
use App\Models\AdminPanel\Statistic;
use App\Models\User;
use App\Services\AdminPanel\ApplicationService;
use App\Services\AdminPanel\SiteSettingService;
use App\Services\AdminPanel\StatisticService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin/login', [UserController::class, 'login'])->middleware('guest')->name('get.login');
Route::post('/admin/login', [UserController::class, 'loginHandler'])->middleware('throttle:10,1')->name('post.login'); // максимум 10 запросов в минуту

Route::middleware(['auth', 'admin.visible'])->name('admin.')->prefix('admin')->group(function() {
    Route::prefix('/statistics')->group(function() {
        Route::get('/', [StatisticController::class, 'index'])->name('board');
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
        Route::get('/applications/date-limit', [ApplicationController::class, 'dateLimit'])->name('applications.date-limit');
        Route::get('/applications/reviews-info', [ApplicationController::class, 'getInformationReviews'])->name('applications.reviews-info');
        Route::get('/applications/info', [ApplicationController::class, 'info'])->name('applications.info');

        Route::patch('/applications/{application}', [ApplicationController::class, 'store'])->name('applications.store')->where('application', '[0-9]+');
        Route::delete('/applications/{application}', [ApplicationController::class, 'remove'])->name('applications.remove')->where('application', '[0-9]+');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/change-status', [OrderController::class, 'changeStatus'])->name('orders.change-status');

        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
        Route::patch('/reviews/{review}', [ReviewController::class, 'store'])->name('reviews.store')->where('review', '[0-9]+');
        Route::delete('/reviews/{review}', [ReviewController::class, 'remove'])->name('reviews.remove')->where('review', '[0-9]+');
    });

    Route::get('/pages', [PagesController::class, 'index'])->name('pages');
    Route::get('/pages/date-limit', [PagesController::class, 'getValidDatePeriod'])->name('pages.date-limit');
    Route::get('/pages/create', [PagesController::class, 'create'])->name('page.create');
    Route::post('/page/store', [PagesController::class, 'store'])->name('page.store');
    Route::get('/pages-list', [PagesController::class, 'pageList'])->name('page.list');
    Route::get('/pages/valid-pages', [PagesController::class, 'validPages'])->name('page.valid-pages');
    Route::get('/pages/info-visit', [StatisticController::class, 'informationPages'])->name('pages.info-visits');
    Route::get('/pages/{pageId}', [PagesController::class, 'index'])->name('page');

    Route::prefix('/catalog')->group(function() {
        Route::get('/promocodes', [PromocodeController::class, 'index'])->name('promocode.index');
        Route::post('/promocodes', [PromocodeController::class, 'store'])->name('promocode.store');
        Route::delete('/promocodes/{promocode}', [PromocodeController::class, 'delete'])->name('promocode.delete');
        Route::patch('/promocodes/{promocode}', [PromocodeController::class, 'update'])->name('promocode.update');

        Route::get('/categories', [CategoryController::class, 'index'])->name('catalog.categories.show');
        Route::get('/categories/new', [CategoryController::class, 'create'])->name('catalog.categories.new');
        Route::post('/categories/new', [CategoryController::class, 'store'])->name('catalog.categories.store');
        Route::get('/categories/{category}', [CategoryController::class, 'edit'])->name('catalog.category.edit');
        Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('catalog.category.update');
        Route::post('/categories/{category}/addProperty', [CategoryController::class, 'addProperty'])->name('catalog.category.addProperty');
        Route::delete('/categories/{category}/property/{property}', [CategoryController::class, 'deleteProperty'])->name('catalog.category.deleteProperty');
        Route::patch('/categories/{category}/property/{property}', [CategoryController::class, 'updateProperty'])->name('catalog.category.updateProperty');

        Route::get('/categories/{category}/properties', [CategoryController::class, 'properties'])->name('catalog.category.properties');
        Route::get('/categories/list', [CategoryController::class, 'list'])->name('catalog.categories.list');
        Route::get('/categories/page/list', [CategoryController::class, 'page'])->name('catalog.categories.page.list');

        Route::get('/categories/{category}/products', [CategoryController::class, 'products'])->name('catalog.category.products');
        Route::get('/', [CategoryController::class, 'index'])->name('catalogs');

        Route::get('/products', [ProductController::class, 'index'])->where('id', '[0-9]+')->name('products');
        Route::get('/products/create', [ProductController::class, 'create'])->where('id', '[0-9]+')->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->where('id', '[0-9]+')->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->where('id', '[0-9]+')->name('products.show');
        Route::get('/product-variants', [ProductController::class, 'productVariants'])->name('product-variants');

        Route::post('/products/{product}/unique-properties', [ProductController::class, 'createUniqueProperty'])->name('products.unique-property.create');
        Route::delete('/products/{product}/unique-properties/{property}', [ProductController::class, 'deleteUniqueProperty'])->name('products.unique-property.delete');
        Route::patch('/products/{product}/unique-properties/{property}', [ProductController::class, 'updateUniqueProperty'])->name('products.unique-property.update');

        Route::get('/products/{product}/variants', [ProductVariantController::class, 'create'])->name('products.variants.create');


        Route::get('/product-reviews', [ProductReviewController::class, 'index'])->name('product-reviews.index');
        Route::patch('/product-reviews/{review}', [ProductReviewController::class, 'update'])->name('product-reviews.update');
        Route::delete('/product-reviews/{review}', [ProductReviewController::class, 'delete'])->name('product-reviews.delete');


        Route::prefix('/{catalogId}')->group(function() {
            Route::get('/', [CatalogController::class, 'show'])->where('id', '[0-9]+')->name('catalog');
            Route::get('/product/{productId}', [ProductController::class, 'index'])->where('id', '[0-9]+')->name('product');
        });
    });

    Route::post('/image/save', [ImageProcessingController::class, 'save'])->name('image.save');
    Route::post('/image/save/resize', [ImageProcessingController::class, 'saveResizeImage'])->name('image.save-resize');
    Route::delete('/image/remove', [ImageProcessingController::class, 'delete'])->name('image.delete');

    Route::get('/data-exchange', [DataExchangeController::class, 'index'])->name('data-exchange');
    // other statistic pages

    Route::get('/settings', [SettingSiteController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingSiteController::class, 'store'])->name('settings.store');
    Route::patch('/settings/{setting}', [SettingSiteController::class, 'update'])->name('settings.update');
    Route::delete('/settings/{setting}', [SettingSiteController::class, 'remove'])->name('settings.remove');

    // other statistic pages

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'delete'])->name('users.delete');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::view('/components-admin', 'admin-components');

Route::get('routes', function () {

    // dd(file_exists('/var/www/laravel/storage/app/public/product/1/variants/harHeOUrNfhI3iv3EC4V3KhQRATII5HjO4PYa6Yl.png'));
    // dd(Storage::url('product/1/variants/harHeOUrNfhI3iv3EC4V3KhQRATII5HjO4PYa6Yl.png'));
    // dd(StatisticService::getUniqueVisitors());
    // dd(Str::slug('картинка 2'));
    // dd(Product::with('variants')->first());
    // dd(ProductCategory::with(['parent', 'children'])->get());
    // $service = new SiteSettingService();
    // dd($service->getValueVariable('redaktor-tiny-url'));
    // dd(ApplicationService::getNumberUnprocessedApplication());
    // dd(FacadesRequest::ip(), FacadesRequest::userAgent());
    $routeCollection = Route::getRoutes();
    // $agent = new Agent();
    // dd($agent->isPhone(), $agent->browser(), $agent->platform(), $agent->version($agent->platform()), $agent->version($agent->browser()), $agent->languages());
    // dd(Auth::user()->isSuperAdmin());
    // dd(Location::get('217.199.231.202'));



    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});

