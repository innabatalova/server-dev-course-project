<x-layout title="Notebook: удаление" heading="Notebook">
    <p><a href="/labs">← К списку лабораторных</a></p>
    <x-notebook-menu active="delete" />

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if ($contacts->isNotEmpty())
        <div class="contact-links">
            @foreach ($contacts as $contact)
                <form method="post" action="/labs/2/contacts/{{ $contact->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="contact-link danger">{{ $contact->short_name }}</button>
                </form>
            @endforeach
        </div>
    @else
        <p>В записной книжке не осталось записей.</p>
    @endif
</x-layout>
