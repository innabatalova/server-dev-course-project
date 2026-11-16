<x-layout title="Notebook" heading="Notebook">
    <p><a href="/labs">← К списку лабораторных</a></p>
    <x-notebook-menu active="index" :sort="$sort" />

    <div class="table-wrap">
        <table class="contacts-table">
            <thead>
                <tr>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Пол</th>
                    <th>Дата рождения</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>E-mail</th>
                    <th>Комментарий</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->surname }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->patronymic ?? '—' }}</td>
                        <td>{{ $contact->gender }}</td>
                        <td>{{ $contact->birth_date->format('d.m.Y') }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->address }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->comment ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        @if ($contacts->hasPages())
            <nav class="pagination">
                @foreach (range(1, $contacts->lastPage()) as $page)
                    <a href="{{ $contacts->url($page) }}" @class(['page-link', 'active' => $page === $contacts->currentPage()])>{{ $page }}</a>
                @endforeach
            </nav>
        @endif
</x-layout>
