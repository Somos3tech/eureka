<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class TerminalOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        return  ['observ_credicard' => $request->observ_credicard, 'user_updated_id' => Auth::user()->id, 'programmer_user_id' => Auth::user()->id, 'programmer_at' => date('Y-m-d H:i:s')];
    }
}
