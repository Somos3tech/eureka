<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class AmountContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['currency_id' => $request->currency_id, 'amount' => $request->amount, 'user_updated_id' => Auth::user()->id];
    }
}
