<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class NroposContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['nropos' => $request->nropos, 'user_updated_id' => Auth::user()->id];
    }
}
