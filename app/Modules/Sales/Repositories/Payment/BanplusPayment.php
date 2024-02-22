<?php

namespace App\Modules\Sales\Repositories\Payment;

class BanplusPayment implements PayableInterface
{
    public function pay($request)
    {
        switch ($request['concept_id']) {
            case '3':
                $contract = $request['contract_id'];
                $conceptc = 'ND VENTA TERMINAL - Convenio Banplus';
                break;
            default:
                throw new \Exception('Concepto No Válido para este Método de Pago', 1);
                break;
        }
        $data = ['contract_id' => $contract, 'tipnot' => $request['payment_method'], 'concept_id' => 1, 'type_sale' => $request['type_sale'], 'refere' => $request['refere'], 'free' => 0.00, 'currency_id' => $request['currency_id'], 'amount' => $request['amount'], 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'conceptc' => $conceptc, 'status' => 'G'];

        return $data;
    }
}
