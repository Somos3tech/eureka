<?php

namespace App\Modules\Sales\Repositories\Affiliate;

use App\Traits\TaskTrait;

class BfcAffiliate implements AffiliateInterface
{
    use TaskTrait;

    public function register($array, $request)
    {
        $data = [];
        $cont = 0;

        foreach ($array as $key => $row) {
            $data[$key]['consecutive'] = str_pad($cont + 1, 6, '0', STR_PAD_LEFT);
            $data[$key]['code_bank'] = '0151';
            $rif = explode('-', $row['rif']);
            $data[$key]['letter_rif'] = $rif[0];
            $data[$key]['rif'] = str_pad($rif[1].$rif[2], 10, '0', STR_PAD_LEFT);
            $data[$key]['contract'] = str_pad($row['serial'], 30, '0', STR_PAD_LEFT);
            $data[$key]['number_account'] = str_pad(str_replace('-', '', $row['account_number']), 20, '0', STR_PAD_LEFT);
            $data[$key]['business_name'] = substr(str_replace(['(', ')'], '', (str_replace(['ñ', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', '@'], ['n', 'N', 'A', 'E', 'I', 'O', 'U', 'A'], str_replace(['+', '´'], ' ', str_replace(['&'], ' Y ', str_replace(['\'', '"', '-', '+'], '', preg_replace('/[,|.]/', ' ', preg_replace("[\n|\r|\n\r]", '', $row['business_name'])))))))), 0, 35);
            if ($row['status_contract'] == 'Activo') {
                $data[$key]['type_operation'] = 'AFI';
            } elseif ($row['status_contract'] == 'Suspendido' || $row['status_contract'] == 'Cancelado') {
                $data[$key]['type_operation'] = 'DES';
            }
            $data[$key]['transaction'] = '000';
            $data[$key]['blank1'] = str_pad('', 118, ' ', STR_PAD_LEFT);
            // $data[$key]['email'] =  $row['email'];

            $cont++;
        }
        $document = '/afiliacion/0151/bank/'.'AFI026947'.date_format(now(), 'YmdHis').'.txt';

        $file = fopen(storage_path().$document, 'w'); // Abrir

        $header['zero'] = str_pad('', 6, '0', STR_PAD_LEFT);
        $header['created'] = date_format(now(), 'YmdHis');
        $header['date_lote'] = date_format(now(), 'YmdHis');
        $header['date'] = date_format(now(), 'YmdHis');
        $header['code_company'] = '026947';
        $header['zero1'] = str_pad('', 6, '0', STR_PAD_LEFT);
        $header['cant'] = str_pad($cont, 22, '0', STR_PAD_LEFT);
        $header['identificator'] = str_pad(0, 12, '0', STR_PAD_LEFT);
        $header['blank1'] = str_pad('', 136, ' ', STR_PAD_LEFT);

        $footer['code'] = '999999';
        $footer['company'] = str_pad('VEPAGOS', 40, ' ', STR_PAD_RIGHT);
        $footer['cant'] = str_pad($cont, 6, '0', STR_PAD_LEFT);
        $footer['reserve'] = str_pad('', 178, ' ', STR_PAD_RIGHT);

        fwrite($file, $header['zero'].$header['created'].$header['date_lote'].$header['date'].$header['code_company'].$header['zero1'].$header['cant'].$header['identificator'].$header['blank1'].PHP_EOL);

        foreach ($data as $final) {
            fwrite($file, $final['consecutive'].$final['code_bank'].$final['letter_rif'].$final['rif'].$final['contract'].$final['number_account'].$this->str_pad_unicode($final['business_name'], 35, ' ', STR_PAD_RIGHT).$final['type_operation'].$final['transaction'].$final['blank1'].PHP_EOL);
        }
        fwrite($file, $footer['code'].$footer['company'].$footer['cant'].$footer['reserve'].PHP_EOL);

        fclose($file); // Cerrar

        return ['filename' => $document, 'total_register' => $cont];
    }
}
