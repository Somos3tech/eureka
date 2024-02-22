<?php

namespace App\Modules\Sales\Repositories\CollectionService;

interface CollectionServiceInterface
{
    public function create(array $data);

    public function update(array $data, $id);

    public function delete(array $request);

    public function findId($request, $id);
}
