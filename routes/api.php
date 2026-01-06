<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatsController;


// Anyone can register or login without a token
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    
    // Auth Management
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);

    // User Listing 
    Route::get('users', function() {
        return \App\Models\User::with('products')->orderBy('created_at', 'desc')->get();
    });

    // Product Management 
    Route::apiResource('products', ProductController::class);

    // System Statistics 
    Route::get('stats', [StatsController::class, 'index']);
});