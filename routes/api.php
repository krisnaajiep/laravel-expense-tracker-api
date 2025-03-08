<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterAction;
use App\Http\Controllers\ExpenseController;

Route::post('/register', RegisterAction::class);

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/me', 'me');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
    });
});

Route::apiResource('expenses', ExpenseController::class)->except('show')->middleware(['auth:api', 'throttle:api']);
