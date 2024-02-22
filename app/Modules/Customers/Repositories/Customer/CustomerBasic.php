<?php

namespace App\Modules\Customers\Repositories\Customer;

use Auth;

class CustomerBasic implements CustomerServiceInterface
{
    public function dataBasic($request)
    {
        return [
            'foreign_id' => $request['foreign_id'] != '' ? $request['foreign_id'] : null,
            'company_id' => $request['company_id'],
            'rif' => $request['rif'],
            'business_name' => $request['business_name'],
            'email' => $request['email'],
            'mobile' => $request['mobile'],
            'telephone' => $request['telephone'],
            'cactivity_id' => $request['cactivity_id'],
            'state_id' => $request['state_id'],
            'city_id' => $request['city_id'],
            'municipality' => $request['municipality'],
            'address' => $request['address'],
            'postal_code' => $request['postal_code'] ?? null,
            'type_cont' => $request['type_cont'],
            'tax' => $request['tax'],
            'city_register' => $request['city_register'],
            'comercial_register' => $request['comercial_register'],
            'date_register' => date('Y-m-d', strtotime($request['date_register'])),
            'number_register' => $request['number_register'],
            'took_register' => $request['took_register'],
            'clause_register' => $request['clause_register'],
            'rif_path' => $request['rif_path'] ?? null,
            'rm_path' => $request['rm_path'] ?? null,
            'bank_path' => $request['bank_path'] ?? null,
            'auth_bank_path' => $request['auth_bank_path'] ?? null,
            'fiscal' => $request['checkbox'] ? 1 : 0,
            'state_fiscal_id' => $request['state_fiscal_id'] ?? null,
            'city_fiscal_id' => $request['city_fiscal_id'] ?? null,
            'municipality_fiscal' => $request['municipality_fiscal'] ?? null,
            'address_fiscal' => $request['address_fiscal'] ?? null,
            'postal_code_fiscal' => $request['postal_code_fiscal'] ?? null,
        ];
    }

    /******************************************************************************/
    public function create($request)
    {
        $data_user = [
            'user_created_id' => Auth::user()->id,
        ];

        $data = array_merge($this->dataBasic($request), $data_user);

        return $data;
    }

    /******************************************************************************/
    public function update($request)
    {
        $data_user = [
            'user_updated_id' => Auth::user()->id,
        ];

        $data = array_merge($this->dataBasic($request), $data_user);

        return $data;
    }
}
