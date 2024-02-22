<?php

namespace App\Modules\Sales\Repositories\Contract;

//Repository Contract dentro de Modulo

class ContractFactory
{
    public function initialize($type_contract)
    {
        switch ($type_contract) {
            case 'basic':
                return new ContractBasic();
                break;

            default:
                throw new \Exception('Método registro Contrato no Existe', 1);
                break;
        }
    }
}
