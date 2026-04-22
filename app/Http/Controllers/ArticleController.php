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
}
