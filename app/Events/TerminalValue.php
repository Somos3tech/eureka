<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TerminalValue implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $terminalvalue;

    public function __construct($terminalvalue)
    {
        $this->terminalvalue = $terminalvalue;
    }

    public function broadcastOn()
    {
        return ['terminalvalue'];
    }

    public function broadcastAs()
    {
        return 'rate-terminalvalue';
    }
}
