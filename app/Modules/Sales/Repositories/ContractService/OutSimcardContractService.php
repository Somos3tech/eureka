<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class OutSimcardContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return ['simcard_id' => null, 'nropos' => (int) $request->nropos, 'user_updated_id' => Auth::user()->id];
    }
}
