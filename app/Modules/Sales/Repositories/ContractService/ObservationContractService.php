<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class ObservationContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        return  ['observation' => $request->observation, 'user_updated_id' => Auth::user()->id];
    }
}
