<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class OfficeOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'D', 'user_updated_id' => Auth::user()->id, 'assign_office_id' => Auth::user()->id, 'assign_office_at' => date('Y-m-d H:i:s')];
    }
}
