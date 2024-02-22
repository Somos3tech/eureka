<?php

namespace App\Modules\Sales\Repositories\Affiliate;

class downloadAffiliateFactory
{
    public function fileDownload($request, $data)
    {
        switch ($request['bank_id']) {
            case 4:
                return new fileBancrecer($data);
                break;

            case 6:
                return new fileDelSur($data);
                break;

            default:
                throw new \Exception('Banco Sin generación de Archivo', 1);
                break;
        }
    }
}
