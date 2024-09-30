<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['custom-auth', 'custom-verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'user' => session('user')
        ]);
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::put('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});
