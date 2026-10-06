<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ShoppingCartController;

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
