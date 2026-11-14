<?php

use App\Http\Controllers\Lab1Controller;

Route::view('/', 'home');
Route::view('/labs', 'labs.index');
Route::view('/course', 'course');

use Illuminate\Support\Facades\Route;

Route::view('/labs/1', 'labs.lab1.form');
Route::get('/labs/1/headers', [Lab1Controller::class, 'headers']);
Route::view('/labs/{n}', 'labs.stub')->where('n', '[2-5]');
