<x-layout title="Лабораторные" heading="Лабораторные работы">
    <div class="cards">
        <a class="card" href="/labs/1"><h2>Лаба 1 — Feedback form</h2></a>
        <a class="card" href="/labs/2"><h2>Лаба 2 — Notebook</h2></a>
        @foreach (range(3, 5) as $n)
            <div class="card stub">
                <h2>Лаба {{ $n }}</h2>
                <p>Описание позже</p>
            </div>
        @endforeach
    </div>
</x-layout>
