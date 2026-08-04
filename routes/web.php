<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/login', 'login');
    Route::post('/login', 'authenticate')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected Dashboard Route with Role Middleware
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.dashboard.template');
    })->name('dashboard');
});