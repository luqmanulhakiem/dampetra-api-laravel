<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    /**
     * Authentication Routes
     */
    Route::controller(AuthController::class)->group(function () {
        Route::post("/register", 'register');
        Route::post("/login", 'login');
    });
});

// Route::get('/dashboard', function () {
//     // Only verified users may access...
// })->middleware(['auth', 'verified']);
