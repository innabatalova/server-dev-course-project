<x-layout title="Лабораторные" heading="Лабораторные работы">
    <div class="cards">
        <a class="card" href="/labs/1"><h2>Лаба 1 — Feedback form</h2></a>
        @foreach (range(2, 5) as $n)
            <div class="card stub">
                <h2>Лаба {{ $n }}</h2>
                <p>Описание позже</p>
            </div>
        @endforeach
    </div>
</x-layout>