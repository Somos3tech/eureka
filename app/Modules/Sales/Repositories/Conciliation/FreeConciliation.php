<?php

namespace App\Modules\Sales\Repositories\Conciliation;

class FreeConciliation implements ConciliationInterface
{
    public function conciliate($request)
    {
        $data = ['status' => 'C'];

        return $data;
    }
}
