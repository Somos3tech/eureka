<?php

namespace App\Modules\Warehouses\Repositories\Assignment;

use Auth;

class StoreAssignmentService implements AssignmentServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'A', 'user_updated_id' => Auth::user()->id];
    }
}
