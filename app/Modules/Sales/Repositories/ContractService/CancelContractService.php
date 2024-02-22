<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class CancelContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'Cancelado', 'user_updated_id' => Auth::user()->id];
    }
}
