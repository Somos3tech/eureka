<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Banesco implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\n", file_get_contents(storage_path($request['file_response_bank']), true));
        $count = 0;

        foreach ($array as $key => $row) {
            if (substr($row, 1, 2) == '22') {
                $data[$key]['bank_id'] = $request['bank_id'];
                $data[$key]['referencia'] = (int) substr($row, 3, 20);
                $data[$key]['afiliado'] = '';
                $data[$key]['nropos'] = '';
                $data[$key]['invoice_id'] = (int) substr($row, 3, 20);
                $day = substr($row, 79, 2);
                $month = substr($row, 77, 2);
                $year = substr($row, 73, 4);
                $data[$key]['fechpro'] = $year . '-' . $month . '-' . $day;
                $data[$key]['status_bank'] = (int) trim(substr($array[$count + 1], 2, 4));
                $data[$key]['amount'] = (int) substr($row, 82, 16) / 100;
                $data[$key]['amount_currency'] = $request['amount_currency_old'];
                $data[$key]['motivo_del_fallido'] = trim(substr($array[$count + 1], 6, 30));
                $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';

                /*
                $data[$key]['bank_id'] = $request['bank_id'];
                $data[$key]['referencia'] = (int) substr($row, 181, 20);
                $data[$key]['afiliado'] = '';
                $data[$key]['nropos'] = '';
                $data[$key]['invoice_id'] = (int) substr($row, 181, 20);
                $day = substr($row, 158, 2);
                $month = substr($row, 161, 2);
                $year = substr($row, 164, 4);
                $data[$key]['fechpro'] = $year . '-' . $month . '-' . $day;
                $data[$key]['status_bank'] = substr($row, 253, 3);
                $data[$key]['amount'] = (int) substr($row, 168, 13) / 100;
                $data[$key]['amount_currency'] = $request['amount_currency_old'];
                $data[$key]['motivo_del_fallido'] = substr($row, 253, 3) != '010' ? trim(substr($array[$count + 1], 31, 250)) : trim(substr($row, 256, 120));
                $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
                */
            }
            $count++;
        }

        return $data;
    }
}
