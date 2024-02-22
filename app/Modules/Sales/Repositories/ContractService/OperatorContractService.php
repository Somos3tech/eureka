<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class OperatorContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        if ($request->simcard_checkbox == 'on' || $request->checkbox == 'on') {
            $valid_simcard = 1;
            $operator_id = null;
        } else {
            $valid_simcard = 0;
            $operator_id = $request->operator_id;
        }

        return  ['valid_simcard' => $valid_simcard, 'operator_id' => $operator_id, 'user_updated_id' => Auth::user()->id];
    }
}
