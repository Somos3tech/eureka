<?php

namespace App\Modules\Sales\Repositories\Service;

//Repository Contract dentro de Modulo

class ServiceInvoiceFactory
{
    public function initialize($type_service)
    {
        switch ($type_service) {
            case 'Created':
                return new Created();
                break;

            case 'PaymentDate':
                return new PaymentDate();
                break;

            case 'Refer':
                return new Refere();
                break;

            case 'Attachment':
                return new Attachment();
                break;

            case 'PaymentMethod':
                return new PaymentMethod();
                break;

            case 'Amount':
                return new Amount();
                break;

            case 'Free':
                return new Free();
                break;

            case 'Dicom':
                return new Dicom();
                break;

            default:
                throw new \Exception('Método de Pago no Soportado', 1);
                break;
        }
    }
}
