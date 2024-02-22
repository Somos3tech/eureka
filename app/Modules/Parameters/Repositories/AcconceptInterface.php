<?php

namespace App\Modules\Parameters\Repositories;

interface AcconceptInterface extends RepositoryInterface
{
    public function manageAcconcept($filter);

    public function select($request);
}
