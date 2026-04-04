<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;

// Auth Module Routes
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Cart Routes (Protected)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);
    
    // User Profile
    Route::get('/v1/user', function (Request $request) {
        return $request->user();
    });

    // Cart
    Route::prefix('v1/cart')->group(function () {
        Route::get('/', [\App\Http\Controllers\API\CartController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\API\CartController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\API\CartController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\API\CartController::class, 'destroy']);
    });

    // Checkout & Orders
    Route::post('/v1/checkout', [\App\Http\Controllers\API\CheckoutController::class, 'store']);
    Route::get('/v1/orders', [\App\Http\Controllers\API\CheckoutController::class, 'index']);
    Route::get('/v1/orders/{id}', [\App\Http\Controllers\API\CheckoutController::class, 'show']);
});

// Public Product Routes
Route::prefix('v1/public/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

// Admin Product Routes (Protected)
Route::middleware(['auth:sanctum', 'admin'])->prefix('v1/admin')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});
