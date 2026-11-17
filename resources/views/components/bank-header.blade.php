<header class="bank-header">
    <div class="container bank-header-row">
        <a href="/bank" class="bank-logo">
            <img src="{{ asset('images/bank/logo.svg') }}" alt="БаталБанк" height="40">
        </a>
        <nav class="bank-nav" aria-label="Основная навигация">
            <a href="/bank" @class(['active' => request()->is('bank')])>Главная</a>
            <a href="/bank/articles" @class(['active' => request()->is('bank/articles*')])>ФинГид</a>
            <a href="/bank/calculator/deposit" @class(['active' => request()->is('bank/calculator/deposit*')])>Вклад</a>
            <a href="/bank/calculator/credit" @class(['active' => request()->is('bank/calculator/credit*')])>Кредит</a>
        </nav>
        <a href="/" class="bank-back">← Учебный сайт</a>
    </div>
</header>
