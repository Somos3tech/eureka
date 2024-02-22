<?php

namespace App\Modules\Sales\Repositories\Affiliate;

use App\Traits\TaskTrait;

class MercantilAffiliate implements AffiliateInterface
{
    use TaskTrait;

    public function register($array, $request)
    {
        $data = [];
        $cont = 0;
        $total_amount = 0;

        foreach ($array as $key => $row) {
            $data[$key]['fixed'] = '2';
            $data[$key]['type_service'] = 'A';
            $rif = explode('-', $row['rif']);
            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || ($rif[0] == 'E' && $row['personal_signature'] != 1)) {
                $data[$key]['rif'] = $rif[0].str_pad($rif[1], 10, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'V' && $row['personal_signature'] == 1 || $rif[0] == 'E' && $row['personal_signature'] == 1) {
                $data[$key]['rif'] = $rif[0].str_pad($rif[1].$rif[2], 10, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['rif'] = $rif[0].str_pad($rif[1].$rif[2], 10, '0', STR_PAD_LEFT);
            }
            $data[$key]['business_name'] = substr((str_replace(['ñ', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', '@'], ['n', 'N', 'A', 'E', 'I', 'O', 'U', 'A'], str_replace(['+', '´'], ' ', str_replace(['&'], ' Y ', str_replace(['\'', '"', '-', '+'], '', preg_replace('/[,|.]/', ' ', preg_replace("[\n|\r|\n\r]", '', $row['business_name']))))))), 0, 30);
            $data[$key]['number_account'] = str_pad(str_replace('-', '', $row['account_number']), 21, '0', STR_PAD_LEFT);
            $data[$key]['serial'] = str_pad($row['serial'], 16, ' ', STR_PAD_RIGHT);
            $data[$key]['reserve_bank'] = str_pad('', 9, ' ', STR_PAD_RIGHT);
            $data[$key]['free'] = str_pad('', 1, ' ', STR_PAD_RIGHT);
            $data[$key]['origen'] = str_pad(2, 1, ' ', STR_PAD_RIGHT);
            $data[$key]['reserve'] = str_pad('', 17, '0', STR_PAD_RIGHT);
            $data[$key]['reserve2'] = str_pad('', 17, '0', STR_PAD_RIGHT);
            $data[$key]['reserve3'] = str_pad('', 1, '0', STR_PAD_RIGHT);
            $data[$key]['response'] = str_pad('', 3, '0', STR_PAD_LEFT);
            $data[$key]['reserve4'] = str_pad('', 30, ' ', STR_PAD_RIGHT);
            $data[$key]['reserve_bank2'] = str_pad('', 81, ' ', STR_PAD_RIGHT);

            $cont++;
        }

        $document = '/afiliacion/0105/bank/'.'MERCANTIL_AFI_'.date_format(now(), 'YmdHis').'.txt';

        $file = fopen(storage_path().$document, 'w'); // Abrir

        $header['type'] = '1';
        $header['identificator'] = str_pad('BAMRVECA', 12, ' ', STR_PAD_RIGHT);
        $header['lote'] = str_pad('1', 15, ' ', STR_PAD_RIGHT);
        $header['rif'] = 'J0411024449';
        $header['code_product'] = 'DOMIC';
        $header['date_register'] = date_format(now(), 'Ymd');
        $header['cont'] = str_pad($cont, 10, '0', STR_PAD_LEFT);
        $header['response'] = str_pad('', 3, '0', STR_PAD_LEFT);
        $header['free'] = str_pad('', 180, ' ', STR_PAD_LEFT);

        fwrite($file, $header['type'].$header['identificator'].$header['lote'].$header['rif'].$header['code_product'].$header['date_register'].$header['cont'].$header['rif'].$header['response'].$header['free'].PHP_EOL);

        foreach ($data as $final) {
            fwrite($file, $final['fixed'].$final['type_service'].$final['rif'].$this->str_pad_unicode($final['business_name'], 30, ' ', STR_PAD_RIGHT).$final['number_account'].$final['serial'].
                $final['reserve_bank'].$final['serial'].$final['free'].$final['origen'].$final['reserve'].$final['reserve2'].$final['reserve3'].$final['response'].$final['reserve4'].$final['reserve_bank2'].PHP_EOL);
        }

        fclose($file); // Cerrar

        return ['filename' => $document, 'total_register' => $cont];
    }
}
