<?php

namespace App\Modules\Sales\Repositories\ConciliationService;

use App\Modules\Sales\Imports\FileImport;
use Maatwebsite\Excel\Facades\Excel;

class Bdv implements ConciliationServiceInterface
{
    /**************************************************************************/
    public function insert($request)
    {
        /*
        $data = [];

        $array = explode("\n", file_get_contents(storage_path($request['file_response_bank']), true));
        $count = 0;

        foreach ($array as $key => $row) {
            if (substr($row, 0, 2) == '02') {
                $data[$key]['bank_id'] = $request['bank_id'];
                //Falta identificar el nro de factura en la respuesta del banco
                $data[$key]['referencia'] = (int) substr($row, 181, 20);
                $data[$key]['afiliado'] = '';
                $data[$key]['nropos'] = '';
                $data[$key]['invoice_id'] = (int) substr($row, 181, 20);
                $day = substr($row, 158, 2);
                $month = substr($row, 161, 2);
                $year = substr($row, 164, 4);
                $data[$key]['fechpro'] = $year.'-'.$month.'-'.$day;
                $data[$key]['status_bank'] = substr($row, 253, 3);
                $data[$key]['amount'] = (int) substr($row, 168, 13) / 100;
                $data[$key]['amount_currency'] = $request['amount_currency_old'];
                $data[$key]['motivo_del_fallido'] = substr($row, 253, 3) != '010' ? trim(substr($array[$count + 1], 31, 250)) : trim(substr($row, 256, 120));
                $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
            }
            $count++;
        }

        return $data;
*/

        $data = [];

        $import = Excel::toArray(new FileImport, storage_path($request['file_response_bank']));

        $array = reset($import);

        foreach ($array as $key => $row) {
            //$date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fechavalor']);
            //$fecha_for =  $row['fechavalor'];

            $fecha = $row['fechavalor'];
            $variable = str_replace("/", "-", $fecha);
            $final =  date('Y-m-d', strtotime($variable));;

            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['referencia'] = intval($row['referenciadebito']);
            $data[$key]['afiliado'] = '';
            $data[$key]['nropos'] = '';
            $data[$key]['invoice_id'] = intval($row['referenciadebito']);
            $data[$key]['fechpro'] = $final;
            $data[$key]['status_bank'] = str_replace("RG", "", $row['status']);
            $data[$key]['amount'] = str_replace(",", ".", $row['montocobrado']);
            $data[$key]['amount_currency'] = $request['amount_currency_old'];
            $data[$key]['motivo_del_fallido'] = str_replace("RG", "", $row['status']) != '010' ? trim($row['msensajesdetail']) : trim($row['statusdetail']);
            $data[$key]['descripcion_cliente'] = 'Proceso Bancario Domiciliación';
        }

        return $data;
    }
}
