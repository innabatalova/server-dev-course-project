<x-bank-layout title="ФинГид">
    <section class="container bank-page">
        <header class="bank-page-head">
            <div>
                <h1>ФинГид</h1>
                <p class="bank-page-lead">Коротко и понятно о вкладах, кредитах, инфляции и защите от мошенников.</p>
            </div>
            <a class="bank-btn bank-btn-primary" href="/bank/articles/create">Добавить статью</a>
        </header>

        @if (session('success'))
            <div class="bank-alert bank-alert-success" role="status">{{ session('success') }}</div>
        @endif

        <form class="bank-toolbar" method="get" action="/bank/articles" role="search" id="article-filter">
            @if ($category)
                <input type="hidden" name="category" value="{{ $category }}">
            @endif
            <label class="bank-search">
                <span class="sr-only">Поиск по статьям</span>
                <input type="search" name="q" value="{{ $q }}" placeholder="Поиск, например «капитализация»" autocomplete="off">
            </label>
            <button class="bank-btn bank-btn-primary" type="submit">Найти</button>
        </form>

        <nav class="bank-chips" aria-label="Категории статей">
            <a href="/bank/articles{{ $q !== '' ? '?' . http_build_query(['q' => $q]) : '' }}" @class(['bank-chip', 'active' => ! $category])>Все</a>
            @foreach ($categories as $cat)
                <a href="/bank/articles?{{ http_build_query(array_filter(['q' => $q, 'category' => $cat->slug])) }}" @class(['bank-chip', 'active' => $category === $cat->slug]) data-category="{{ $cat->slug }}">{{ $cat->name }}</a>
            @endforeach
        </nav>

        <div id="articles-results">
            @if ($articles->isEmpty())
                <div class="bank-empty">
                    <p>Ничего не найдено. Измените запрос или выберите другую категорию.</p>
                    <a class="bank-link" href="/bank/articles">Показать все статьи</a>
                </div>
            @else
                <div class="bank-articles">
                    @foreach ($articles as $article)
                        @include('bank.articles._card', ['article' => $article])
                    @endforeach
                </div>

                @if ($articles->hasPages())
                    <nav class="pagination" aria-label="Страницы">
                        @foreach (range(1, $articles->lastPage()) as $page)
                            <a href="{{ $articles->url($page) }}" @class(['page-link', 'active' => $page === $articles->currentPage()])>{{ $page }}</a>
                        @endforeach
                    </nav>
                @endif
            @endif
        </div>
    </section>
</x-bank-layout>
