<?php

namespace App\Http\Controllers;

class GreetingController extends Controller
{
    public function sayHello(string $name): string
    {
        return "Привет, $name";
    }

    public function sayBye(string $name): string
    {
        return "Пока, $name";
    }
}