<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatsController;

// 1. PUBLIC AUTH ROUTES
// Anyone can register or login without a token
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// 2. PROTECTED ROUTES
// These require a valid JWT Token (The 'auth:api' middleware matches the guard we set in config/auth.php)
Route::middleware('auth:api')->group(function () {
    
    // Auth Management
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);

    // User Listing (Requirement 5)
    // List users with their products, sorted by newest users first
    Route::get('users', function() {
        return \App\Models\User::with('products')->orderBy('created_at', 'desc')->get();
    });

    // Product Management (Requirements 3, 4, 6)
    // resource() automatically creates routes for: index, store, show, update, destroy
    Route::apiResource('products', ProductController::class);

    // System Statistics (Requirement 7)
    Route::get('stats', [StatsController::class, 'index']);
});