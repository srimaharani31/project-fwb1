<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerOrderController;
use App\Http\Controllers\OwnerReviewController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelangganOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\OrderController;


// Route::get('/wel', function () {
//     return view('products');
// });


Route::resource('products', ProductController::class);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/categories', AdminCategoryController::class);
    Route::resource('/admin/orders', AdminOrderController::class);

    // Route::resource('products', ProductController::class);


    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus')->middleware('can:manage-orders');
    
    

    Route::get('/admin/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');   
    Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::delete('/admin/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');   


     
});


Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/orders', [OwnerOrderController::class, 'index'])->name('owner.orders.index');
    Route::get('/owner/statistics', [OwnerController::class, 'statistics'])->name('owner.statistics');
    Route::get('/owner/reviews', [OwnerReviewController::class, 'index'])->name('owner.reviews.index');


    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus')->middleware('can:manage-orders');
    // Route::resource('products', ProductController::class);

    Route::delete('/owner/reviews/{review}', [ReviewController::class, 'destroy'])->name('owner.reviews.destroy');
});

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', [PelangganController::class, 'index'])->name('pelanggan.dashboard');
    Route::post('/orders', [PelangganOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [PelangganOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [PelangganOrderController::class, 'show'])->name('orders.show');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');




    Route::post('/products/{product}/buy', [OrderController::class, 'placeOrder'])->name('products.buy');


    // Route::resource('products', ProductController::class);
});

