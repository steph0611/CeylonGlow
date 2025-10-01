<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminBookingController;
 

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
        
        // Customer orders
        Route::get('/my-orders', [App\Http\Controllers\CustomerOrderController::class, 'index'])->name('customer.orders.index');
        Route::get('/my-orders/{order}', [App\Http\Controllers\CustomerOrderController::class, 'show'])->name('customer.orders.show');
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

    // Order CRUD
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);

    // Booking CRUD
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::get('/bookings/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.bookings.edit');
    Route::put('/bookings/{id}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');
    Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
});




Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store']);

// Cart (protected by authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/order', [CartController::class, 'placeOrder'])->name('cart.order');
    
    // Checkout routes
    Route::post('/checkout/buy-now', [App\Http\Controllers\CheckoutController::class, 'buyNow'])->name('checkout.buy-now');
    Route::post('/checkout/cart', [App\Http\Controllers\CheckoutController::class, 'cartCheckout'])->name('checkout.cart');
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'processPayment'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});
 

// Static pages
Route::view('/about', 'about')->name('about');
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services');
Route::view('/membership', 'membership')->name('membership');
Route::view('/contact', 'contact')->name('contact');

// Booking routes
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');








 

