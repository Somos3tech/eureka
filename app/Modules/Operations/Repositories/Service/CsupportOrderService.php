<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class CsupportOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['csupport_id' => $request['csupport_id'], 'user_updated_id' => Auth::user()->id];
    }
}
