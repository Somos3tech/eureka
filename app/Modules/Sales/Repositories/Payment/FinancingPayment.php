<?php

namespace App\Modules\Sales\Repositories\Payment;

class FinancingPayment implements PayableInterface
{
    public function pay($request)
    {
        switch ($request['concept_id']) {
            case '3':
                $data = ['contract_id' => $request['contract_id'], 'refere' => $request['refere'], 'type_sale' => $request['type_sale'], 'tipnot' => $request['payment_method'], 'concept_id' => 1, 'currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['amount']), 'free' => 0.00, 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'conceptc' => 'ND VENTA TERMINAL - Financiamiento', 'quota' => $request['quota'], 'status' => 'G'];

                return $data;
                break;

            default:
                throw new \Exception('Concepto No Válido para este Método de Pago', 1);
                break;
        }
    }
}
