<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Banplus implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));
        $file = $request['file_response_bank'];
        foreach ($array as $key => $row) {
            $data[$key]['bank_id'] = $request['bank_id'];
            $day = substr($row, 153, 2);
            $month = substr($row, 156, 2);
            $year = substr($row, 159, 4);
            $data[$key]['fechpro'] = $year.'-'.$month.'-'.$day;
            $data[$key]['afiliado'] = substr($row, 0, 8);
            $data[$key]['nropos'] = str_pad(substr($row, 8, 3), 3, '0', STR_PAD_LEFT);
            $data[$key]['invoice_id'] = substr($row, 183, 9);
            $data[$key]['amount'] = (int) substr($row, 117, 15) / 100;
            $data[$key]['amount_currency'] = $request['amount_currency_old'];
            $data[$key]['motivo_del_fallido'] = preg_replace('/[0-9]+/', '', trim(substr($row, 289, 60)));
            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
            $data[$key]['status_bank'] = trim(substr($row, 213, 1));
            $data[$key]['referencia'] = substr($row, 183, 9);
        }

        return $data;
    }
}
