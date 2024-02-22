<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Tesoro implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));

        foreach ($array as $key => $row) {
            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['status_bank'] = substr($row, 55, 1) != '0' ? substr($row, 55, 1) : 'R';
            $data[$key]['afiliado'] = '';
            $data[$key]['nropos'] = '';
            $day = substr($row, 4, 2);
            $month = substr($row, 6, 2);
            $year = substr($row, 8, 2);
            $data[$key]['fechpro'] = '20'.$year.'-'.$month.'-'.$day;
            $data[$key]['invoice_id'] = (int) substr($row, 91, 20);
            $data[$key]['referencia'] = (int) substr($row, 91, 20);
            $data[$key]['amount'] = (int) substr($row, 40, 15) / 100;
            $data[$key]['amount_currency'] = $request['amount_currency_old'];
            $data[$key]['motivo_del_fallido'] = trim(substr($row, 57, 33)) != '' ? trim(substr($row, 57, 33)) : 'Cobro Conciliado';
            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
        }

        return $data;
    }
}
