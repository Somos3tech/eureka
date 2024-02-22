<?php

namespace App\Modules\Parameters\Repositories;

interface ComissionInterface extends RepositoryInterface
{
    public function select($condition);
}
