<?php

namespace App\Modules\Sales\Repositories;

interface SaleInterface
{
    public function create($request);

    public function report($request);

    public function reportCollection($request);

    public function upload($request);
}
