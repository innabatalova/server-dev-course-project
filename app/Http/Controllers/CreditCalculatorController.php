<?php

namespace App\Http\Controllers;

use App\Services\CreditCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreditCalculatorController extends Controller
{
    public function show(Request $request, CreditCalculator $calculator)
    {
        $config = config('bank.credit');

        $input = [
            'amount' => $request->query('amount', 300000),
            'months' => $request->query('months', 24),
        ];

        $result = null;
        $fieldErrors = null;

        // Как и у вклада: форма отправляется методом GET, расчёт ничего не меняет в БД.
        if ($request->has('amount')) {
            $input['amount'] = str_replace([' ', "\u{00A0}", ','], ['', '', '.'], (string) $input['amount']);

            $validator = Validator::make($input, [
                'amount' => ['required', 'numeric', 'min:' . $config['min_amount'], 'max:' . $config['max_amount']],
                'months' => ['required', 'integer', 'min:' . $config['min_term'], 'max:' . $config['max_term']],
            ], [
                'amount.required' => 'Введите сумму кредита.',
                'amount.numeric' => 'Сумма должна быть числом.',
                'amount.min' => 'Минимальная сумма кредита — ' . number_format($config['min_amount'], 0, ',', ' ') . ' ₽.',
                'amount.max' => 'Максимальная сумма кредита — ' . number_format($config['max_amount'], 0, ',', ' ') . ' ₽.',
                'months.required' => 'Укажите срок кредита.',
                'months.integer' => 'Срок должен быть целым числом месяцев.',
                'months.min' => 'Минимальный срок — ' . $config['min_term'] . ' мес.',
                'months.max' => 'Максимальный срок — ' . $config['max_term'] . ' мес.',
            ]);

            if ($validator->fails()) {
                $fieldErrors = $validator->errors();
            } else {
                $data = $validator->validated();

                $result = $calculator->calculate((float) $data['amount'], (int) $data['months'], (float) $config['rate']);
                $result['amount'] = (float) $data['amount'];
                $result['months'] = (int) $data['months'];
            }
        }

        return view('bank.calculator.credit', [
            'config' => $config,
            'input' => $input,
            'result' => $result,
            'fieldErrors' => $fieldErrors,
        ]);
    }
}
