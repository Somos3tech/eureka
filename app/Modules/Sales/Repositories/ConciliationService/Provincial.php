<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Provincial implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));

        foreach ($array as $key => $row) {
            if (substr($row, 30, 3) == '001') {
                $data[$key]['bank_id'] = $request['bank_id'];
                $data[$key]['status_bank'] = substr($row, 76, 2);
                $data[$key]['afiliado'] = '';
                $data[$key]['nropos'] = '';
                $data[$key]['fechpro'] = $request['date_operation'];
                $data[$key]['amount'] = (int) substr($row, 53, 15) / 100;
                $data[$key]['amount_currency'] = $request['amount_currency_old'];
                $data[$key]['invoice_id'] = (int) trim(substr($row, 14, 16));
                $data[$key]['motivo_del_fallido'] = trim(substr($row, 78, 31)) != '' ? trim(substr($row, 78, 31)) : 'Cobro Conciliado';
                $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
            }
        }

        return $data;
    }
}
