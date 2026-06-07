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

    // Routes admin (sesuai nama route yang dipakai di Blade)
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/admin/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');

    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'saveSettings'])->name('admin.settings.save');
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');

    // Route berikut dimatikan sementara karena controller terkait belum ada
    // Route::resource('/owner/products', OwnerProductController::class);
    // Route::get('/owner/orders', [OwnerOrderController::class, 'index'])->name('owner.orders.index');
    // Route::get('/owner/statistics', [OwnerController::class, 'statistics'])->name('owner.statistics');
    // Route::get('/owner/reviews', [OwnerReviewController::class, 'index'])->name('owner.reviews.index');
});

// Home page (agar / tidak 404)
Route::get('/', [HomeController::class, 'index'])->name('home');

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

    // Checkout & Order
    Route::get('/checkout', [\App\Http\Controllers\PelangganCheckoutController::class, 'index'])
        ->name('checkout');
    Route::post('/orders', [\App\Http\Controllers\PelangganCheckoutController::class, 'store'])
        ->name('orders.store');
});

Route::get('/thankyou/{order}', [\App\Http\Controllers\ThankyouController::class, 'show'])
    ->name('thankyou');

