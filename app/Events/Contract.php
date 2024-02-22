<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Contract implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contract;

    public function __construct($contract)
    {
        $this->contract = $contract;
    }

    public function broadcastOn()
    {
        return ['contract'];
    }

    public function broadcastAs()
    {
        return 'total-contract';
    }
}
