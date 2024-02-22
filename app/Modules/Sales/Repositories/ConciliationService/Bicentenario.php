<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Bicentenario implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));

        foreach ($array as $key => $row) {
            if (substr($row, 0, 4) == '0670') {
                $data[$key]['bank_id'] = $request['bank_id'];
                $data[$key]['status_bank'] = substr($row, 128, 4) != '' ? substr($row, 128, 4) : '0012';
                $data[$key]['afiliado'] = substr($row, 23, 8);
                $data[$key]['nropos'] = '';
                $day = (int) substr($row, 32, 2);
                if (strlen($day) == 1) {
                    $day = '0'.$day;
                }
                $month = substr($row, 35, 2);
                $year = substr($row, 38, 4);
                $data[$key]['fechpro'] = $year.'-'.$month.'-'.$day;
                $data[$key]['amount'] = (float) str_replace(',', '.', substr($row, 42, 26));
                $data[$key]['amount_currency'] = $request['amount_currency_old'];
                $data[$key]['account'] = substr($row, 11, 10);
                $data[$key]['motivo_del_fallido'] = trim(substr($row, 109, 15)) != '' ? trim(substr($row, 109, 15)) : 'Cobro Conciliado';
                $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
            }
        }

        return $data;
    }
}
