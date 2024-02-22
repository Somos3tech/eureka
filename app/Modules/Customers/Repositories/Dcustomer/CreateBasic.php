<?php

namespace App\Modules\Customers\Repositories\Dcustomer;

use Auth;

class CreateBasic implements DcustomerServiceInterface
{
    public function create($request)
    {
        if ($request['checkbox'] == 'on') {
            $multicommerce = 1;
        } else {
            $multicommerce = null;
        }
        if ($request['personal_signature'] == 'on') {
            $personal_signature = 1;
        } else {
            $personal_signature = null;
        }
        $data = [
            'customer_id' => $request['customer_id'],
            'multicommerce' => $multicommerce,
            'rif' => $request['rif'],
            'business_name' => $request['business_name'],
            'bank_id' => $request['bank_id'],
            'affiliate_number' => $request['affiliate_number'],
            'type_account' => $request['type_account'],
            'account_number' => $request['account_number'],
            'personal_signature' => $personal_signature,
            'user_created_id' => Auth::user()->id,
            'user_updated_id' => Auth::user()->id,
        ];

        return $data;
    }
}
