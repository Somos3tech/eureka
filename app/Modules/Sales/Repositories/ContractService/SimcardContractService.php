<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class SimcardContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return ['simcard_id' => $request->simcard_id, 'nropos' => (int) $request->nropos, 'user_updated_id' => Auth::user()->id];
    }
}
