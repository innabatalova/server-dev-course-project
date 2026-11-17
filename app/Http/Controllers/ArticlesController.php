<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('id')->get();

        return view('labs.lab5.index', compact('articles'));
    }

    public function show(int $id)
    {
        $article = Article::findOrFail($id);
        $author = User::find($article->user_id);

        return view('labs.lab5.show', compact('article', 'author'));
    }
}
