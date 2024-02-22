<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class CheckOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['credicard' => 1, 'user_updated_id' => Auth::user()->id];
    }
}
