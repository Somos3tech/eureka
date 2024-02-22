<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Bancrecer implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));

        foreach ($array as $key => $row) {
            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['referencia'] = (int) substr($row, 6, 9);
            $data[$key]['afiliado'] = '';
            $data[$key]['nropos'] = '';
            $data[$key]['invoice_id'] = (int) substr($row, 6, 9);
            $data[$key]['contrato'] = (int) substr($row, 15, 30);
            $data[$key]['factura'] = (int) substr($row, 45, 20);
            $data[$key]['status_bank'] = substr($row, 91, 4);
            $day = substr($row, 65, 2);
            $month = substr($row, 67, 2);
            $year = substr($row, 69, 4);
            $data[$key]['fechpro'] = $year.'-'.$month.'-'.$day;
            $data[$key]['amount'] = (int) substr($row, 76, 16) / 100;
            $data[$key]['amount_currency'] = $request['amount_currency_old'];

            $data[$key]['motivo_del_fallido'] = trim(substr($row, 95, 80)) != '' ? trim(substr($row, 95, 80)) : 'Cobro Conciliado';
            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
        }

        return $data;
    }
}
