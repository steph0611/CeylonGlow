<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminBannerController;

// Home page
Route::get('/', function () {
    // If an admin is logged in, redirect to admin dashboard
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return view('landing');
});

// Normal user login page (force logout if admin)
Route::get('/login', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        Auth::logout(); // logout admin for normal login
    }
    return view('auth.login'); // normal user login
})->name('login');

// Customer dashboard (protected)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    });

// API user endpoint
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin login page (force logout normal user)
Route::get('/login/admin', function () {
    if (auth()->check() && !auth()->user()->is_admin) {
        Auth::logout(); // logout normal user for admin login
    }
    return view('admin.login');
})->name('admin.login');

// Admin login POST handled by Fortify
Route::post('/login/admin', [AuthenticatedSessionController::class, 'store'])
    ->name('admin.login.submit');

// Admin routes (protected by auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});




Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store']);

// Static pages
Route::view('/about', 'about')->name('about');
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services');
Route::view('/membership', 'membership')->name('membership');
Route::view('/contact', 'contact')->name('contact');







Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminProductController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::delete('/dashboard/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
});


Route::prefix('admin')->group(function () {
    // Dashboard that shows both products & banners
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminBannerController::class, 'index'])->name('admin.dashboard');

    // Product CRUD
    Route::get('/products/create', [App\Http\Controllers\Admin\AdminProductController::class, 'create'])->name('admin.products.create');
    Route::get('/products/{id}/edit', [App\Http\Controllers\Admin\AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('/products', [App\Http\Controllers\Admin\AdminProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{id}', [App\Http\Controllers\Admin\AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // Banner CRUD
    Route::post('/banners', [App\Http\Controllers\Admin\AdminBannerController::class, 'store'])->name('admin.banners.store');
    Route::delete('/banners/{banner}', [App\Http\Controllers\Admin\AdminBannerController::class, 'destroy'])->name('admin.banners.destroy');

    // Service CRUD
    Route::get('/services', [App\Http\Controllers\Admin\AdminServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/services/create', [App\Http\Controllers\Admin\AdminServiceController::class, 'create'])->name('admin.services.create');
    Route::post('/services', [App\Http\Controllers\Admin\AdminServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/services/{id}/edit', [App\Http\Controllers\Admin\AdminServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/services/{id}', [App\Http\Controllers\Admin\AdminServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/services/{id}', [App\Http\Controllers\Admin\AdminServiceController::class, 'destroy'])->name('admin.services.destroy');
});

