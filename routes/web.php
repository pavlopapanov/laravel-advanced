<?php

use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

Auth::routes();

Route::resource('products', \App\Http\Controllers\ProductsController::class)
    ->only(['index', 'show']);

Route::name('cart.')->prefix('cart')->group(function () {
   Route::get('/', [CartController::class, 'index'])->name('index');
   Route::post('{product}', [CartController::class, 'add'])->name('add');
   Route::delete('/', [CartController::class, 'remove'])->name('remove');
   Route::put('{product}', [CartController::class, 'update'])->name('update');
});

Route::get('checkout', CheckoutController::class)->name('checkout');

Route::name('admin.')->prefix('admin')->middleware('role:admin|moderator')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('categories', CategoriesController::class)->except(['show']);
    Route::resource('attributes', AttributesController::class)->except(['show']);
    Route::resource('products', ProductsController::class)->except(['show']);
});

Route::name('ajax.')->prefix('ajax')->group(function () {
    Route::middleware('auth', 'role:admin|moderator')->group(function () {
        Route::delete('images/{image}', \App\Http\Controllers\Ajax\RemoveImageController::class)->name('images.remove');
    });
});
