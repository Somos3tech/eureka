<?php

namespace App\Modules\Customers\Repositories\Dcustomer;

//Repository Customer dentro de Modulo

class DcustomerFactory
{
    public function initialize($type_contract)
    {
        switch ($type_contract) {
            case 'basic':
                return new CreateBasic();
                break;

            default:
                throw new \Exception('Método registro Cliente en No. Afiliación no Existe', 1);
                break;
        }
    }
}
