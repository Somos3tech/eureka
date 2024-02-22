<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class StoreOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'A', 'user_updated_id' => Auth::user()->id, 'receive_store_id' => Auth::user()->id, 'receive_store_at' => date('Y-m-d h:j:s')];
    }
}
