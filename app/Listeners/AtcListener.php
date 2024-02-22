<?php

namespace App\Listeners;

use App\Events\Atc;

class AtcListener
{
    public function handle(Atc $atc)
    {
        return $event->atc;
    }
}
