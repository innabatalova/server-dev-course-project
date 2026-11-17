@php
    // 12345.6 → «12 345,60» (пробел неразрывный, чтобы число не переносилось)
    $money = fn ($v) => number_format($v, 2, ',', "\u{00A0}");
    $int = fn ($v) => number_format($v, 0, ',', "\u{00A0}");
    $err = fn ($field) => $fieldErrors?->first($field);
@endphp
<x-bank-layout title="Калькулятор вклада">
    <section class="container bank-page">
        <h1>Калькулятор вклада</h1>
        <p class="bank-page-lead">
            {{ $config['name'] }}: {{ $config['rate'] }}% годовых. Выберите сумму, срок и способ начисления процентов.
        </p>

        <div class="bank-calc">
            <form class="bank-form bank-calc-form" method="get" action="/bank/calculator/deposit" novalidate>
                @if ($fieldErrors)
                    <div class="bank-alert bank-alert-error" role="alert">Расчёт не выполнен. Проверьте поля, отмеченные ниже.</div>
                @endif

                <div class="bank-field">
                    <label for="amount">Сумма вклада, ₽</label>
                    <input id="amount" type="text" inputmode="decimal" name="amount" value="{{ $input['amount'] }}" autocomplete="off">
                    <p class="bank-hint">От {{ $int($config['min_amount']) }} до {{ $int($config['max_amount']) }} ₽</p>
                    @if ($err('amount')) <p class="bank-error">{{ $err('amount') }}</p> @endif
                </div>

                <div class="bank-field">
                    <label for="months">Срок, месяцев</label>
                    <input id="months" type="text" inputmode="numeric" name="months" value="{{ $input['months'] }}" autocomplete="off">
                    <p class="bank-hint">От {{ $config['min_term'] }} до {{ $config['max_term'] }} месяцев</p>
                    @if ($err('months')) <p class="bank-error">{{ $err('months') }}</p> @endif
                </div>

                <div class="bank-field">
                    <label for="capitalization">Начисление процентов</label>
                    <select id="capitalization" name="capitalization">
                        @foreach ($config['capitalization'] as $key => $option)
                            <option value="{{ $key }}" @selected($input['capitalization'] === $key)>{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                    @if ($err('capitalization')) <p class="bank-error">{{ $err('capitalization') }}</p> @endif
                </div>

                <button class="bank-btn bank-btn-primary" type="submit">Рассчитать</button>
            </form>

            <div class="bank-calc-result">
                @if ($result)
                    <div class="bank-result-card">
                        <p class="bank-result-label">Итого к получению</p>
                        <p class="bank-result-main">{{ $money($result['total']) }} ₽</p>
                        <dl class="bank-result-list">
                            <div><dt>Сумма вклада</dt><dd>{{ $money($result['amount']) }} ₽</dd></div>
                            <div><dt>Доход за {{ $result['months'] }} мес.</dt><dd class="bank-plus">+ {{ $money($result['income']) }} ₽</dd></div>
                            <div><dt>Ставка</dt><dd>{{ $config['rate'] }}% годовых</dd></div>
                        </dl>
                    </div>
                @else
                    <div class="bank-result-card bank-result-empty">
                        <p>Результат появится здесь после расчёта.</p>
                    </div>
                @endif
            </div>
        </div>

        @if ($result)
            <h2 class="bank-calc-title">Начисление по месяцам</h2>
            <div class="bank-table-wrap">
                <table class="bank-table">
                    <thead>
                        <tr><th scope="col">Месяц</th><th scope="col">Начислено, ₽</th><th scope="col">Сумма на вкладе, ₽</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($result['schedule'] as $row)
                            <tr>
                                <td>{{ $row['month'] }}</td>
                                <td>{{ $money($row['interest']) }}</td>
                                <td>{{ $money($row['balance']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="bank-note">Расчёт предварительный и не является публичной офертой. Проценты начисляются по ставке 1/12 годовой в месяц.</p>
        @endif
    </section>
</x-bank-layout>
