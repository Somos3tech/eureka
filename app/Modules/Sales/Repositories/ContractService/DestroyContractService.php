<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class DestroyContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'Anulado', 'user_updated_id' => Auth::user()->id];
    }
}
