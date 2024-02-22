<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

use App\Modules\Sales\Imports\FileImport;
use Maatwebsite\Excel\Facades\Excel;

class Activo implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        /*
        $data = [];
        $import = Excel::toArray(new FileImport, storage_path($request['file_response_bank']));
        $array = reset($import);
        foreach ($array as $key => $row) {
            if (array_key_exists('referencia', $row)) {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_de_cobro']);
                $data[$key]['bank_id'] = $request['bank_id'];
                $data[$key]['fechpro'] = $row['fecha_de_cobro'] != '' ? $date->format('Y-m-d') : '----';
                $data[$key]['afiliado'] = $row['afiliado'];
                $data[$key]['nropos'] = $row['numpos'];
                $data[$key]['invoice_id'] = $row['referencia'];
                $data[$key]['referencia'] = $row['referencia'];
                $data[$key]['amount'] = $row['monto'];
                $data[$key]['amount_currency'] = $request['amount_currency_old'];
                $data[$key]['descripcion_cliente'] = $row['descripcion_cliente'];
                $data[$key]['motivo_del_fallido'] = $row['motivo_del_fallido'];
                $data[$key]['status_bank'] = $row['estatus'];
            } else {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7]);

                $data[$key]['bank_id'] = $request['bank_id'];
                $data[$key]['fechpro'] = $row[7] != '' ? $date->format('Y-m-d') : '----';
                $data[$key]['afiliado'] = $row[1];
                $data[$key]['nropos'] = $row[2];
                $data[$key]['invoice_id'] = $row[0];
                $data[$key]['referencia'] = $row[0];
                $data[$key]['amount'] = str_replace(',', '.', $row[3]);
                $data[$key]['amount_currency'] = $request['amount_currency_old'];
                $data[$key]['descripcion_cliente'] = $row[4];
                $data[$key]['motivo_del_fallido'] = $row[6];
                $data[$key]['status_bank'] = $row[5];
            }
        }*/

        $data = [];

        $array = explode("\n", file_get_contents(storage_path($request['file_response_bank']), true));
        $count = 0;

        foreach ($array as $key => $row) {
            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['invoice_id'] = (int) substr($row, 0, 54);
            $data[$key]['referencia'] = (int) substr($row, 0, 54);
            $data[$key]['afiliado'] = '';
            $data[$key]['nropos'] = '';

            $data[$key]['amount'] = (float) str_replace(',', '.', substr($row, 66, 17));

            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
            $data[$key]['status_bank'] = trim(substr($row, 113, 20));
            $data[$key]['motivo_del_fallido'] = trim(substr($row, 133, 55));

            $day = substr($row, 159, 2);
            $month = substr($row, 162, 2);
            $year = substr($row, 165, 4);
            $data[$key]['fechpro'] = $year . '-' . $month . '-' . $day;
            $data[$key]['amount_currency'] = $request['amount_currency_old'];
        }

        return $data;
    }
}
