<x-bank-layout title="Новая статья">
    <section class="container bank-page">
        <p><a href="/bank/articles">← Все статьи</a></p>
        <h1>Новая статья</h1>

        <form class="bank-form" method="post" action="/bank/articles" novalidate>
            @csrf
            @include('bank.articles._form', ['article' => null])
            <button class="bank-btn bank-btn-primary" type="submit">Добавить статью</button>
        </form>
    </section>
</x-bank-layout>
