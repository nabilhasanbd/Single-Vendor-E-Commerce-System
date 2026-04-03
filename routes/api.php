<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth Module Routes
Route::prefix('v1/auth')->group(function () {
    // Route::post('/register', [AuthController::class, 'register']);
    // Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // User Profile
    Route::get('/v1/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('v1')->group(function () {
        
        // Category Module
        Route::prefix('categories')->group(function () {
            // Route::get('/', [CategoryController::class, 'index']);
            // Route::post('/', [CategoryController::class, 'store']);
        });

        // Product Module
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/', [ProductController::class, 'store']);
            Route::get('/{id}', [ProductController::class, 'show']);
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });

        // Cart Module
        Route::prefix('cart')->group(function () {
            // Route::get('/', [CartController::class, 'index']);
        });

        // Order Module
        Route::prefix('orders')->group(function () {
            // Route::get('/', [OrderController::class, 'index']);
        });

        // Payment Module
        Route::prefix('payments')->group(function () {
            // Route::post('/process', [PaymentController::class, 'process']);
        });
        
    });
});

// Public Product Routes (If products should be visible to guests)
Route::prefix('v1/public/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
});
