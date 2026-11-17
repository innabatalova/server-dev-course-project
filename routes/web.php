<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Lab1Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\Lab4Controller;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\FinArticleController;
use App\Http\Controllers\DepositCalculatorController;

Route::view('/', 'home');
Route::view('/labs', 'labs.index');

Route::view('/labs/1', 'labs.lab1.form');
Route::get('/labs/1/headers', [Lab1Controller::class, 'headers']);

Route::get('/labs/2', [ContactController::class, 'index']);
Route::get('/labs/2/create', [ContactController::class, 'create']);
Route::get('/labs/2/edit/{contact?}', [ContactController::class, 'edit']);
Route::get('/labs/2/delete', [ContactController::class, 'delete']);
Route::post('/labs/2/contacts', [ContactController::class, 'store']);
Route::put('/labs/2/contacts/{contact}', [ContactController::class, 'update']);
Route::delete('/labs/2/contacts/{contact}', [ContactController::class, 'destroy']);

Route::view('/labs/3', 'labs.lab3.index');
Route::get('/labs/3/hello/{name}', [GreetingController::class, 'sayHello']);
Route::get('/labs/3/bye/{name}', [GreetingController::class, 'sayBye']);

Route::view('/labs/4', 'labs.lab4.index');
Route::get('/labs/4/hello/{name}', [Lab4Controller::class, 'hello']);

Route::get('/labs/5', [ArticlesController::class, 'index']);
Route::get('/labs/5/articles/{id}', [ArticlesController::class, 'show']);

Route::redirect('/course', '/bank');
Route::get('/bank', [BankController::class, 'home']);
Route::get('/bank/articles', [FinArticleController::class, 'index']);
Route::get('/bank/articles/create', [FinArticleController::class, 'create']);
Route::post('/bank/articles', [FinArticleController::class, 'store']);
Route::get('/bank/articles/{finArticle}', [FinArticleController::class, 'show']);
Route::get('/bank/articles/{finArticle}/edit', [FinArticleController::class, 'edit']);
Route::put('/bank/articles/{finArticle}', [FinArticleController::class, 'update']);
Route::delete('/bank/articles/{finArticle}', [FinArticleController::class, 'destroy']);
Route::get('/bank/calculator/deposit', [DepositCalculatorController::class, 'show']);

