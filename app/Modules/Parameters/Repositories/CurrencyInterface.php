<?php

namespace App\Modules\Parameters\Repositories;

interface CurrencyInterface extends RepositoryInterface
{
    public function select($request);

    public function report($request);
}
