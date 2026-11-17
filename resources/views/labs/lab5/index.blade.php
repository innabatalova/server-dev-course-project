<x-layout title="Лабораторная работа 5" heading="Лабораторная работа 5">
    <p><a href="/labs">← К списку лабораторных</a></p>
    <p>Статьи блога. Нажмите на заголовок, чтобы открыть статью и увидеть автора.</p>

    <ul>
        @foreach ($articles as $article)
            <li><a href="/labs/5/articles/{{ $article->id }}">{{ $article->title }}</a></li>
        @endforeach
    </ul>
</x-layout>
