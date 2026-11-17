<article class="bank-article-card">
    <div class="bank-article-meta">
        <span class="bank-tag">{{ $article->category->name }}</span>
        <time datetime="{{ $article->published_at->format('Y-m-d') }}">{{ $article->published_at->format('d.m.Y') }}</time>
    </div>
    <h3><a href="/bank/articles/{{ $article->slug }}">{{ $article->title }}</a></h3>
    <p>{{ $article->announce }}</p>
    <a class="bank-link" href="/bank/articles/{{ $article->slug }}">Читать полностью</a>
</article>
