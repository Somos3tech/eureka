<?php

namespace App\Modules\Sales\Repositories\Conciliation;

class PostpagoConciliation implements ConciliationInterface
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
