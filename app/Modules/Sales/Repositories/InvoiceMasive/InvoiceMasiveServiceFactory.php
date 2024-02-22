<?php

namespace App\Modules\Sales\Repositories\InvoiceMasive;

//Repository Contract dentro de Modulo

class InvoiceMasiveServiceFactory
{
    public function initialize($request, $row)
    {
        switch ($request->type_service) {
            case 'D':
                return new Daily($request, $row);
                break;

            case 'S':
                return new Weekly($request, $row);
                break;

            case 'Q':
                return new Biweekly($request, $row);
                break;

            case 'M':
                return new Monthly($request, $row);
                break;

            default:
                throw new \Exception('Servicio No Existente', 1);
                break;
        }
    }
}
