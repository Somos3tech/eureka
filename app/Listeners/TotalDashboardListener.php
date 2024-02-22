<?php

namespace App\Listeners;

use App\Events\Dashboard;

class TotalDashboardListener
{
    public function handle(Dashboard $event)
    {
        return $event->dashboard;
    }
}
