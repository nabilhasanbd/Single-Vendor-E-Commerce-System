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
