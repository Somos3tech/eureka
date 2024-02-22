<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Atc implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $atc;

    public function __construct($atc)
    {
        $this->atc = $atc;
    }

    public function broadcastOn()
    {
        return ['atc'];
    }

    public function broadcastAs()
    {
        return 'total-atc';
    }
}
