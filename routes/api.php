<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterAction;

Route::post('/register', RegisterAction::class);

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/me', 'me');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
    });
});
