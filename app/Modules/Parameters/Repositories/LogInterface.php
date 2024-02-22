<?php

namespace App\Modules\Parameters\Repositories;

interface LogInterface
{
    public function create($request);

    public function activity($id, $item_table);

    public function report($request);
}
