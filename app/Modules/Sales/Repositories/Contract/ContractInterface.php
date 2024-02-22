<?php

namespace App\Modules\Sales\Repositories\Contract;

interface ContractInterface
{
    public function create($request);

    public function update($request);
}
