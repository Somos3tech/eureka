<?php

namespace App\Modules\Sales\Repositories;

interface RepositoryInterface
{
    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);
}
