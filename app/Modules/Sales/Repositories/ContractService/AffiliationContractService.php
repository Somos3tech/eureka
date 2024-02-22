<?php

namespace App\Modules\Sales\Repositories\ContractService;

use Auth;

class AffiliationContractService implements ContractServiceInterface
{
    public function updateField($request)
    {
        if ($request->type_dcustomer == 'commerce' || $request->type_dcustomer == 'nodom') {
            return  ['type_dcustomer' => $request->type_dcustomer, 'dcustomer_id' => $request->dcustomer_id, 'dcustomer_multiple' => null, 'negotiation_id' => $request->negotiation_id, 'user_updated_id' => Auth::user()->id];
        } else {
            if ($request->type_dcustomer == 'multicommerce') {
                return  ['type_dcustomer' => $request->type_dcustomer, 'dcustomer_id' => null, 'dcustomer_multiple' => json_encode($request->dcustomer_multiple), 'negotiation_id' => null, 'user_updated_id' => Auth::user()->id];
            }
        }
    }
}
