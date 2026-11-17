<x-bank-layout :title="$finArticle->title">
    <article class="container bank-page bank-article">
        <p><a href="/bank/articles">← Все статьи</a></p>

        @if (session('success'))
            <div class="bank-alert bank-alert-success" role="status">{{ session('success') }}</div>
        @endif

        <div class="bank-article-meta">
            <span class="bank-tag">{{ $finArticle->category->name }}</span>
            <time datetime="{{ $finArticle->published_at->format('Y-m-d') }}">{{ $finArticle->published_at->format('d.m.Y') }}</time>
        </div>
        <h1>{{ $finArticle->title }}</h1>
        <p class="bank-page-lead">{{ $finArticle->announce }}</p>

        <div class="bank-article-body">
            @foreach (preg_split('/\R{2,}/', trim($finArticle->body)) as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>

        <aside class="bank-article-cta">
            <p>Хотите прикинуть цифры на своих параметрах?</p>
            <div class="bank-actions">
                <a class="bank-btn bank-btn-primary" href="/bank/calculator/deposit">Калькулятор вклада</a>
                <a class="bank-btn bank-btn-outline-dark" href="/bank/calculator/credit">Калькулятор кредита</a>
            </div>
        </aside>

        <div class="bank-admin">
            <a class="bank-btn bank-btn-outline-dark" href="/bank/articles/{{ $finArticle->slug }}/edit">Редактировать</a>
            <form method="post" action="/bank/articles/{{ $finArticle->slug }}" onsubmit="return confirm('Удалить статью?')">
                @csrf
                @method('DELETE')
                <button class="bank-btn bank-btn-danger" type="submit">Удалить</button>
            </form>
        </div>
    </article>
</x-bank-layout>
