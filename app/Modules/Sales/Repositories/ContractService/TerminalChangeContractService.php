<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class TerminalChangeContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return ['modelterminal_id' => $request->modelTerminal_change_id, 'terminal_id' => $request->terminal_change_id, 'user_updated_id' => Auth::user()->id];
    }
}
