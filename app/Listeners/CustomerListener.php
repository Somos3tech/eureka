<?php

namespace App\Listeners;

use App\Events\Customer;

class CustomerListener
{
    public function handle(Customer $customer)
    {
        return $event->customer;
    }
}
