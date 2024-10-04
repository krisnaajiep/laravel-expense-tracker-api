<?php

use App\Http\Controllers\Api\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['api', 'auth:api', 'api-custom-verified', 'throttle:api'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::put('/profile', 'update');
        Route::delete('/profile', 'destroy');
    });

    Route::apiResource('expenses', ExpenseController::class);
});
