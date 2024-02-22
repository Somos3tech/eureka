<?php

namespace App\Modules\Parameters\Repositories;

interface BankInterface extends RepositoryInterface
{
    public function select($request);
}
