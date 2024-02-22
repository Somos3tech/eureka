<?php

namespace App\Modules\Operations\Repositories\Service;

//Repository Contract dentro de Modulo

class OrderServiceFactory
{
    public function initialize($type_service)
    {
        switch ($type_service) {
            case 'Terminal':
                return new TerminalOrderService();
                break;

            case 'Simcard':
                return new SimcardOrderService();
                break;

            case 'OutSimcard':
                return new SimcardOrderService();
                break;

            case 'Store':
                return new StoreOrderService();
                break;

            case 'Billing':
                return new BillingOrderService();
                break;

            case 'Billingout':
                return new BillingoutOrderService();
                break;

            case 'Office':
                return new OfficeOrderService();
                break;

            case 'Posted':
                return new PostedOrderService();
                break;

            case 'Check':
                return new CheckOrderService();
                break;

            case 'Uncheck':
                return new UncheckOrderService();
                break;

            case 'Support':
                return new SupportOrderService();
                break;

            case 'Management':
                return new StatusOrderService();
                break;

            case 'Csupport':
                return new CsupportOrderService();
                break;
            default:
                throw new \Exception('Método Servicio No Soportado', 1);
                break;
        }
    }
}
