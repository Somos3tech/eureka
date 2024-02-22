<?php

namespace App\Modules\Parameters\Repositories;

interface PayerInterface
{
    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);
}
