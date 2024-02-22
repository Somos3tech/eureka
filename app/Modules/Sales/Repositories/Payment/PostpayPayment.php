<?php

namespace App\Modules\Sales\Repositories\Payment;

class PostpayPayment implements PayableInterface
{
    public function pay($request)
    {
        return ['contract_id' => $request['contract_id'], 'type_sale' => $request['type_sale'], 'tipnot' => 'Postpago', 'concept_id' => 1, 'currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['amount']), 'free' => 0.00, 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'conceptc' => 'ND VENTA TERMINAL - Postpago', 'status' => 'G'];
    }
}
