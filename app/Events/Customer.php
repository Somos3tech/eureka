<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Customer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function broadcastOn()
    {
        return ['customer'];
    }

    public function broadcastAs()
    {
        return 'total-customer';
    }
}
