<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $data = $request->validate([
            'surname'    => ['required', 'string', 'max:100'],
            'name'       => ['required', 'string', 'max:100'],
            'patronymic' => ['nullable', 'string', 'max:100'],
            'gender'     => ['required', 'in:мужской,женский'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'phone'      => ['required', 'string', 'max:30'],
            'address'    => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'comment'    => ['nullable', 'string'],
        ]);

        Contact::create($data);

        return redirect('/labs/2/create')->with('success', 'Запись добавлена');
    }
}
