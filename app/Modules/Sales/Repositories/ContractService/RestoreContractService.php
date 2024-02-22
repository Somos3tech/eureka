<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class RestoreContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['terminal_id' => null, 'simcard_id' => null, 'user_updated_id' => Auth::user()->id];
    }
}
