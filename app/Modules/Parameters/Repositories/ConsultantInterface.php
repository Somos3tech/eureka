<?php

namespace App\Modules\Parameters\Repositories;

interface ConsultantInterface extends RepositoryInterface
{
    public function select();

    public function select2($user_id);
}
