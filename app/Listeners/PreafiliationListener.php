<?php

namespace App\Listeners;

use App\Events\Preafiliation;

class PreafiliationListener
{
    public function handle(Preafiliation $event)
    {
        return $event->preafiliation;
    }
}
