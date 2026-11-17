<x-layout :title="$article->title" heading="Статья">
    <p><a href="/labs/5">← К списку статей</a></p>

    <h2>{{ $article->title }}</h2>
    <p>{{ $article->text }}</p>
    <p>Автор: {{ $author->nickname }}</p>
</x-layout>
