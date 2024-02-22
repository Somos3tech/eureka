<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class BillingoutOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'F', 'user_updated_id' => Auth::user()->id];
    }
}
