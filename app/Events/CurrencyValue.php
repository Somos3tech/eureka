<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrencyValue implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $currencyvalue;

    public function __construct($currencyvalue)
    {
        $this->currencyvalue = $currencyvalue;
    }

    public function broadcastOn()
    {
        return ['currencyvalue'];
    }

    public function broadcastAs()
    {
        return 'rate-currencyvalue';
    }
}
