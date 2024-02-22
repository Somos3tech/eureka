<?php

namespace App\Modules\Users\Repositories\User;

use App\Modules\Users\Repositories\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    public function select($slug, $user_id, $company_id);

    public function assignment($request);
}
