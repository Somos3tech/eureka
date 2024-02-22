<?php

namespace App\Modules\Supports\Repositories;

interface AtcmessageInterface
{
    public function create(array $data);

    public function find($id);
}
