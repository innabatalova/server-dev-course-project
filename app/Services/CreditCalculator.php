<?php

namespace App\Services;

/**
 * Расчёт кредита с аннуитетными (равными) ежемесячными платежами.
 *
 * Ежемесячный платёж:  A = S * i / (1 - (1 + i)^(-n)),
 * где S — сумма кредита, i — месячная ставка (годовая / 12 / 100), n — срок в месяцах.
 * В каждом платеже часть идёт на проценты (остаток * i), остальное гасит основной долг.
 */
class CreditCalculator
{
    /**
     * @return array{payment: float, total: float, overpayment: float, schedule: array<int, array{month: int, payment: float, interest: float, principal: float, balance: float}>}
     */
    public function calculate(float $amount, int $months, float $rate): array
    {
        $i = $rate / 100 / 12;

        $payment = $i > 0
            ? $amount * $i / (1 - (1 + $i) ** (-$months))
            : $amount / $months;

        $balance = $amount;
        $schedule = [];

        for ($month = 1; $month <= $months; $month++) {
            $interest = $balance * $i;
            $principal = $payment - $interest;

            // В последнем месяце гасим остаток целиком, чтобы не накапливалась погрешность округления.
            if ($month === $months) {
                $principal = $balance;
            }

            $balance -= $principal;

            $schedule[] = [
                'month' => $month,
                'payment' => round($principal + $interest, 2),
                'interest' => round($interest, 2),
                'principal' => round($principal, 2),
                'balance' => round(max($balance, 0), 2),
            ];
        }

        $total = $payment * $months;

        return [
            'payment' => round($payment, 2),
            'total' => round($total, 2),
            'overpayment' => round($total - $amount, 2),
            'schedule' => $schedule,
        ];
    }
}
