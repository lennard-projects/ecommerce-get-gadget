<?php

use App\Http\Controllers\admin\CartController as AdminCartController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetCookieMiddleware;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminUserController::class, 'login'])->name('admin.login');

        Route::post('authenticate', [AdminUserController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminUserController::class, 'index'])->name('admin.dashboard');

        Route::get('logout', [AdminUserController::class, 'logout'])->name('admin.logout');

        Route::get('products/createProduct', [AdminProductController::class, 'create'])->name('admin.createProduct');

        Route::post('products', [AdminProductController::class, 'store'])->name('admin.storeProduct');

        Route::get('products', [AdminProductController::class, 'index'])->name('admin.products');

        Route::get('products/{product}/editProduct', [AdminProductController::class, 'edit'])->name('admin.editProduct');

        Route::put('products/{product}', [AdminProductController::class, 'update'])->name('admin.updateProduct');

        Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('admin.deleteProduct');

        Route::get('products/{product}', [AdminProductController::class, 'show'])->name('admin.showProduct');

        Route::get('users', [AdminUserController::class, 'users'])->name('admin.users');

        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('admin.deleteUser');

        Route::get('transactions', [AdminTransactionController::class, 'transactions'])->name('admin.transactions');

        Route::delete('users', [AdminCartController::class, 'destroyUnusedCarts'])->name('admin.deleteUnusedCarts');
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [UserController::class, 'login'])->name('user.login');

        Route::post('authenticate', [UserController::class, 'authenticate'])->name('user.authenticate');

        Route::get('create', [UserController::class, 'create'])->name('user.create');

        Route::post('register', [UserController::class, 'store'])->name('user.store');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
    });

    Route::get('home', [ProductController::class, 'index'])->name('user.home')->middleware(SetCookieMiddleware::class);

    Route::post('addToCart', [CartController::class, 'addToCart'])->name('cart.addToCart');

    Route::get('cart', [CartController::class, 'showCart'])->name('user.cart');

    Route::post('cart/increment', [CartController::class, 'increment'])->name('cart.increment');

    Route::post('cart/decrement', [CartController::class, 'decrement'])->name('cart.decrement');

    Route::delete('cart', [CartController::class, 'removeItem'])->name('cart.removeItem');
});
