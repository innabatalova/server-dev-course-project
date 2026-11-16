<x-layout title="Notebook: редактирование" heading="Notebook">
    <p><a href="/labs">← К списку лабораторных</a></p>
    <x-notebook-menu active="edit" />

        @if ($contact)
            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert error">Ошибка: запись не сохранена</div>
            @endif
            
            <nav class="contact-links">
                @foreach ($contacts as $item)
                    <a href="/labs/2/edit/{{ $item->id }}" @class(['contact-link', 'current' => $item->id === $contact->id])>{{ $item->name }} {{ $item->surname }}</a>
                @endforeach
            </nav>

            @include('labs.lab2._form', [
                'contact' => $contact,
                'action' => '/labs/2/contacts/' . $contact->id,
                'button' => 'Сохранить',
            ])
        @else
            <p>В записной книжке пока нет записей.</p>
        @endif
</x-layout>
