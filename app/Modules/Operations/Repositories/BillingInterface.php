<?php

namespace App\Modules\Operations\Repositories;

interface BillingInterface extends RepositoryInterface
{
    public function findCustomer($id);

    public function report($request);

    public function pdf();

    public function api();
}
