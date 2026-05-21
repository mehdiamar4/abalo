<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = DB::table('ab_article');

        if ($search) {
            $query->whereRaw('LOWER(ab_name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $articles = $query->get();

        return view('articles', [
            'articles' => $articles,
            'search' => $search
        ]);
    }
    public function store(Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');

        // validation (server-side)
        if (!$name || $price <= 0) {
            return "Error: Name required and price must be > 0";
        }

        DB::table('ab_article')->insert([
            'ab_name' => $name,
            'ab_price' => (int)$price,
            'ab_description' => $description,
            'ab_creator_id' => 1,
            'ab_createdate' => now(),
        ]);

        return redirect('/articles');
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

        $id = DB::table('ab_article')->insertGetId([
            'ab_name' => $name,
            'ab_price' => $price,
            'ab_description' => $description,
            'ab_creator_id' => 1,
            'ab_createdate' => now()
        ]);

        return response()->json([
            'id' => $id
        ]);
    }
}

