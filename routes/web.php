<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::controller(AuthController::class)->group(function(){

    Route::get('/', 'login')->name('login');
    Route::post('/', 'authenticate')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});