<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Mercantil implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));

        foreach ($array as $key => $row) {
            if ($key > 0) {
                $data[$key - 1]['bank_id'] = $request['bank_id'];
                $data[$key - 1]['status_bank'] = substr($row, 158, 2);
                $data[$key - 1]['afiliado'] = '';
                $data[$key - 1]['nropos'] = '';
                $data[$key - 1]['fechpro'] = $request['date_operation'];
                $data[$key - 1]['amount'] = (int) substr($row, 68, 17) / 100;
                $data[$key - 1]['amount_currency'] = $request['amount_currency_old'];
                //$data[$key - 1]['invoice_id'] = (int) substr($row, 140, 7);
                $data[$key - 1]['invoice_id'] = (int) substr($row, 139, 8);
                $data[$key - 1]['motivo_del_fallido'] = trim(substr($row, 160, 30)) != '' ? trim(substr($row, 160, 30)) : 'Cobro Conciliado';
                $data[$key - 1]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
            }
        }

        return $data;
    }
}
