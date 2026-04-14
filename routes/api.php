<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    /**
     * Authentication Routes
     */
    Route::controller(AuthController::class)->group(function () {
        Route::post("/register", 'register');
        Route::post("/login", 'login');
    });

    Route::group(['middleware' => ['api', 'verified']], function () {
        // Auth Controller
        Route::controller(AuthController::class)->group(function () {
            Route::post("/logout", 'logout');
        });
    });
});
