<?php

namespace App\Modules\Sales\Repositories\Service;

class Amount implements SupportInvoiceInterface
{
    public function support($request)
    {
        if ($request['status_support'] == 'C') {
            $status = 'P';
        } else {
            $status = $request['status_support'];
        }
        $data = ['currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['amount']), 'status' => str_replace(',', '', $status)];

        return $data;
    }
}
