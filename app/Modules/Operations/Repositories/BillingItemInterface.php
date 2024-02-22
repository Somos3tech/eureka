<?php

namespace App\Modules\Operations\Repositories;

interface BillingItemInterface extends RepositoryInterface
{
    public function findBillingItem($id);
}
