<?php

namespace App\Modules\Customers\Repositories\Customer;

//Repository Customer dentro de Modulo
//use App\Modules\Customers\Repositories\Customer\CustomerServiceInterface;

class CustomerFactory
{
    public function initialize($type_contract)
    {
        switch ($type_contract) {
            case 'basic':
                return new CustomerBasic();
                break;

            default:
                throw new \Exception('Método registro Cliente no Existe', 1);
                break;
        }
    }
}
