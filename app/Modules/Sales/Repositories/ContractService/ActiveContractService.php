<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class ActiveContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'Activo', 'reactive_date' => $request->reactive_date, 'user_updated_id' => Auth::user()->id];
    }
}
