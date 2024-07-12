<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/', 'login')->name('loginPost');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});
