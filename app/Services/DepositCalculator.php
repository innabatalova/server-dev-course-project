<?php

namespace App\Services;

/**
 * Расчёт дохода по вкладу.
 *
 * Каждый месяц начисляется 1/12 годовой ставки на «базу».
 * База — это сумма вклада плюс уже присоединённые (капитализированные) проценты.
 * Присоединение происходит раз в $period месяцев; при $period = 0 проценты
 * не присоединяются и выплачиваются в конце срока (простые проценты).
 * Если срок не кратен периоду, последние проценты выплачиваются в конце без присоединения.
 */
class DepositCalculator
{
    /**
     * @param  float  $amount  сумма вклада, ₽
     * @param  int    $months  срок, месяцев
     * @param  float  $rate    ставка, % годовых
     * @param  int    $period  период капитализации, месяцев (0 — без капитализации)
     * @return array{total: float, income: float, schedule: array<int, array{month: int, interest: float, balance: float}>}
     */
    public function calculate(float $amount, int $months, float $rate, int $period): array
    {
        $monthlyRate = $rate / 100 / 12;
        $capital = $amount;   // сумма, на которую начисляются проценты
        $pending = 0.0;       // начислено, но ещё не присоединено к вкладу
        $schedule = [];

        for ($month = 1; $month <= $months; $month++) {
            $interest = $capital * $monthlyRate;
            $pending += $interest;

            if ($period > 0 && $month % $period === 0) {
                $capital += $pending;
                $pending = 0.0;
            }

            $schedule[] = [
                'month' => $month,
                'interest' => round($interest, 2),
                'balance' => round($capital + $pending, 2),
            ];
        }

        $total = $capital + $pending;

        return [
            'total' => round($total, 2),
            'income' => round($total - $amount, 2),
            'schedule' => $schedule,
        ];
    }
}
