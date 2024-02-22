<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class ConsultantContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['consultant_id' => $request->consultant_id, 'user_updated_id' => Auth::user()->id];
    }
}
