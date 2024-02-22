<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class TermContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['term_id' => $request->term_id, 'user_updated_id' => Auth::user()->id];
    }
}
