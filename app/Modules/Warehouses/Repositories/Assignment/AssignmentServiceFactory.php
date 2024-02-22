<?php

namespace App\Modules\Warehouses\Repositories\Assignment;

class AssignmentServiceFactory
{
    public function initialize($type_service)
    {
        switch ($type_service) {
            case 'Store':
                return new StoreAssignmentService();
                break;

            case 'Billing':
                return new BillingAssignmentService();
                break;

            case 'Office':
                return new OfficeAssignmentService();
                break;

            case 'Posted':
                return new PostedAssignmentService();
                break;

            case 'Simcard':
                return new OfficeAssignmentService();
                break;

            case 'Support':
                return new SupportAssignmentService();
                break;

            default:
                throw new \Exception('Método Servicio No Soportado', 1);
                break;
        }
    }
}
