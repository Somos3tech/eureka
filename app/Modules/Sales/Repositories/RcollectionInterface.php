<?php

namespace App\Modules\Sales\Repositories;

interface RcollectionInterface extends RepositoryInterface
{
    public function report($request);
}
