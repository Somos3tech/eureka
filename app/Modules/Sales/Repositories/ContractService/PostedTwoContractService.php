<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class PostedTwoContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['user_posted_id' => Auth::user()->id, 'posted_at' => $request['posted_at'], 'user_updated_id' => Auth::user()->id];
    }
}
