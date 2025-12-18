<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;

// Public Routes
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index']); // Public but role-aware
Route::post('/feedback', [FeedbackController::class, 'store']);
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::get('/dealers', [\App\Http\Controllers\AdminController::class, 'index']);
        Route::post('/approve/{id}', [\App\Http\Controllers\AdminController::class, 'approve']);
        Route::post('/delete/{id}', [\App\Http\Controllers\AdminController::class, 'destroy']);
        Route::get('/records', [\App\Http\Controllers\AdminController::class, 'records']);
    });
});
