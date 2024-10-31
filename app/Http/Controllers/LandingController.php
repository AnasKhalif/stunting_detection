<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Faq;

class LandingController extends Controller
{
    public function index()
    {
        $articles = Article::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $faqs = Faq::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('users.index', compact('articles', 'faqs'));
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

    public function indexAbout()
    {
        return view('users.about');
    }
}
