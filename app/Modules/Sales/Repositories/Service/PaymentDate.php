<?php

namespace App\Modules\Sales\Repositories\Service;

class PaymentDate implements SupportInvoiceInterface
{
    public function support($request)
    {
        $data = ['payment_date' => $request['payment_date']];

        return $data;
    }
}
