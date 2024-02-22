<?php

namespace App\Listeners;

use App\Events\Invoice;

class InvoiceListener
{
    public function handle(Invoice $invoice)
    {
        return $event->invoice;
    }
}
