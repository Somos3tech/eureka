<?php

namespace App\Modules\Sales\Repositories\Conciliation;

class ConciliationFactory
{
    public function initialize($payment_method)
    {
        switch ($payment_method) {
            case 'Efectivo':
                return new SuccessConciliation();
                break;

            case 'Transferencia':
                return new SuccessConciliation();
                break;

            case 'Deposito':
                return new SuccessConciliation();
                break;

            case 'Postpago':
                return new PostpagoConciliation();
                break;

            case 'Convenio':
                return new FinancingConciliation();
                break;

            case 'Parcial':
                return new FinancingConciliation();
                break;

            case 'DTE':
                return new SuccessConciliation();
                break;

            case 'Custodia':
                return new SuccessConciliation();
                break;

            case 'DTEP':
                return new FinancingConciliation();
                break;

            case 'Financiamiento':
                return new FinancingConciliation();
                break;

            case 'CostoCero':
                return new SuccessConciliation();
                break;

            case 'Banplus':
                return new StatusConciliation();
                break;

            case 'pending':
                return new PendingConciliation();
                break;

            default:
                throw new \Exception('Método de Conciliación no Soportado', 1);
                break;
        }
    }
}
