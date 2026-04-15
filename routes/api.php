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
        Route::post("/register", 'register')->middleware('throttle:10,1');
        Route::post("/login", 'login')->middleware('throttle:10,1');
    });

    /**
     * Protected Routes (Require Authentication and Email Verification)
     * Note: The 'verified' middleware will ensure that only users with verified emails can access these routes.
     * Make sure to apply the 'auth:api' middleware to the controllers to enforce authentication, and then use 'verified' middleware for email verification.
     */
    Route::group(['middleware' => ['api']], function () {
        // Unverified Auth Controller
        Route::controller(AuthController::class)->group(function () {
            Route::post("/resent-otp", 'resentOtp')->middleware('throttle:3,1');
            Route::post("/verify-otp", 'verifyOtp')->middleware('throttle:3,1');
        });

        // Verified Controller
        Route::group(['middleware' => ['verified', 'throttle:500,1']], function () {
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
