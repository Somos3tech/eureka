<?php

namespace App\Modules\Parameters\Repositories;

interface ApnInterface extends RepositoryInterface
{
    public function select($request);
}
