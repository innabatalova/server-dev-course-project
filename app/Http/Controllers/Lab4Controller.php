<?php

namespace App\Http\Controllers;

class Lab4Controller extends Controller
{
    public function hello(string $name)
    {
        return view('labs.lab4.hello', [
            'title' => 'Страница приветствия',
            'name' => $name,
        ]);
    }
}