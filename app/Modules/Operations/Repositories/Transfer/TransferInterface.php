<?php

namespace App\Modules\Operations\Repositories\Transfer;

interface TransferInterface
{
    public function posted($request, $id);
}
