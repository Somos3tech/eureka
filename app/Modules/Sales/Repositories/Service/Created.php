<?php

namespace App\Modules\Sales\Repositories\Service;

class Created implements SupportInvoiceInterface
{
    public function support($request)
    {
        $data = ['fechpro' => $request['fechpro']];

        return $data;
    }
}
