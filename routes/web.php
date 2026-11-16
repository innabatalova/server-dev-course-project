<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Lab1Controller;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/labs', 'labs.index');
Route::view('/course', 'course');

Route::view('/labs/1', 'labs.lab1.form');
Route::get('/labs/1/headers', [Lab1Controller::class, 'headers']);

Route::get('/labs/2', [ContactController::class, 'index']);
Route::get('/labs/2/create', [ContactController::class, 'create']);
Route::get('/labs/2/edit/{contact?}', [ContactController::class, 'edit']);
Route::get('/labs/2/delete', [ContactController::class, 'delete']);
Route::post('/labs/2/contacts', [ContactController::class, 'store']);
Route::put('/labs/2/contacts/{contact}', [ContactController::class, 'update']);

Route::view('/labs/{n}', 'labs.stub')->where('n', '[3-5]');
