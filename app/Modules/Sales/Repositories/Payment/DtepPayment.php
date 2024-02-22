<?php

namespace App\Modules\Sales\Repositories\Payment;

class DtepPayment implements PayableInterface
{
    public function pay($request)
    {
        $data = ['contract_id' => $request['contract_id'], 'tipnot' => 'DTEP', 'concept_id' => 1, 'type_sale' => $request['type_sale'], 'refere' => $request['refere'], 'free' => 0.00, 'currency_id' => $request['currency_id'], 'amount' => $request['amount'], 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'conceptc' => 'DTE - Postpago', 'status' => 'G'];

        return $data;
    }
}
