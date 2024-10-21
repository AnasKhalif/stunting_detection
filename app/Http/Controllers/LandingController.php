<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class LandingController extends Controller
{
    public function index()
    {
        $articles = Article::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('users.index', compact('articles'));
    }

    public function indexArtikel()
    {
        $articles = Article::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        return view('users.artikel', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('users.artikel_detail', compact('article'));
    }
}
