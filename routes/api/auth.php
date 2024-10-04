<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\Auth\PasswordUpdateController;
use App\Http\Controllers\Api\Auth\PasswordResetLinkController;

Route::post('/register', [RegisterController::class, 'store']);

Route::middleware('auth:api')->group(function () {
    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)->name('verification.verify')->middleware('signed');
    Route::post('/email/verification-notification', EmailVerificationNotificationController::class)
        ->withoutMiddleware('throttle:api')
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')
            ->withoutMiddleware(['auth:api', 'throttle:api'])
            ->middleware('throttle:login')
            ->name('login');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh')->middleware('api-custom-verified');
        Route::get('/me', 'me');
    });

    Route::put('/update-password', PasswordUpdateController::class)->middleware('api-custom-verified');
});

Route::post('/forgot-password', PasswordResetLinkController::class);
Route::post('/reset-password', NewPasswordController::class)->name('password.reset');
