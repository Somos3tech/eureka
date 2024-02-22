<?php

namespace App\Modules\Users\Repositories\Permission;

use App\Modules\Users\Repositories\RepositoryInterface;

interface PermissionInterface extends RepositoryInterface
{
    public function select();
}
