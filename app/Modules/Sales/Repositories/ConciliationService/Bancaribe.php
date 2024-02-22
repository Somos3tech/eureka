<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

use App\Modules\Sales\Imports\FileImport;
use Maatwebsite\Excel\Facades\Excel;

class Bancaribe implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        $data = [];

        $import = Excel::toArray(new FileImport, storage_path($request['file_response_bank']));
        $array = reset($import);
        foreach ($array as $key => $row) {
            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['fechpro'] = $request['date_operation'];
            $data[$key]['referencia'] = (int) $row['referencia'];
            $data[$key]['afiliado'] = '';
            $data[$key]['nropos'] = '';
            $data[$key]['invoice_id'] = (int) $row['referencia'];
            $amount = $row['monto'] != '' ? str_replace(',', '.', str_replace('Bs ', '', $row['monto'])) : 0;
            $data[$key]['amount'] = round($amount != 0 ? $amount : 0.00, 2);
            $data[$key]['amount_currency'] = $request['amount_currency_old'];
            $data[$key]['motivo_del_fallido'] = $row['informacion_del_movimiento'];
            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
            $data[$key]['status_bank'] = $row['estado'];
        }

        return $data;
    }
}
