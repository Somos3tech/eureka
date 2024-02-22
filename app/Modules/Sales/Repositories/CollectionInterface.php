<?php

namespace App\Modules\Sales\Repositories;

interface CollectionInterface extends RepositoryInterface
{
    public function statements($request);

    public function findId($request, $id);

    public function deleteCollect($request);
}
