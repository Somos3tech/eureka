<?php

namespace App\Modules\Sales\Repositories\Operation;

use App\Modules\Sales\Exports\OperationReportExport;
use App\Modules\Sales\Models\Operation;
use App\Modules\Sales\Repositories\CollectionRepository;
use App\Modules\Sales\Repositories\ContractRepository;
use App\Modules\Sales\Repositories\InvoiceRepository;
use App\Modules\Warehouses\Imports\FileImport;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class OperationRepository implements OperationInterface
{
    protected $operation;

    protected $invoice;

    protected $contract;

    protected $collection;

    public function __construct(Operation $operation, ContractRepository $contract, InvoiceRepository $invoice, CollectionRepository $collection)
    {
        $this->model = $operation;
        $this->contract = $contract;
        $this->invoice = $invoice;
        $this->collection = $collection;
    }

    /****************************************************************************/
    public function create($request)
    {
        $data = [];
        $invoice_id = '';

        switch ($request['type_operation']) {
            case 'debito':
                $request['pmethod_id'] = $request['type_operation'];
                $request['payment_path'] = null;
                $request['user_id'] = Auth::user()->id;
                $invoice = $this->invoice->create($request);
                $invoice_id = $invoice->id;
                break;
            case 'credito':
                for ($i = 0; $i < count($request['invoice_id']); $i++) {
                    $invoice = $this->invoice->model->where('invoices.id', $request['invoice_id'][$i])->whereIn('invoices.status', ['G', 'P', 'R'])->first();

                    if (isset($invoice)) {
                        if ($request['amount'][$i] == $invoice->amount) {
                            $invoice->status = 'C';
                            $invoice->save();
                        } elseif ($request['register_amount'][$i] > 0 && $request['register_amount'][$i] < $invoice->amount) {
                            $invoice->status = 'P';
                            $invoice->save();
                        }
                        $this->collection->model->create([
                            'invoice_id' => (int) $request['invoice_id'][$i],
                            'invoiceitem_id' => null,
                            'tipnot' => 'EFE',
                            'description' => 'Conciliación Gestión Cobro',
                            'status' => '00',
                            'user_created_id' => Auth::user()->id,
                            'acconcept_id' => 5,
                            'currency_id' => 2,
                            'fechpro' => date('Y-m-d'),
                            'refere' => $request['register_refere'][$i] != null || $request['register_refere'][$i] != '' ? $request['register_refere'][$i] : 'Gestión Cobranza',
                            'dicom' => $request['register_currencyvalue'][$i],
                            'amount_currency' => $request['register_amount'][$i],
                            'amount' => $request['amount'][$i],
                        ]);
                    }
                }
                break;
            case 'exoneracion':
                for ($i = 0; $i < count($request['invoice_id']); $i++) {
                    $invoice = $this->invoice->model->where('invoices.id', (int) $request['invoice_id'][$i])->whereIn('invoices.status', ['G', 'P', 'R'])->first();
                    if (isset($invoice)) {
                        $invoice->status = 'E';
                        $result = $invoice->save();
                    }
                }
                break;
            case 'reverso':
                for ($i = 0; $i < count($request['invoice_id']); $i++) {
                    $collections = $this->collection->model->select('collections.*')
                        ->join('invoices', function ($join) {
                            $join->on('invoices.id', '=', 'collections.invoice_id');
                            $join->whereNull('invoices.deleted_at');
                        })
                        ->where('collections.invoice_id', (int) $request['invoice_id'][$i])->whereIn('invoices.status', ['E', 'C'])->get();
                    if ($collections->count() > 0) {
                        foreach ($collections as $row) {
                            $collection = $this->collection->model->where('collections.id', (int) $row->id)->first();
                            if (isset($collection)) {
                                $collection->user_deleted_id = Auth::user()->id;
                                if ($collection->update()) {
                                    $result = $collection->delete();
                                }
                            }
                        }
                    }
                    $invoice = $this->invoice->model->where('invoices.id', (int) $request['invoice_id'][$i])->whereIn('invoices.status', ['C', 'E'])->first();
                    if (isset($invoice)) {
                        $invoice->status = 'P';
                        $invoice->save();
                    }
                }
                break;
            case 'anulacion':
                for ($i = 0; $i < count($request['invoice_id']); $i++) {
                    $invoice = $this->invoice->model->where('invoices.id', (int) $request['invoice_id'][$i])->whereIn('invoices.status', ['G', 'P', 'R'])->first();
                    if (isset($invoice)) {
                        $invoice->status = 'X';
                        $result = $invoice->update();
                    }
                }
                break;
            default:
                return false;
                break;
        }

        if ($request['type_operation'] == 'reverso' || $request['type_operation'] == 'credito' || $request['type_operation'] == 'exoneracion' || $request['type_operation'] == 'anulacion') {
            for ($i = 0; $i < count($request['invoice_id']); $i++) {
                $data[$i] = [
                    'customer_id' => $request['customer_id'] != null ? $request['customer_id'] : '',
                    'contract_id' => $request['contract_id'] != null ? $request['contract_id'] : '',
                    'invoice_id' => $request['invoice_id'][$i] != null ? $request['invoice_id'][$i] : '',
                    'amount' => $request['register_amount'][$i] != null ? $request['register_amount'][$i] : '',
                    'refere' => $request['register_refere'][$i] != null ? $request['register_refere'][$i] : 'Gestión Servicios',
                ];
            }
        } else {
            $data = [
                'customer_id' => $request['customer_id'] != null ? $request['customer_id'] : '',
                'contract_id' => $request['contract_id'] != null ? $request['contract_id'] : '',
                'invoice_id' => $invoice_id != null ? (int) $invoice_id : '',
                'fechpro' => $request['date_value'] != null ? $request['date_value'] : '',
                'tipnot' => $request['tipnot'] != null ? $request['tipnot'] : '',
                'amount' => $request['amount'] != null ? $request['amount'] : '',
                'refere' => $request['refere'] != null ? $request['refere'] : '',
            ];
        }

        $this->model->create([
            'type_service' => 'basico',
            'type_operation' => $request['type_operation'],
            'data' => serialize($data),
            'observations' => $request['observation'],
            'user_created_id' => Auth::user()->id,
        ]);

        return true;
    }

    /**************************************************************************/
    public function download()
    {
        return response()->download(storage_path('/Carga Masiva Entrada.xlsx'));
    }

    /**************************************************************************/
    public function masive($request)
    {
        //ini_set('max_execution_time', '60000');
        //ini_set('memory_limit', '8192M');
        $data = [];
        $cont = 0;
        $control = 0;
        //No. Cobro, Tipo Operación, Fecha ,Tipo Pago, Monto, Referencia, Observaciones
        $file = (new FileImport)->toArray(request()->file('file'));
        $masive = reset($file);
        foreach ($masive as $row) {
            if ($control > 0) {
                if (count($row) >= 11) {
                    if ($array = $this->typeOperation($row)) {
                        if (is_array($array)) {
                            $row[1] = $array[1];
                            $row[0] = 'Cobro';
                            $row[11] = $array[0];
                        } else {
                            $row[11] = $array;
                        }
                        $data[$cont] = array_merge($row);
                    } else {
                        $data[$cont] = array_merge($row, ['11' => 'Error al Procesar Válide los datos e inténtelo nuevamente']);
                    }
                    $cont++;
                }
            } else {
                $control = 1;
            }
        }

        return $data;
    }

    /**************************************************************************/
    private function typeOperation($row)
    {
        $data = '';

        switch (strtolower($row[2])) {
            case 'debito':
                $model = $this->contract->model->select('contracts.id', 'customers.id as customer_id', 'customers.rif', 'customers.business_name', 'dcustomers.bank_id', 'dcustomers.account_number as nrocta', 'contracts.nropos')
                    ->join('customers', 'customers.id', '=', 'contracts.customer_id')
                    ->join('dcustomers', 'dcustomers.id', '=', 'contracts.dcustomer_id');

                $contract = $model->where('contracts.id', (int) $row[1])->first();
                if (is_numeric($row[3])) {
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);
                    $fecha = $date->format('Y-m-d');
                } else {
                    $fecha = $row[3];
                }

                if (isset($contract)) {
                    $invoice = $this->invoice->model->where('invoices.fechpro', 'LIKE', $fecha.' %')->where('invoices.concept_id', '=', 2)->where('invoices.contract_id', (int) $row[1])->whereNotIn('invoices.status', ['X'])->first();
                    if (! isset($invoice)) {
                        $request = [
                            'fechpro' => $fecha,
                            'date_value' => $fecha,
                            'refere' => $row[9].' | '.$fecha,
                            'tipnot' => $row[4] != 'Transferencia' ? 'Transferencia' : $row[4],
                            'customer_id' => $contract->customer_id,
                            'contract_id' => $contract->id,
                            'rif' => $contract->rif,
                            'tipcta' => 'C',
                            'bank_id' => $contract->bank_id,
                            'nrocta' => str_replace('-', '', $contract->nrocta),
                            'nropos' => $contract->nropos,
                            'free' => 0.00,
                            'business_name' => $contract->business_name,
                            'pmethod_id' => $row[2],
                            'amount' => $row[6],
                            'payment_path' => null,
                            'user_id' => Auth::user()->id,
                        ];
                        $result = $this->invoice->create($request);
                        if ($result) {
                            $data = [];
                            $data[0] = 'Cobro Generado Correctamente';
                            $data[1] = (int) $result->id;
                        } else {
                            $data = 'Error al Generar Cobro x Servicios';
                        }
                    } else {
                        $data = 'Cobro ya existe en el Sistema';
                    }
                }

                break;

            case 'negociacion':

                $invoice = $this->invoice->model->where('invoices.id', (int) $row[1])->whereIn('invoices.status', ['G', 'P', 'R'])->first();

                if (isset($invoice)) {
                    $invoice->status = 'N';
                    $result = $invoice->save();

                    if ($result) {
                        $data = 'Negociación Procesada Correctamente';
                    } else {
                        $data = 'Error al Procesar Negociación';
                    }
                } else {
                    $data = 'Error al Procesar Cobro por Negociación | Cobro No encontrado';
                }
                /**
                 * ! Deshabilitada la creación masiva de Negociaciones
                 *//*
                $model = $this->contract->model->select('contracts.id', 'customers.id as customer_id', 'customers.rif', 'customers.business_name', 'dcustomers.bank_id', 'dcustomers.account_number as nrocta', 'contracts.nropos')
                    ->join('customers', 'customers.id', '=', 'contracts.customer_id')
                    ->join('dcustomers', 'dcustomers.id', '=', 'contracts.dcustomer_id');

                $contract = $model->where('contracts.id', (int)$row[1])->first();
                if (is_numeric($row[3])) {
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);
                    $fecha = $date->format('Y-m-d');
                } else {
                    $fecha = $row[3];
                }

                if (isset($contract)) {
                    $invoice = $this->invoice->model->where('invoices.fechpro', 'LIKE', $fecha . ' %')->where('invoices.concept_id', '=', 2)->where('invoices.contract_id', (int)$row[1])->first();
                    if (!isset($invoice)) {

                        $request = [
                            'fechpro' => $fecha,
                            'date_value' => $fecha,
                            'refere' => $row[9],
                            'tipnot' => $row[4],
                            'customer_id' => $contract->customer_id,
                            'contract_id' => $contract->id,
                            'rif' => $contract->rif,
                            'tipcta' => 'C',
                            'bank_id' => $contract->bank_id,
                            'nrocta' => str_replace("-", "", $contract->nrocta),
                            'nropos' => $contract->nropos,
                            'free' => 0.00,
                            'business_name' => $contract->business_name,
                            'pmethod_id' => $row[2],
                            'amount' => $row[6],
                            'payment_path' => null,
                            'user_id' => Auth::user()->id
                        ];
                        $result = $this->invoice->create($request);
                        if ($result) {
                            $data = [];
                            $data[0] = 'Cobro Pendiente Negociación Generado Correctamente';
                            $data[1] = (int)$result->id;
                        } else {
                            $data = 'Error al Generar Cobro x Servicios';
                        }
                    } else {
                        $data = 'Cobro ya existe en el Sistema';
                    }
                }*/
                break;

            case 'credito':
                $invoice = $this->invoice->model->where('invoices.id', $row[1])->whereIn('invoices.status', ['G', 'P', 'R'])->first();
                if (isset($invoice)) {
                    if ($row[6] == $invoice->amount) {
                        $invoice->status = 'C';
                        $result = $invoice->save();
                    } elseif ($row[6] > 0 && $row[6] < $invoice->amount) {
                        $invoice->status = 'P';
                        $result = $invoice->save();
                    }

                    if (isset($result)) {
                        $fecha = strtotime(str_replace('.', '-', $row[3]));
                        $result = $this->collection->model->create([
                            'invoice_id' => (int) $row[1],
                            'invoiceitem_id' => null,
                            'tipnot' => 'EFE',
                            'description' => 'Conciliación Gestión Cobro',
                            'status' => '00',
                            'user_created_id' => Auth::user()->id,
                            'acconcept_id' => $row[5], //Pendiente Parametrizar
                            'currency_id' => 2,
                            'fechpro' => date('Y-m-d', $fecha),
                            'refere' => $row[9] != null || $row[9] != '' ? $row[9] : 'Gestión Cobranza',
                            'dicom' => $row[7],
                            'amount_currency' => (str_replace(',', '', $row[6]) * str_replace(',', '', $row[7])),
                            'amount' => $row[6],
                        ]);
                        if ($result) {
                            $data = 'Pago Aplicado Correctamente';
                        } else {
                            $data = 'Error al Aplicar Pago al Cobro x Servicio';
                        }
                    } else {
                        $data = 'Error al Aplicar Pago al Cobro x Servicio | Cambio Status No Procesado';
                    }
                } else {
                    $data = 'Error al Aplicar Pago al Cobro x Servicio | Cobro No encontrado';
                }
                break;

            case 'activacion':
                $invoice = $this->invoice->model->where('invoices.id', (int) $row[1])->whereIn('invoices.status', ['N', 'E'])->first();
                if (isset($invoice)) {
                    $invoice->status = 'G';
                    $invoice->tipnot = $row[4];
                    $invoice->refere = $row[9] != '' ? $row[9] : 'Cobro Aceptado por Usuario';
                    $result = $invoice->save();

                    if ($result) {
                        $data = 'Cobro Activado Correctamente';
                    } else {
                        $data = 'Error al Activar Cobro';
                    }
                } else {
                    $data = 'Error al Activar Cobro | Cobro No encontrado';
                }
                break;

            case 'exoneracion':
                $invoice = $this->invoice->model->where('invoices.id', (int) $row[1])->whereIn('invoices.status', ['G', 'P', 'R'])->first();

                if (isset($invoice)) {
                    $invoice->status = 'E';
                    $result = $invoice->save();

                    if ($result) {
                        $data = 'Cobro Exonerado Correctamente';
                    } else {
                        $data = 'Error al Exonerar Cobro';
                    }
                } else {
                    $data = 'Error al Exonerar Cobro | Cobro No encontrado';
                }
                break;

            case 'anulacion':
                $invoice = $this->invoice->model->where('invoices.id', (int) $row[1])->whereIn('invoices.status', ['G', 'P', 'R'])->first();

                if (isset($invoice)) {
                    $invoice->status = 'X';
                    $result = $invoice->update();

                    if ($result) {
                        $data = 'Cobro Anular Correctamente';
                    } else {
                        $data = 'Error al Anular Cobro';
                    }
                } else {
                    $data = 'Error al Anular Cobro | Cobro No encontrado';
                }
                break;

            case 'reverso':
                $collections = $this->collection->model->select('collections.*')->where('collections.invoice_id', (int) $row[1])->get();
                if (isset($collections)) {
                    foreach ($collections as $collect) {
                        $collection = $this->collection->model->where('collections.id', (int) $collect->id)->first();
                        if (isset($collection)) {
                            $collection->user_deleted_id = Auth::user()->id;
                            if ($collection->update()) {
                                $result = $collection->delete();
                            }
                        }
                    }
                }

                $invoice = $this->invoice->model->where('invoices.id', (int) $row[1])->whereIn('invoices.status', ['E', 'C'])->first();

                if (isset($invoice)) {
                    $invoice->status = 'P';
                    $invoice->user_updated_id = Auth::user()->id;
                    $result = $invoice->update();
                    if ($result) {
                        $data = 'Reverso Pago Aplicado Correctamente';
                    } else {
                        $data = 'Error al realizar Reverso Pago';
                    }
                } else {
                    $data = 'Error al realizar Reverso Pago | Cobro No encontrado';
                }
                break;

            default:
                $data = 'Error al procesar Operación';
                break;
        }
        if (is_numeric($row[3])) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);
            $fecha = $date->format('Y-m-d');
        } else {
            $fecha = $row[3];
        }

        if (is_array($data)) {
            $observations_response = $data[0];
            $invoice_id = $data[1];
        } else {
            $observations_response = $data;
            $invoice_id = null;
        }

        if (strtolower($row[2]) == 'reverso' || strtolower($row[2]) == 'credito' || strtolower($row[2]) == 'exoneracion' || strtolower($row[2]) == 'activacion' || strtolower($row[2]) == 'anulacion') {
            $model = $this->invoice->model;

            if (strtolower($row[2]) != 'debito' && strtolower($row[2]) != 'negociacion') {
                $invoice = $model->where('invoices.id', (int) $row[1])->first();
            } else {
                $invoice = $model->where('invoices.id', (int) $data[1])->first();
            }

            $arr = [
                'customer_id' => isset($invoice) != null ? (int) $invoice->customer_id : '',
                'contract_id' => isset($invoice) != null ? (int) $invoice->contract_id : '',
                'invoice_id' => isset($invoice) != null ? (int) $invoice->id : '',
                'fechpro' => $fecha != null ? $fecha : '',
                'tipnot' => $row[4] != null ? $row[4] : '',
                'amount' => $row[6] != null ? $row[6] : '',
                'refere' => $row[9] != null || $row[9] != '' ? $row[9] : '',
                'observations_response' => $observations_response,
            ];
        } else {
            $contract = $this->contract->model->select('contracts.id', 'customers.id as customer_id', 'customers.rif', 'customers.business_name', 'dcustomers.bank_id', 'dcustomers.account_number as nrocta', 'contracts.nropos')
                ->join('customers', 'customers.id', '=', 'contracts.customer_id')
                ->join('dcustomers', 'dcustomers.id', '=', 'contracts.dcustomer_id')
                ->where('contracts.id', (int) $row[1])->first();

            $arr = [
                'customer_id' => isset($contract) != null ? (int) $contract->customer_id : '',
                'contract_id' => (int) $row[1],
                'invoice_id' => $invoice_id != null ? (int) $invoice_id : '',
                'fechpro' => $fecha != null ? $fecha : '',
                'tipnot' => $row[4] != null ? $row[4] : '',
                'amount' => $row[6] != null ? $row[6] : '',
                'refere' => $row[9] != null || $row[9] != '' ? $row[9] : '',
                'observations_response' => $observations_response,
            ];
        }

        $this->model->create([
            'type_service' => 'masivo',
            'type_operation' => $row[2],
            'data' => serialize($arr),
            'observations' => $row[10],
            'user_created_id' => Auth::user()->id,
        ]);

        return $data;
    }

    /****************************************************************************/
    public function find($id)
    {
        //
    }

    /****************************************************************************/
    public function update($request, $id)
    {
        //
    }

    /************************Eliminar Información Pagos**************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        if ($result = $model->update()) {
            if ($result = $model->delete()) {
                return $model;
            }
        }

        return false;
    }

    /****************************************************************************/
    public function report($request)
    {
        ini_set('memory_limit', '4098M');

        return Excel::download(new OperationReportExport($request), 'Reporte Gestión Operaciones Diaria - Cobranza Servicios  '.date('Y-m-d').'.xlsx');
    }
}
