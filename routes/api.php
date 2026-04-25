<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CouplesController;
use App\Http\Controllers\API\DailyEmotionController;
use App\Http\Controllers\API\SopCategoryController;
use App\Http\Controllers\API\SopCoupleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    /**
     * Authentication Routes
     */
    Route::controller(AuthController::class)->group(function () {
        Route::post("/register", 'register')->middleware('throttle:10,1');
        Route::post("/login", 'login')->middleware('throttle:10,1');
        Route::post("/send-reset-password", 'sendResetPasswordCode')->middleware('throttle:10,1');
        Route::post("/reset-password", 'resetPassword')->middleware('throttle:10,1');
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
            // Users
            Route::controller(UserController::class)->group(function () {
                Route::get("/users", 'getAllUser');
                Route::get("/users/me", 'index');
            });

            // Daily Emotion Controller
            Route::controller(DailyEmotionController::class)->group(function () {
                Route::post("/daily-emotion", "store");
                Route::get("/daily-emotion/me", "getSelfDailyEmotion");
                Route::get("/daily-emotion/partner", "getPartnerDailyEmotion");
            });

            // Couple
            Route::controller(CouplesController::class)->group(function () {
                Route::get("couple/request-status", "getCoupleRequestsStatus");
                Route::post("couple/invite", "inviteCouple");
                Route::post("couple/approval", "acceptCouple");
                Route::post("couple/invite-cancel", "cancelRequest");
            });

            // Couple Sop
            Route::controller(SopCoupleController::class)->group(function () {
                Route::get("sop-couple", 'getSops');
                Route::post("sop-couple", 'storeSop');
                Route::put("sop-couple/{id}", "editSop");
            });
        });
    });
});
