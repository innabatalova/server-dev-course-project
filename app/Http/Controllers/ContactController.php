<?php
namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        return view('labs.lab2.index');
    }
    public function create()
    {
        return view('labs.lab2.create');
    }

    public function edit()
    {
        return view('labs.lab2.edit');
    }

    public function delete()
    {
        return view('labs.lab2.delete');
    }
}
