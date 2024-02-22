<?php

namespace App\Modules\Sales\Repositories\Payment;

class ReconciliatePayment implements PayableInterface
{
    public function pay($request)
    {
        switch ($request['concept_id']) {
            case '3':
                switch ($request['type_discount']) {
                    case 'Descuento':
                        $contract = $request['contract_id'];
                        $free = str_replace(',', '', $request['collect_partial']);
                        $conceptc = 'ND VENTA TERMINAL - Descuento';
                        break;

                    default:
                        $contract = $request['contract_id'];
                        $free = 0.00;
                        $conceptc = 'ND VENTA TERMINAL';
                        break;
                }
                break;
            default:
                throw new \Exception('Concepto No Válido para este Método de Pago', 1);
                break;
        }
        $data = ['contract_id' => $contract, 'concept_id' => 1, 'tipnot' => $request['payment_method'], 'type_sale' => $request['type_sale'], 'refere' => $request['refere'], 'free' => $free, 'currency_id' => $request['currency_id'], 'amount' => $request['amount'], 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'conceptc' => $conceptc, 'status' => 'G'];

        return $data;
    }
}
