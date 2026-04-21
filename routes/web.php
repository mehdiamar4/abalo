<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbTestDataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testdata', [AbTestDataController::class, 'index']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');
