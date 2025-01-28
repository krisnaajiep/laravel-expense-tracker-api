<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterAction;

Route::post('/register', RegisterAction::class);
Route::post('/login', [AuthController::class, 'login']);
