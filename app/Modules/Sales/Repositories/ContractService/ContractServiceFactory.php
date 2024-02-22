<?php

namespace App\Modules\Sales\Repositories\ContractService;

//Repository Contract dentro de Modulo

class ContractServiceFactory
{
    public function initialize($type_service)
    {
        switch ($type_service) {
            case 'Created':
                return new CreatedContractService();
                break;

            case 'Affiliation':
                return new AffiliationContractService();
                break;

            case 'Terminal':
                return new TerminalContractService();
                break;

            case 'Simcard':
                return new SimcardContractService();
                break;

            case 'OutSimcard':
                return new OutSimcardContractService();
                break;
            case 'TerminalChange':
                return new TerminalChangeContractService();
                break;

            case 'SimcardChange':
                return new SimcardChangeContractService();
                break;

            case 'ModelTerminal':
                return new ModelTerminalContractService();
                break;

            case 'Operator':
                return new OperatorContractService();
                break;

            case 'Nropos':
                return new NroposContractService();
                break;

            case 'Term':
                return new TermContractService();
                break;

            case 'Zone':
                return new ZoneContractService();
                break;

            case 'Company':
                return new ZoneContractService();
                break;

            case 'Amount':
                return new AmountContractService();
                break;

            case 'Posted':
                return new PostedContractService();
                break;

            case 'PostedTwo':
                return new PostedTwoContractService();
                break;

            case 'User':
                return new SaleUserContractService();
                break;

            case 'Cancel':
                return new CancelContractService();
                break;

            case 'Destroy':
                return new DestroyContractService();
                break;
            case 'Delete':
                return new DeleteContractService();
                break;
            case 'Reactive':
                return new ActiveContractService();
                break;

            case 'Restore':
                return new RestoreContractService();
                break;

            case 'ObservationChange':
                return new ObservationContractService();
                break;

            default:
                throw new \Exception('Método Tipo Servicio en Contrato No Soportado', 1);
                break;
        }
    }
}
