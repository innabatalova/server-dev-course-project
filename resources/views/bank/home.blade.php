@php
    $deposit = config('bank.deposit');
    $credit = config('bank.credit');
    $money = fn ($n) => number_format($n, 0, ',', ' ');
@endphp
<x-bank-layout>
    <section class="container bank-hero-wrap">
        <div class="bank-hero" style="--hero-image: url('{{ asset('images/bank/hero.webp') }}')">
            <div class="bank-hero-inner">
                <h1>Сначала посчитайте, потом решайте</h1>
                <p class="bank-lead">Вклад под {{ $deposit['rate'] }}% и кредит под {{ $credit['rate'] }}% годовых. Подберите сумму и срок, а мы покажем доход или платёж по месяцам.</p>
                <div class="bank-actions">
                    <a class="bank-btn bank-btn-accent" href="/bank/calculator/deposit">Рассчитать вклад</a>
                    <a class="bank-btn bank-btn-outline" href="/bank/calculator/credit">Рассчитать кредит</a>
                </div>
            </div>
        </div>
    </section>

    <section class="container bank-section">
        <h2>Продукты</h2>
        <div class="bank-products">
            <article class="bank-product">
                <img class="bank-product-icon" src="{{ asset('images/bank/icon-deposit.svg') }}" alt="">
                <h3>{{ $deposit['name'] }}</h3>
                <p class="bank-rate">{{ $deposit['rate'] }}% годовых</p>
                <ul>
                    <li>Сумма от {{ $money($deposit['min_amount']) }} до {{ $money($deposit['max_amount']) }} ₽</li>
                    <li>Срок от {{ $deposit['min_term'] }} до {{ $deposit['max_term'] }} месяцев</li>
                    <li>Проценты можно капитализировать</li>
                </ul>
                <a class="bank-link" href="/bank/calculator/deposit">Рассчитать доход</a>
            </article>
            <article class="bank-product">
                <img class="bank-product-icon" src="{{ asset('images/bank/icon-credit.svg') }}" alt="">
                <h3>{{ $credit['name'] }}</h3>
                <p class="bank-rate">{{ $credit['rate'] }}% годовых</p>
                <ul>
                    <li>Сумма от {{ $money($credit['min_amount']) }} до {{ $money($credit['max_amount']) }} ₽</li>
                    <li>Срок от {{ $credit['min_term'] }} до {{ $credit['max_term'] }} месяцев</li>
                    <li>Равные ежемесячные платежи</li>
                </ul>
                <a class="bank-link" href="/bank/calculator/credit">Рассчитать платёж</a>
            </article>
        </div>
    </section>

    <section class="container bank-section">
        <div class="bank-section-head">
            <h2>ФинГид</h2>
            <a class="bank-link" href="/bank/articles">Все статьи</a>
        </div>
        <p class="bank-section-text">Короткие статьи о вкладах, кредитной нагрузке, инфляции и защите от мошенников.</p>
        <div class="bank-articles">
            @foreach ($latest as $article)
                @include('bank.articles._card', ['article' => $article])
            @endforeach
        </div>
    </section>
</x-bank-layout>
