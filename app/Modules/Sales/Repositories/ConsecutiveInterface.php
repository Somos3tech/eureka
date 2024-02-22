<?php

namespace App\Modules\Sales\Repositories;

interface ConsecutiveInterface
{
    public function create(array $data);

    public function destroyConsecutiveBank($request);
}
