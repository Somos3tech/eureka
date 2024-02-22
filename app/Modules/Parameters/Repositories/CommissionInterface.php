<?php

namespace App\Modules\Parameters\Repositories;

interface CommissionInterface extends RepositoryInterface
{
    public function select($condition);
}
