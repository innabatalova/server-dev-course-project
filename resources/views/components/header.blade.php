@props(['heading'])
<header class="site-header">
    <div class="container header-top">
        <a href="/" class="logo">
            @if (file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="МосПолитех">
            @else
                <span class="logo-placeholder">Лого МосПолитеха</span>
            @endif
        </a>
        <h1 class="page-title">{{ $heading }}</h1>
        <div class="header-spacer"></div>
    </div>
    <nav class="container nav">
        <a href="/" @class(['active' => request()->is('/')])>Главная</a>
        <div class="dropdown">
            <a href="/labs" @class(['active' => request()->is('labs*')])>Лабораторные</a>
            <div class="dropdown-menu">
                <a href="/labs">Все лабораторные</a>
                <a href="/labs/1">Лаба 1 — Feedback form</a>
                <a href="/labs/2">Лаба 2 — Notebook</a>
                <a href="/labs/3">Лаба 3 — Роутинг</a>
                @foreach (range(4, 5) as $n)
                    <a href="/labs/{{ $n }}">Лаба {{ $n }}</a>
                @endforeach
            </div>
        </div>
        <a href="/course" @class(['active' => request()->is('course*')])>Курсовой проект</a>
    </nav>
</header>
