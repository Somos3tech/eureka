<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

//Repository Contract dentro de Modulo

class ConciliationServiceFactory
{
    public function initialize($request)
    {
        switch ($request['bank_id']) {
            case '1':
                return new Bdv($request);
                break;

            case '2':
                return new Bfc($request);
                break;

            case '3':
                return new BancoPlaza($request);
                break;

            case '4':
                return new Bancrecer($request);
                break;

            case '5':
                return new Banplus($request);
                break;

            case '6':
                return new DelSur($request);
                break;

            case '7':
                return new MiBanco($request);
                break;

            case '8':
                return new Bicentenario($request);
                break;

            case '9':
                return new Mercantil($request);
                break;

            case '10':
                return new Tesoro($request);
                break;

            case '11':
                return new Activo($request);
                break;

            case '12':
                return new CienxCiento($request);
                break;

            case '13':
                return new Bancaribe($request);
                break;

            case '14':
                return new Provincial($request);
                break;

            case '15':
                return new Banesco($request);
                break;

            default:
                throw new \Exception('Banco no Existente', 1);
                break;
        }
    }
}
