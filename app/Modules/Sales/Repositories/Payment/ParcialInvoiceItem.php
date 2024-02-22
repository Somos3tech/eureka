<?php

namespace App\Modules\Sales\Repositories\Payment;

class ParcialInvoiceItem implements PayableInterface
{
    public function pay($request)
    {
        $data[] = ['currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['collect_partial']), 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'concept' => 'Parcial', 'status' => 'G'];
        $data[] = ['currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['inv_pending']), 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'concept' => 'Parcial', 'status' => 'P'];

        return $data;
    }
}
