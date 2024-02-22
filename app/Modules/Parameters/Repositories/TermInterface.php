<?php

namespace App\Modules\Parameters\Repositories;

interface TermInterface extends RepositoryInterface
{
    public function select($request);
}
