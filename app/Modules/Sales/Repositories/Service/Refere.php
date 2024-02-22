<?php

namespace App\Modules\Sales\Repositories\Service;

class Refere implements SupportInvoiceInterface
{
    public function support($request)
    {
        $data = ['refere' => $request['refere']];

        return $data;
    }
}
