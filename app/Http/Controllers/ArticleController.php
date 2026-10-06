<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->integer('category');

        $query = DB::table('ab_article');

        if ($categoryId) {
            $query
                ->join(
                    'ab_article_has_articlecategory',
                    'ab_article.id',
                    '=',
                    'ab_article_has_articlecategory.ab_article_id'
                )
                ->where('ab_article_has_articlecategory.ab_articlecategory_id', $categoryId)
                ->select('ab_article.*');
        }

        if ($search) {
            $query->whereRaw('LOWER(ab_name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $articles = $query->distinct()->get();
        $categoryName = $categoryId
            ? DB::table('ab_articlecategory')->where('id', $categoryId)->value('ab_name')
            : null;

        return view('articles', [
            'articles' => $articles,
            'search' => $search,
            'categoryId' => $categoryId,
            'categoryName' => $categoryName,
        ]);
    }

    public function create()
    {
        $categories = DB::table('ab_articlecategory')
            ->whereNotNull('ab_parent')
            ->orderBy('ab_name')
            ->get();

        return view('newarticle', ['categories' => $categories]);
    }
    public function search_api(Request $request)
    {
        $search = $request->query('search', '');

        $articles = DB::table('ab_article')
            ->select(
                'id',
                'ab_name as name',
                'ab_price as price',
                'ab_description as description'
            )
            ->where('ab_name', 'like', '%' . $search . '%')
            ->get();

        return response()->json([
            'search' => $search,
            'articles' => $articles
        ]);
    }
    public function create_api(Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');
        $categoryId = $request->integer('category_id');

        if ($name == null || trim($name) == '') {
            return response()->json([
                'error' => 'Name darf nicht leer sein'
            ], 400);
        }

        if ($price == null || $price <= 0) {
            return response()->json([
                'error' => 'Preis muss groesser als 0 sein'
            ], 400);
        }

        if (!$categoryId || !DB::table('ab_articlecategory')->where('id', $categoryId)->exists()) {
            return response()->json([
                'error' => 'Bitte eine gültige Kategorie auswählen'
            ], 400);
        }

        $id = DB::transaction(function () use ($name, $price, $description, $categoryId) {
            $articleId = DB::table('ab_article')->insertGetId([
                'ab_name' => $name,
                'ab_price' => $price,
                'ab_description' => $description,
                'ab_creator_id' => 1,
                'ab_createdate' => now()
            ]);

            DB::table('ab_article_has_articlecategory')->insert([
                'ab_articlecategory_id' => $categoryId,
                'ab_article_id' => $articleId,
            ]);

            return $articleId;
        });

        return response()->json([
            'id' => $id
        ]);
    }
}
