<?php

namespace App\Listeners;

use App\Events\Order;

class OrderListener
{
    public function handle(Order $order)
    {
        return $event->order;
    }
}
