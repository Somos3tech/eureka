<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class ZoneContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['company_id' => $request->company_id, 'user_updated_id' => Auth::user()->id];
    }
}
