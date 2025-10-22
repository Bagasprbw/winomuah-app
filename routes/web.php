<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Models\Company;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ===============================
// FRONTEND ROUTES (DODI)
// ===============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'publicIndex'])->name('frontend.products.index');
Route::get('/products/{product}', [ProductController::class, 'publicShow'])->name('frontend.products.show');
Route::get('/portofolio', [PortofolioController::class, 'publicIndex'])->name('frontend.portofolio.index');

// ===============================
// LOGIN & AUTH ROUTES
// ===============================
Route::get('/login', function () {
    $company = Company::first();
    return Inertia::render('Auth/Login', [
        'company' => $company
    ]);
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ===============================
// ADMIN ROUTES (DIBERI MIDDLEWARE AUTH)
// ===============================
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);
    Route::patch('/products/{product}/publish', [ProductController::class, 'togglePublish'])
        ->name('products.toggle-publish');

    // Portofolio
    Route::resource('portofolio', PortofolioController::class);
    Route::patch('/portofolio/{portofolio}/publish', [PortofolioController::class, 'togglePublish'])
        ->name('portofolio.toggle-publish');

    // Company
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company/update', [CompanyController::class, 'update'])->name('company.update');

    // Categories
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
});
