<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ShoppingCartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/articles', [ArticleController::class, 'search_api']);
Route::post('/articles', [ArticleController::class, 'create_api']);


Route::post('/shoppingcart', [ShoppingCartController::class, 'addArticle_api']);
Route::delete(

    '/shoppingcart/{shoppingcartid}/articles/{articleid}',
    [ShoppingCartController::class, 'removeArticle_api']

);

Route::get(
    '/shoppingcart/{shoppingcartid}',
    [ShoppingCartController::class, 'getCart_api']
);
