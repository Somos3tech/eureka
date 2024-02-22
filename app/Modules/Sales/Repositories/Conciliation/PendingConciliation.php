<?php

namespace App\Modules\Sales\Repositories\Conciliation;

class PendingConciliation implements ConciliationInterface
{
    public function conciliate($request)
    {
        $data = ['status' => 'P'];

        return $data;
    }
}
