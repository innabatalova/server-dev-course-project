<x-bank-layout title="Редактирование статьи">
    <section class="container bank-page">
        <p><a href="/bank/articles/{{ $finArticle->slug }}">← К статье</a></p>
        <h1>Редактирование статьи</h1>

        <form class="bank-form" method="post" action="/bank/articles/{{ $finArticle->slug }}">
            @csrf
            @method('PUT')
            @include('bank.articles._form', ['article' => $finArticle])
            <button class="bank-btn bank-btn-primary" type="submit">Сохранить</button>
        </form>
    </section>
</x-bank-layout>
