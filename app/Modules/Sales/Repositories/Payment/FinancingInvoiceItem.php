<?php

namespace App\Modules\Sales\Repositories\Payment;

class FinancingInvoiceItem implements PayableInterface
{
    public function pay($request)
    {
        switch ($request['concept_id']) {
            case '3':
                $data[] = ['currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['collect_partial']), 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'concept' => 'Cuota Inicial', 'status' => 'G'];
                $inv_pending = (str_replace(',', '', $request['inv_pending']) / $request['quota']);
                for ($i = 0; $i < $request['quota']; $i++) {
                    $data[] = ['item' => ($i + 1), 'date_expire' => date('Y-m-d', strtotime(date('Y-m-d').'+ '.($i + 1).' month')), 'currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $inv_pending), 'amount_currency' => null, 'concept' => 'Financiamiento', 'status' => 'P'];
                }

                return $data;
                break;

            default:
                throw new \Exception('Concepto No Válido para este Método de Pago', 1);
                break;
        }
    }
}
