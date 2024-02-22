<?php

namespace App\Modules\Sales\Repositories\Payment;

class ComodatoPayment implements PayableInterface
{
    public function pay($request)
    {
        switch ($request['concept_id']) {
            case '3':
                $data = [
                    'contract_id' => $request['contract_id'], 'refere' => $request['refere'], 'tipnot' => $request['payment_method'], 'concept_id' => 1, 'type_sale' => $request['type_sale'], 'currency_id' => $request['currency_id'], 'free' => str_replace(',', '', $request['collect_partial']),
                    'amount' => str_replace(',', '', $request['collect_partial']), 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'conceptc' => 'ND VENTA TERMINAL - Comodato', 'status' => 'G',
                ];

                return $data;
                break;
            default:
                throw new \Exception('Concepto No Válido para este Método de Pago', 1);
                break;
        }
    }
}
