<?php

namespace App\Modules\Sales\Repositories\Conciliation;

class FinancingConciliation implements ConciliationInterface
{
    public function conciliate($request)
    {
        $status = '';

        if ($request['status_invoice'] == false) {
            $status = 'P';
        } else {
            $status = 'C';
        }

        $data = ['status' => $status];

        return $data;
    }
}
