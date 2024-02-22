<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class DeleteContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'Eliminado', 'user_updated_id' => Auth::user()->id];
    }
}
