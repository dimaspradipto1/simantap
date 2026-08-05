<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportDataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/login', 'login');
    Route::post('/login', 'authenticate')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected Routes with Auth Middleware
Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management Routes
    Route::put('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::resource('users', UserController::class);

    // Import Data Routes
    Route::get('/import-data', [ImportDataController::class, 'index'])->name('import-data.index');
    Route::get('/import-data/create', [ImportDataController::class, 'create'])->name('import-data.create');
    Route::post('/import-data/preview', [ImportDataController::class, 'preview'])->name('import-data.preview');
    Route::post('/import-data/confirm', [ImportDataController::class, 'confirmStep'])->name('import-data.confirm');
    Route::post('/import-data/store', [ImportDataController::class, 'store'])->name('import-data.store');
    Route::delete('/import-data/{importDatum}', [ImportDataController::class, 'destroy'])->name('import-data.destroy');
});