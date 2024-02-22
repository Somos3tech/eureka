<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class SaleUserContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['user_created_id' => $request->user_id, 'consultant_id' => $request->consultant_id, 'user_updated_id' => Auth::user()->id];
    }
}
