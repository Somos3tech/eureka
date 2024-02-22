<?php

namespace App\Modules\Sales\Repositories\Payment;

//Repository Contract dentro de Modulo

class PaymentFactory
{
    public function initialize($payment_method)
    {
        switch ($payment_method) {
            case '1':
                return new DtcPayment();
                break;

            case '2':
                return new TransferPayment();
                break;

            case '3':
                return new DtcPayment();
                break;

            case '4':
                return new DtePayment();
                break;

            case '5':
                return new CustodyPayment();
                break;

            case '6':
                return new DepositPayment();
                break;

            case '7':
                return new PostpayPayment();
                break;

            case 'debito':
                return new DebitPayment();
                break;

            case 'negociacion':
                return new NegotiationPayment();
                break;
            default:
                throw new \Exception('Método de Pago no Soportado', 1);
                break;
        }
    }
}
