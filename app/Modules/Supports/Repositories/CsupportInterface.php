<?php

namespace App\Modules\Supports\Repositories;

interface CsupportInterface extends RepositoryInterface
{
    public function findContract($contract_id);

    public function validAffiliate($data);
}
