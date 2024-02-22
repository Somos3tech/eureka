<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Dashboard implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dashboard;

    public function __construct($dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function broadcastOn()
    {
        return ['dashboard'];
    }

    public function broadcastAs()
    {
        return 'my-dashboard';
    }
}
