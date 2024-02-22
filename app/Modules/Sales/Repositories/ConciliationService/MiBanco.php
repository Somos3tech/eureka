<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class MiBanco implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));
        $file = $request['file_response_bank'];
        $filename = explode('/', $file);
        $filename = explode('.', $filename[4]);
        $fechpro = substr($filename[0], 9, 4).'-'.substr($filename[0], 7, 2).'-'.substr($filename[0], 5, 2);
        foreach ($array as $key => $row) {
            if ($key > 0) {
                $data[$key - 1]['bank_id'] = $request['bank_id'];
                $data[$key - 1]['fechpro'] = $fechpro;
                $data[$key - 1]['referencia'] = substr($row, 56, 8).'-'.str_pad(substr($row, 68, 1), 3, '0', STR_PAD_LEFT);
                $data[$key - 1]['afiliado'] = substr($row, 56, 8);
                $data[$key - 1]['nropos'] = str_pad(substr($row, 68, 1), 3, '0', STR_PAD_LEFT);
                $data[$key - 1]['invoice_id'] = '';
                $data[$key - 1]['amount'] = (int) substr($row, 41, 15) / 100;
                $data[$key - 1]['amount_currency'] = $request['amount_currency_old'];
                $data[$key - 1]['motivo_del_fallido'] = preg_replace('/[0-9]+/', '', trim(substr($row, 75, 40)));
                $data[$key - 1]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
                $data[$key - 1]['status_bank'] = trim(substr($row, 74, 1));
            }
        }

        return $data;
    }
}
