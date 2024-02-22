<?php

namespace App\Modules\Sales\Repositories\Operation;

use App\Modules\Sales\Repositories\RepositoryInterface;

interface OperationInterface extends RepositoryInterface
{
    public function report($request);
}
