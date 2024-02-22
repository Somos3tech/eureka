<?php

namespace App\Modules\Parameters\Repositories;

interface CompanyInterface extends RepositoryInterface
{
    public function zoneValid($request);

    public function select($request);
}
