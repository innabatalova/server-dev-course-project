<x-layout title="Feedback form" heading="Feedback form">
    <p><a href="/labs">← К списку лабораторных</a></p>
    <h2>Результат get_headers</h2>
    <p>URL: {{ $url }}</p>

    <textarea class="headers-output" readonly rows="14">{{ $headers }}</textarea>

    <p><a href="/labs/1">← К форме</a></p>
</x-layout>
