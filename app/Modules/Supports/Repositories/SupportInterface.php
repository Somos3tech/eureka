<?php

namespace App\Modules\Supports\Repositories;

interface SupportInterface extends RepositoryInterface
{
    public function report($request);
}
