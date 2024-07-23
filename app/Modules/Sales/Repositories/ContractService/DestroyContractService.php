<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class DestroyContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['terminal_id' => null, 'simcard_id' => null, 'status' => 'Anulado', 'user_updated_id' => Auth::user()->id];
    }
}
