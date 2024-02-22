<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class CienxCiento implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));

        $file = $request['file_response_bank'];

        foreach ($array as $key => $row) {
            $data[$key]['fechpro'] = $request['date_operation'];
            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['referencia'] = (int) substr($row, 58, 12);
            $data[$key]['contrato'] = '';
            $data[$key]['factura'] = '';
            $data[$key]['afiliado'] = substr($row, 12, 8);
            $data[$key]['nropos'] = substr($row, 20, 3);
            $data[$key]['invoice_id'] = (int) substr($row, 58, 12);
            $data[$key]['amount'] = (int) substr($row, 43, 15) / 100;
            $data[$key]['amount_currency'] = $request['amount_currency_old'];
            $data[$key]['status_bank'] = trim(substr($row, 70, 15));
            $data[$key]['motivo_del_fallido'] = trim(substr($row, 85, 40)) != '' ? trim(substr($row, 85, 40)) : 'Cobro Conciliado';
            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
        }

        return $data;
    }
}
