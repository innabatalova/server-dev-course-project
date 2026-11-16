<x-layout title="Notebook: добавление" heading="Notebook">
    <p><a href="/labs">← К списку лабораторных</a></p>
    <x-notebook-menu active="create" />

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">Ошибка: запись не добавлена</div>
        @endif

        @include('labs.lab2._form', [
            'contact' => null,
            'action' => '/labs/2/contacts',
            'button' => 'Добавить',
        ])
</x-layout>
