<?php

namespace App\Modules\Sales\Repositories\Payment;

//Repository Contract dentro de Modulo

class InvoiceItemFactory
{
    public function initialize($payment_method)
    {
        switch ($payment_method) {
            case 'Convenio':
                return new AgreementInvoiceItem();
                break;

            case 'Parcial':
                return new ParcialInvoiceItem();
                break;

            case 'Financiamiento':
                return new FinancingInvoiceItem();
                break;

            case 'DTEP':
                return new DtepInvoiceItem();
                break;
            default:
                throw new \Exception('Método de Pago no Soportado', 1);
                break;
        }
    }
}
