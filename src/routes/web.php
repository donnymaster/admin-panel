<?php

use App\Http\Controllers\AdminPanel\ApplicationController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogController;
use App\Http\Controllers\AdminPanel\Catalog\ProductController;
use App\Http\Controllers\AdminPanel\DataExchangeController;
use App\Http\Controllers\AdminPanel\OrderController;
use App\Http\Controllers\AdminPanel\PagesController;
use App\Http\Controllers\AdminPanel\ReviewController;
use App\Http\Controllers\AdminPanel\SettingSiteController;
use App\Http\Controllers\AdminPanel\StatisticController;
use App\Http\Controllers\AdminPanel\UserController;
use App\Models\AdminPanel\MenuLink;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function() {
    Route::prefix('/statistics')->group(function() {
        Route::get('/board', [StatisticController::class, 'index'])->name('board');
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
    });

    Route::get('/pages', [PagesController::class, 'index'])->name('pages');
    Route::get('/pages-list', [PagesController::class, 'pageList'])->name('page.list');
    Route::get('/pages/{pageId}', [PagesController::class, 'index'])->name('page');

    Route::prefix('/catalog')->group(function() {
        Route::get('/', [CatalogController::class, 'index'])->name('catalogs');

        Route::prefix('/{catalogId}')->group(function() {
            Route::get('/', [CatalogController::class, 'show'])->where('id', '[0-9]+')->name('catalog');
            Route::get('/product/{productId}', [ProductController::class, 'index'])->where('id', '[0-9]+')->name('product');
        });

    });

    Route::get('/data-exchange', [DataExchangeController::class, 'index'])->name('data-exchange');
    // other statistic pages

    Route::get('/settings', [SettingSiteController::class, 'index'])->name('settings');
    // other statistic pages

    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::view('/components-admin', 'admin-components');

Route::get('routes', function () {

    dd(MenuLink::where('id', 1)->with('parent')->get());

    $routeCollection = Route::getRoutes();

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

