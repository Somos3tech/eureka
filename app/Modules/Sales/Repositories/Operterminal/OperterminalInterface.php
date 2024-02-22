<?php

namespace App\Modules\Sales\Repositories\Operterminal;

use App\Modules\Sales\Repositories\RepositoryInterface;

interface OperterminalInterface extends RepositoryInterface
{
    public function report($request);

    public function datatable($request);

    public function reactive($id);
}
