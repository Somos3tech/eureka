<?php

namespace App\Modules\Sales\Repositories\Affiliate\Response;

class AffiliateResponseFactory
{
    public function initialize($array)
    {
        switch ($array['bank_id']) {
            case 2:
                return new BfcAffiliateResponse($array);
                break;

            case 4:
                return new BancrecerAffiliateResponse($array);
                break;

            case 6:
                return new DelSurAffiliateResponse($array);
                break;

            case 9:
                return new MercantilAffiliateResponse($array);
                break;

            default:
                throw new \Exception('Banco No encontrado', 1);
                break;
        }
    }
}
