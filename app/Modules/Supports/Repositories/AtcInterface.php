<?php

namespace App\Modules\Supports\Repositories;

interface AtcInterface
{
    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($request, $id);

    public function datatable($request);

    public function totalStatus();
}
