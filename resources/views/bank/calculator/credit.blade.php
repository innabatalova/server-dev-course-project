@php
    $money = fn ($v) => number_format($v, 2, ',', "\u{00A0}");
    $int = fn ($v) => number_format($v, 0, ',', "\u{00A0}");
    $err = fn ($field) => $fieldErrors?->first($field);
@endphp
<x-bank-layout title="Калькулятор кредита">
    <section class="container bank-page">
        <h1>Калькулятор кредита</h1>
        <p class="bank-page-lead">
            {{ $config['name'] }}: {{ $config['rate'] }}% годовых, равные ежемесячные платежи. Укажите сумму и срок.
        </p>

        <div class="bank-calc">
            <form class="bank-form bank-calc-form" method="get" action="/bank/calculator/credit" novalidate>
                @if ($fieldErrors)
                    <div class="bank-alert bank-alert-error" role="alert">Расчёт не выполнен. Проверьте поля, отмеченные ниже.</div>
                @endif

                <div class="bank-field">
                    <label for="amount">Сумма кредита, ₽</label>
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

                <button class="bank-btn bank-btn-primary" type="submit">Рассчитать</button>
            </form>

            <div class="bank-calc-result">
                @if ($result)
                    <div class="bank-result-card">
                        <p class="bank-result-label">Ежемесячный платёж</p>
                        <p class="bank-result-main">{{ $money($result['payment']) }} ₽</p>
                        <dl class="bank-result-list">
                            <div><dt>Сумма кредита</dt><dd>{{ $money($result['amount']) }} ₽</dd></div>
                            <div><dt>Переплата за {{ $result['months'] }} мес.</dt><dd>{{ $money($result['overpayment']) }} ₽</dd></div>
                            <div><dt>Всего выплатите</dt><dd>{{ $money($result['total']) }} ₽</dd></div>
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
            <h2 class="bank-calc-title">График платежей</h2>
            <div class="bank-table-wrap">
                <table class="bank-table">
                    <thead>
                        <tr>
                            <th scope="col">Месяц</th>
                            <th scope="col">Платёж, ₽</th>
                            <th scope="col">Проценты, ₽</th>
                            <th scope="col">Основной долг, ₽</th>
                            <th scope="col">Остаток долга, ₽</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result['schedule'] as $row)
                            <tr>
                                <td>{{ $row['month'] }}</td>
                                <td>{{ $money($row['payment']) }}</td>
                                <td>{{ $money($row['interest']) }}</td>
                                <td>{{ $money($row['principal']) }}</td>
                                <td>{{ $money($row['balance']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="bank-note">Расчёт предварительный и не является публичной офертой. Итоговые условия определяются договором.</p>
        @endif
    </section>
</x-bank-layout>
