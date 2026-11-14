<?php

namespace App\Http\Controllers;

class Lab1Controller extends Controller
{
    private const TARGET_URL = 'https://httpbin.org/get';

    public function headers()
    {
        $result = @get_headers(self::TARGET_URL);

        $text = $result === false
            ? 'Не удалось получить заголовки'
            : implode(PHP_EOL, $result);

        return view('labs.lab1.headers', [
            'url' => self::TARGET_URL,
            'headers' => $text,
        ]);
    }
}