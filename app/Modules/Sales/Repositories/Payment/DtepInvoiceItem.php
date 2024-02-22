<?php

namespace App\Modules\Sales\Repositories\Payment;

class DtepInvoiceItem implements PayableInterface
{
    public function pay($request)
    {
        $data[] = ['currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['collect_partial']), 'amount_currency' => str_replace(',', '', $request['amount_currency']), 'concept' => 'DTE', 'status' => 'G'];

        $data[] = ['date_expire' => date('Y-m-d', strtotime(date('Y-m-d').'+ 1 month')), 'currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['inv_pending']), 'amount_currency' => 0.00, 'concept' => 'Postpago', 'status' => 'P'];

        return $data;
    }
}
