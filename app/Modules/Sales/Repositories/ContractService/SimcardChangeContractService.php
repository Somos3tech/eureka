<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class SimcardChangeContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['operator_id' => $request->operator_change_id, 'simcard_id' => $request->simcard_change_id, 'user_updated_id' => Auth::user()->id];
    }
}
