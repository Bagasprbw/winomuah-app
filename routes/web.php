<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortofolioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home'); // akan load resources/js/Pages/Home.vue
});

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

