<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function addArticle_api(Request $request)
    {
        $articleId = $request->input('articleid');

        if ($articleId == null) {
            return response()->json(['error' => 'articleid fehlt'], 400);
        }

        $article = DB::table('ab_article')
            ->where('id', $articleId)
            ->first();

        if ($article == null) {
            return response()->json(['error' => 'Artikel nicht gefunden'], 404);
        }

        $cart = DB::table('ab_shoppingcart')
            ->where('ab_creator_id', 1)
            ->first();

        if ($cart == null) {
            $cartId = DB::table('ab_shoppingcart')->insertGetId([
                'ab_creator_id' => 1,
                'ab_createdate' => now()
            ]);
        } else {
            $cartId = $cart->id;
        }

        DB::table('ab_shoppingcart_item')->insert([
            'ab_shoppingcart_id' => $cartId,
            'ab_article_id' => $articleId,
            'ab_createdate' => now()
        ]);

        return response()->json([
            'shoppingcartid' => $cartId,
            'message' => 'Artikel wurde hinzugefuegt'
        ]);
    }

    public function removeArticle_api($shoppingcartid, $articleid)
    {
        $deleted = DB::table('ab_shoppingcart_item')
            ->where('ab_shoppingcart_id', $shoppingcartid)
            ->where('ab_article_id', $articleid)
            ->delete();

        if ($deleted == 0) {
            return response()->json(['error' => 'Artikel nicht im Warenkorb gefunden'], 404);
        }

        return response()->json([
            'message' => 'Artikel wurde entfernt'
        ]);
    }

    public function getCart_api($shoppingcartid)
    {
        $items = DB::table('ab_shoppingcart_item')
            ->join('ab_article', 'ab_shoppingcart_item.ab_article_id', '=', 'ab_article.id')
            ->where('ab_shoppingcart_item.ab_shoppingcart_id', $shoppingcartid)
            ->select(
                'ab_article.id',
                'ab_article.ab_name as name',
                'ab_article.ab_price as price',
                'ab_article.ab_description as description'
            )
            ->get();

        return response()->json([
            'shoppingcartid' => $shoppingcartid,
            'items' => $items
        ]);
    }
}
