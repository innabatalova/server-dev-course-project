<?php

namespace App\Http\Controllers;

use App\Models\FinArticle;

class BankController extends Controller
{
    public function home()
    {
        $latest = FinArticle::with('category')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('bank.home', compact('latest'));
    }
}
