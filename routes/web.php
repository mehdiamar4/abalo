<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbTestDataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testdata', [AbTestDataController::class, 'index']);
