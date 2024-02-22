<?php

namespace App\Listeners;

use App\Events\TerminalValue;

class TerminalValueListener
{
    public function handle(TerminalValue $event)
    {
        return $event->terminalvalue;
    }
}
