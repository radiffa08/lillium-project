<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', [HomeController::class, 'show']);

Route::get('/store', [StoreController::class, 'show']);

Route::get('/login', [LoginController::class, 'show']);
Route::post('/login/post', [LoginController::class, 'login']);

