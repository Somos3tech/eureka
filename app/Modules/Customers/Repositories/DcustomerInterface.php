<?php

namespace App\Modules\Customers\Repositories;

interface DcustomerInterface extends RepositoryInterface
{
    public function select($request);

    public function find($id);
}
