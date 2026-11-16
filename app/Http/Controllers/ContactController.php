<?php
namespace App\Http\Controllers;

use App\Models\Contact;

class ContactController extends Controller
{
    private const SORTS = [
        'added'   => 'id',
        'surname' => 'surname',
        'birth'   => 'birth_date',
    ];
    public function index()
    {
        $sort = request()->query('sort');
        $sort = is_string($sort) && isset(self::SORTS[$sort]) ? $sort : 'added';

        $contacts = Contact::orderBy(self::SORTS[$sort])
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('labs.lab2.index', compact('contacts', 'sort'));
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
