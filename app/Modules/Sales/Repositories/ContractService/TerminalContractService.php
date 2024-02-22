<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class TerminalContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['terminal_id' => $request->terminal_id, 'user_updated_id' => Auth::user()->id];
    }
}
