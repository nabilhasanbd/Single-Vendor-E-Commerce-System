<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ProductWebController;
use App\Http\Controllers\Web\CategoryWebController;
use App\Http\Controllers\Web\CartWebController;
use App\Http\Controllers\Web\CheckoutWebController;

// Public Public Routes (Landing Page)
Route::get('/', [ProductWebController::class, 'index'])->name('products.index');
Route::get('/products', [ProductWebController::class, 'index']); // Fallback
Route::get('/products/{id}', [ProductWebController::class, 'show'])->name('products.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('/profile', 'profile')->name('profile');

    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartWebController::class, 'index'])->name('index');
        Route::post('/', [CartWebController::class, 'store'])->name('store');
        Route::put('/{id}', [CartWebController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartWebController::class, 'destroy'])->name('destroy');
    });

    // Checkout Routes
    Route::get('/checkout', [CheckoutWebController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutWebController::class, 'store'])->name('checkout.store');

    // Orders Routes
    Route::get('/orders', [CheckoutWebController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [CheckoutWebController::class, 'showOrder'])->name('orders.show');

    // SSLCommerz Web Hooks (Placeholders)
    Route::get('/payment/success', [CheckoutWebController::class, 'sslSuccess'])->name('payment.success');
    Route::get('/payment/fail', [CheckoutWebController::class, 'sslFail'])->name('payment.fail');
    Route::get('/payment/cancel', [CheckoutWebController::class, 'sslCancel'])->name('payment.cancel');
});

// Admin Control Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/create', [ProductWebController::class, 'create'])->name('create');
        Route::post('/', [ProductWebController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductWebController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductWebController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductWebController::class, 'destroy'])->name('destroy');
    });

    // Categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/create', [CategoryWebController::class, 'create'])->name('create');
        Route::post('/', [CategoryWebController::class, 'store'])->name('store');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [CheckoutWebController::class, 'adminOrders'])->name('index');
        Route::put('/{id}/status', [CheckoutWebController::class, 'updateOrderStatus'])->name('update-status');
    });
});
