<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\NewPasswordController;
use App\Http\Controllers\Web\Auth\VerifyEmailController;
use App\Http\Controllers\Web\Auth\PasswordUpdateController;
use App\Http\Controllers\Web\Auth\PasswordResetLinkController;
use App\Http\Controllers\Web\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Web\Auth\EmailVerificationNotificationController;

Route::middleware('custom-guest')->group(function () {
  Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store');
  });

  Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
  });

  Route::controller(PasswordResetLinkController::class)->group(function () {
    Route::get('/forgot-password', 'create');
    Route::post('/forgot-password', 'store');
  });

  Route::controller(NewPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'create');
    Route::post('/reset-password', 'store');
  });
});

Route::middleware('custom-auth')->group(function () {
  Route::get('/email/verify', EmailVerificationPromptController::class)->name('verification.notice');
  Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class);
  Route::post('/email/verification-notification', EmailVerificationNotificationController::class);

  Route::middleware('custom-verified')->group(function () {
    Route::controller(AuthController::class)->group(function () {
      Route::post('/refresh', 'refresh');
      Route::post('/logout', 'logout')->withoutMiddleware('custom-verified');
    });

    Route::put('/update-password', PasswordUpdateController::class)->name('password.update');
  });
});
