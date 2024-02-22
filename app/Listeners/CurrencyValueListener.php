<?php

namespace App\Listeners;

use App\Events\CurrencyValue;

class CurrencyValueListener
{
    public function handle(CurrencyValue $event)
    {
        return $event->currencyvalue;
    }
}
