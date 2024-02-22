<?php

namespace App\Modules\Customers\Repositories;

interface RepositoryInterface
{
    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function datatable($request);
}
