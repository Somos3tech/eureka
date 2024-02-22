<?php

namespace App\Modules\Users\Repositories\Role;

use App\Modules\Users\Repositories\RepositoryInterface;

interface RoleInterface extends RepositoryInterface
{
    public function validRole($role, $slug);

    public function getRole();

    public function select($request);
}
