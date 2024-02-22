<?php

namespace App\Modules\Warehouses\Repositories\Assignment;

use Auth;

class PostedAssignmentService implements AssignmentServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'C', 'user_updated_id' => Auth::user()->id];
    }
}
