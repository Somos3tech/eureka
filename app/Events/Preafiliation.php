<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Preafiliation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $preafiliation;

    public function __construct($preafiliation)
    {
        $this->preafiliation = $preafiliation;
    }

    public function broadcastOn()
    {
        return ['preafiliation'];
    }

    public function broadcastAs()
    {
        return 'total-preafiliation';
    }
}
