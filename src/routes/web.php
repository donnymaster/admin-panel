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

Route::get('/', function () {
    return view('welcome');
});

Route::view('/components-admin', 'admin-components');

Route::get('/admin/login', [UserController::class, 'login'])->middleware('throttle:10,1'); // максимум 10 запросов в минуту

Route::prefix('admin')->group(function() {
    Route::get('/statistics', [StatisticController::class, 'index']);

    Route::prefix('/statistics')->group(function() {
        Route::get('/', [StatisticController::class, 'index']);
        Route::get('/applications', [ApplicationController::class, 'index']);
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/reviews', [ReviewController::class, 'index']);
    });

    Route::get('/pages', [PagesController::class, 'index']);
    // other statistic pages

    Route::prefix('/catalog')->group(function() {
        Route::get('/', [CatalogController::class, 'index']);

        Route::prefix('/{catalogId}')->group(function() {
            Route::get('/', [CatalogController::class, 'show'])->where('id', '[0-9]+');
            Route::get('/product/{productId}', [ProductController::class, 'index'])->where('id', '[0-9]+');
        });

    });

    Route::get('/data-exchange', [DataExchangeController::class, 'index']);
    // other statistic pages

    Route::get('/settings', [SettingSiteController::class, 'index']);
    // other statistic pages

    Route::get('/users', [UserController::class, 'index']);
});

