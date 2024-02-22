<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class UncheckOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['credicard' => null, 'user_updated_id' => Auth::user()->id];
    }
}
