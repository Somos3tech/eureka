<?php

namespace App\Modules\Sales\Repositories\Service;

class Dicom implements SupportInvoiceInterface
{
    public function support($request)
    {
        $data = ['amount_currency' => str_replace(',', '', $request['dicom'])];

        return $data;
    }
}
