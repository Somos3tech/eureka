<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class SimcardOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['observ_programmer' => $request->observ_programmer, 'status' => 'D', 'user_updated_id' => Auth::user()->id, 'programmer_user_id' => Auth::user()->id, 'programmer_finish_at' => date('Y-m-d H:i:s')];
    }
}
