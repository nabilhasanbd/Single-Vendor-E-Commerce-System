<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ProductWebController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\CartWebController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Web\CartWebController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Web\CartWebController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Web\CartWebController::class, 'destroy'])->name('destroy');
    });

    // Checkout Routes
    Route::get('/checkout', [\App\Http\Controllers\Web\CheckoutWebController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\Web\CheckoutWebController::class, 'store'])->name('checkout.store');

    // Orders Routes
    Route::get('/orders', [\App\Http\Controllers\Web\CheckoutWebController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Web\CheckoutWebController::class, 'showOrder'])->name('orders.show');

    // SSLCommerz Web Hooks (Placeholders)
    Route::get('/payment/success', [\App\Http\Controllers\Web\CheckoutWebController::class, 'sslSuccess'])->name('payment.success');
    Route::get('/payment/fail', [\App\Http\Controllers\Web\CheckoutWebController::class, 'sslFail'])->name('payment.fail');
    Route::get('/payment/cancel', [\App\Http\Controllers\Web\CheckoutWebController::class, 'sslCancel'])->name('payment.cancel');
});

// User Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductWebController::class, 'index'])->name('products.index');
    Route::get('/{id}', [ProductWebController::class, 'show'])->name('products.show');
});

use App\Http\Controllers\Web\CategoryWebController;

// Admin Control Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/create', [ProductWebController::class, 'create'])->name('create');
    Route::post('/', [ProductWebController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProductWebController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductWebController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductWebController::class, 'destroy'])->name('destroy');
});

// Admin Category Routes
Route::middleware(['auth', 'admin'])->prefix('admin/categories')->name('admin.categories.')->group(function () {
    Route::get('/create', [CategoryWebController::class, 'create'])->name('create');
    Route::post('/', [CategoryWebController::class, 'store'])->name('store');
});
