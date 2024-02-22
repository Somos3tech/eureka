<?php

namespace App\Modules\Sales\Repositories\Service;

class PaymentMethod implements SupportInvoiceInterface
{
    public function support($request)
    {
        if ($request->has('collect_partial')) {
            $collect_partial = $request['collect_partial'];
        } else {
            $collect_partial = null;
        }

        if ($request->has('inv_pending')) {
            $inv_pending = str_replace(',', '', $request['inv_pending']);
        } else {
            $inv_pending = null;
        }

        if ($request->has('quota')) {
            $quota = str_replace(',', '', $request['quota']);
        } else {
            $quota = null;
        }

        if ($request['status_support'] == 'C') {
            $status = 'P';
        } else {
            $status = $request['status_support'];
        }

        $data = [
            'tipnot' => $request['payment_method'],
            'currency_id' => $request['currency_id'],
            'amount' => str_replace(',', '', $request['amount']),
            'collect_partial' => $collect_partial,
            'inv_pending' => $inv_pending,
            'quota' => $quota,
            'status' => $status,
        ];

        return $data;
    }
}
