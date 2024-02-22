<?php

namespace App\Modules\Sales\Repositories\Affiliate;

class AffiliateFactory
{
    public function initialize($array, $request)
    {
        switch ($request['bank_id']) {
            case 2:
                return new BfcAffiliate($array, $request);
                break;

            case 4:
                return new BancrecerAffiliate($array, $request);
                break;

            case 6:
                return new DelSurAffiliate($array, $request);
                break;

            case 9:
                return new MercantilAffiliate($array, $request);
                break;

            default:
                throw new \Exception('Banco Sin soporte de Afiliación Bancaría', 1);
                break;
        }
    }
}
