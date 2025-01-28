<?php

use App\Http\Controllers\RegisterAction;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->group(function () {
    Route::post('/register', RegisterAction::class);
});
