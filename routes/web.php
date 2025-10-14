<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::prefix('coupons')->name('coupons.')->group(function () {
    Route::get('/', [CouponController::class, 'index'])->name('index');
    Route::post('/', [CouponController::class, 'store'])->name('store');
    Route::get('/create', [CouponController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CouponController::class, 'update'])->name('update');
    Route::delete('/{id}', [CouponController::class, 'destroy'])->name('destroy');
    Route::post('/applyCoupon', [CouponController::class, 'applyCoupon'])->name('applyCoupon');
    Route::post('/  removeCoupon', [CouponController::class, 'removeCoupon'])->name('removeCoupon');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/checkout', [OrderController::class, 'checkoutForm'])->name('checkoutForm');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');

});

Route::resource('stocks', StockController::class)->except(['index', 'show']);
