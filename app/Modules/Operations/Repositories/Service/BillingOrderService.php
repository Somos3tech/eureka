<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class BillingOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'F', 'user_updated_id' => Auth::user()->id, 'billing_user_id' => Auth::user()->id, 'billing_at' => date('Y-m-d H:i:s')];
    }
}
