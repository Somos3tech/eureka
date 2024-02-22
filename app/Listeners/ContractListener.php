<?php

namespace App\Listeners;

use App\Events\Contract;

class ContractListener
{
    public function handle(Contract $contract)
    {
        return $event->contract;
    }
}
