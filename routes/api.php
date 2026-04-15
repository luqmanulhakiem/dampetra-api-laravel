<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SopCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    /**
     * Authentication Routes
     */
    Route::controller(AuthController::class)->group(function () {
        Route::post("/register", 'register')->middleware('throttle:3,1');
        Route::post("/login", 'login');
    });

    Route::group(['middleware' => ['api']], function () {
        // Auth Controller
        Route::controller(AuthController::class)->group(function () {
            Route::post("/resent-otp", 'resentOtp')->middleware('throttle:3,1');
            Route::post("/verify-otp", 'verifyOtp')->middleware('throttle:3,1');
        });
        Route::group(['middleware' => ['verified']], function () {
            // Auth Controller
            Route::controller(AuthController::class)->group(function () {
                Route::post("/logout", 'logout');
            });
            // Sop Category Controller
            Route::controller(SopCategoryController::class)->group(function () {
                Route::get("/sop-categories", "index");
            });
        });
    });
});
