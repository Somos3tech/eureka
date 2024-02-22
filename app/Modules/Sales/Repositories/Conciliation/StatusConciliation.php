<?php

namespace App\Modules\Sales\Repositories\Conciliation;

class StatusConciliation implements ConciliationInterface
{
    public function conciliate($request)
    {
        $status = '';

        if ($request['statusc'] == 'G') {
            $status = 'P';
        } elseif ($request['statusc'] == 'P') {
            $status = 'C';
        }

        $data = ['status' => $status];

        return $data;
    }
}
