<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class ModelTerminalContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['modelterminal_id' => $request->modelterminal_id, 'user_updated_id' => Auth::user()->id];
    }
}
