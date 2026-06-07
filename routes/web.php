<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PelangganController;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route resource berikut dimatikan sementara karena controller terkait belum ada
    // Route::resource('/admin/users', AdminUserController::class);
    // Route::resource('/admin/categories', AdminCategoryController::class);
    // Route::resource('/admin/products', AdminProductController::class);
    // Route::resource('/admin/orders', AdminOrderController::class);
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');

    // Route berikut dimatikan sementara karena controller terkait belum ada
    // Route::resource('/owner/products', OwnerProductController::class);
    // Route::get('/owner/orders', [OwnerOrderController::class, 'index'])->name('owner.orders.index');
    // Route::get('/owner/statistics', [OwnerController::class, 'statistics'])->name('owner.statistics');
    // Route::get('/owner/reviews', [OwnerReviewController::class, 'index'])->name('owner.reviews.index');
});

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', [PelangganController::class, 'index'])->name('pelanggan.dashboard');

    // Route berikut dimatikan sementara karena controller terkait belum ada
    // Route::get('/products', [PelangganProductController::class, 'index'])->name('products.index');
    // Route::post('/orders', [PelangganOrderController::class, 'store'])->name('orders.store');
    // Route::get('/orders', [PelangganOrderController::class, 'index'])->name('orders.index');
    // Route::get('/orders/{order}', [PelangganOrderController::class, 'show'])->name('orders.show');
    // Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
