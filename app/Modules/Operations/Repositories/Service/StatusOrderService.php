<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class StatusOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'P', 'user_updated_id' => Auth::user()->id];
    }
}
