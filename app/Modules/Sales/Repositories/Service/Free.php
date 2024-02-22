<?php

namespace App\Modules\Sales\Repositories\Service;

class Free implements SupportInvoiceInterface
{
    public function support($request)
    {
        return  ['free' => str_replace(',', '', $request['free'])];
    }
}
