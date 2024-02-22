<?php

namespace App\Modules\Customers\Repositories;

interface RcustomerInterface extends RepositoryInterface
{
    public function find($id);

    public function upload($request);
}
