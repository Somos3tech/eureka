<?php

namespace App\Modules\Sales\Repositories\Payment;

class AgreementPayment implements PayableInterface
{
    public function pay($request)
    {
        switch ($request['concept_id']) {
            case '1':
                $data = [
                    'contract_id' => $request['contract_id'], 'type_sale' => $request['type_sale'], 'tipnot' => 'Convenio', 'concept_id' => 1, 'quota' => 2, 'refere' => $request['refere'], 'currency_id' => $request['currency_id'],
                    'amount' => str_replace(',', '', $request['amount']), 'free' => 0.00, 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'conceptc' => 'ND VENTA TERMINAL - Convenio', 'status' => 'G',
                ];

                return $data;
                break;
            default:
                throw new \Exception('Concepto No Válido para este Método de Pago', 1);
                break;
        }
    }
}
