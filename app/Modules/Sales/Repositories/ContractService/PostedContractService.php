<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class PostedContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['status' => 'Activo', 'user_posted_id' => Auth::user()->id, 'posted_at' => $request['date'], 'user_updated_id' => Auth::user()->id];
    }
}
