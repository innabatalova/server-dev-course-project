<?php

namespace App\Http\Controllers;

use App\Services\DepositCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepositCalculatorController extends Controller
{
    public function show(Request $request, DepositCalculator $calculator)
    {
        $config = config('bank.deposit');

        // Значения по умолчанию, пока форма не отправлена.
        $input = [
            'amount' => $request->query('amount', 100000),
            'months' => $request->query('months', 12),
            'capitalization' => $request->query('capitalization', 'monthly'),
        ];

        $result = null;
        $fieldErrors = null;

        // Форма отправляется методом GET: расчёт ничего не меняет в БД,
        // а ссылку с параметрами можно сохранить или переслать.
        if ($request->has('amount')) {
            // Пробелы и запятая в сумме: «100 000,50» → «100000.50».
            $input['amount'] = str_replace([' ', "\u{00A0}", ','], ['', '', '.'], (string) $input['amount']);

            $validator = Validator::make($input, [
                'amount' => ['required', 'numeric', 'min:' . $config['min_amount'], 'max:' . $config['max_amount']],
                'months' => ['required', 'integer', 'min:' . $config['min_term'], 'max:' . $config['max_term']],
                'capitalization' => ['required', Rule::in(array_keys($config['capitalization']))],
            ], [
                'amount.required' => 'Введите сумму вклада.',
                'amount.numeric' => 'Сумма должна быть числом.',
                'amount.min' => 'Минимальная сумма вклада — ' . number_format($config['min_amount'], 0, ',', ' ') . ' ₽.',
                'amount.max' => 'Максимальная сумма вклада — ' . number_format($config['max_amount'], 0, ',', ' ') . ' ₽.',
                'months.required' => 'Укажите срок вклада.',
                'months.integer' => 'Срок должен быть целым числом месяцев.',
                'months.min' => 'Минимальный срок — ' . $config['min_term'] . ' мес.',
                'months.max' => 'Максимальный срок — ' . $config['max_term'] . ' мес.',
                'capitalization.required' => 'Выберите способ начисления процентов.',
                'capitalization.in' => 'Выбран неизвестный способ начисления процентов.',
            ]);

            if ($validator->fails()) {
                $fieldErrors = $validator->errors();
            } else {
                $data = $validator->validated();
                $period = $config['capitalization'][$data['capitalization']]['period'];

                $result = $calculator->calculate(
                    (float) $data['amount'],
                    (int) $data['months'],
                    (float) $config['rate'],
                    $period
                );
                $result['amount'] = (float) $data['amount'];
                $result['months'] = (int) $data['months'];
            }
        }

        return view('bank.calculator.deposit', [
            'config' => $config,
            'input' => $input,
            'result' => $result,
            'fieldErrors' => $fieldErrors,
        ]);
    }
}
