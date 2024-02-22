<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class CreatedContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['created_at' => $request->created_at, 'user_updated_id' => Auth::user()->id];
    }
}
