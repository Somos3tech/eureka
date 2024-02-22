<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

class Bfc implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));

        $file = $request['file_response_bank'];
        $filename = explode('/', $file);
        $filename = explode('.', $filename[4]);
        $filename = substr($filename[0], 9, 8);
        $fechpro = substr($filename, 4, 4).'-'.substr($filename, 2, 2).'-'.substr($filename, 0, 2);

        foreach ($array as $key => $row) {
            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['referencia'] = (int) substr($row, 40, 20);
            $data[$key]['afiliado'] = '';
            $data[$key]['nropos'] = '';
            $data[$key]['invoice_id'] = (int) substr($row, 40, 20);
            // $data[$key]['contrato'] = (int)substr($row, 15, 30);
            // $data[$key]['factura'] = (int)substr($row, 45, 20);
            // $day = substr($row, 65, 2);
            // $month = substr($row, 67, 2);
            // $year = substr($row, 69, 4);
            $data[$key]['status_bank'] = substr($row, 105, 6);
            $data[$key]['fechpro'] = $fechpro;
            $data[$key]['amount'] = (int) substr($row, 60, 15) / 100;
            $data[$key]['amount_currency'] = $request['amount_currency_old'];
            $data[$key]['motivo_del_fallido'] = trim(substr($row, 75, 30)) != '' ? trim(substr($row, 75, 30)) : 'Cobro Conciliado';
            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
        }

        return $data;
    }
}
