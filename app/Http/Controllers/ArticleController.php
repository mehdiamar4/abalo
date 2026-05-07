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
}
