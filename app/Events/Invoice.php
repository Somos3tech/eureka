<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Invoice implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function broadcastOn()
    {
        return ['invoice'];
    }

    public function broadcastAs()
    {
        return 'total-invoice';
    }
}
