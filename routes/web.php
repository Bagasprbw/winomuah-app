<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

// ===============================
// FRONTEND PRODUCT ROUTES
// ===============================
Route::get('/products', [ProductController::class, 'publicIndex'])->name('frontend.products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('frontend.products.show');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    // 👇 route khusus ubah status publish
    Route::patch('/products/{product}/publish', [ProductController::class, 'togglePublish'])
        ->name('products.toggle-publish');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::resource('portfolio', PortfolioController::class);

});
