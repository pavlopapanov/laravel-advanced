<?php

use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Ajax\Payments\PaypalController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Pages\ThankYouController;
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
Route::get('orders/{vendorOrderId}/thank-you', ThankYouController::class)->name('thank-you');

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

    Route::prefix('paypal')->name('paypal.')->group(function () {
       Route::post('order', [PayPalController::class, 'create'])->name('order.create');
       Route::post('order/{vendorOrderId}/capture', [PayPalController::class, 'capture'])->name('order.capture');
    });
});
