<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

// ===============================
// FRONTEND PRODUCT ROUTES (DODI)
// ===============================
Route::get('/products', [ProductController::class, 'publicIndex'])->name('frontend.products.index');
Route::get('/products/{product}', [ProductController::class, 'publicShow'])->name('frontend.products.show');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    // 👇 route khusus ubah status publish
    Route::patch('/products/{product}/publish', [ProductController::class, 'togglePublish'])
        ->name('products.toggle-publish');

    Route::resource('portofolio', PortofolioController::class);
    // 👇 route khusus ubah status publish
    Route::patch('/portofolio/{portofolio}/publish', [PortofolioController::class, 'togglePublish'])
        ->name('portofolio.toggle-publish');

    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company/update', [CompanyController::class, 'update'])->name('company.update');

    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
});
