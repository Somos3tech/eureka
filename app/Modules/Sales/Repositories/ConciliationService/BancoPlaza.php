<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class BancoPlaza implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];
        $fechpro = '';

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));
        foreach ($array as $key => $row) {
            if ($key > 0) {
                $data[$key - 1]['bank_id'] = $request['bank_id'];
                $data[$key - 1]['afiliado'] = substr($row, 12, 8);
                $data[$key - 1]['nropos'] = substr($row, 20, 4);
                $data[$key - 1]['referencia'] = substr($row, 123, 13);
                $data[$key - 1]['fechpro'] = $fechpro;
                $data[$key - 1]['contrato'] = '';
                $data[$key - 1]['factura'] = '';
                $data[$key - 1]['status_bank'] = substr($row, 71, 2);
                $data[$key - 1]['invoice_id'] = substr($row, 123, 13);
                $data[$key - 1]['motivo_del_fallido'] = trim(substr($row, 73, 50));
                $data[$key - 1]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
                $data[$key - 1]['amount'] = (int) substr($row, 48, 15) / 100;
                $data[$key - 1]['amount_currency'] = $request['amount_currency_old'];
            } else {
                $fechpro = substr($row, 12, 4).'-'.substr($row, 16, 2).'-'.substr($row, 18, 2);
            }
        }

        return $data;
    }
}
