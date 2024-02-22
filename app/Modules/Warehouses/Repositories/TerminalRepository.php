<?php

namespace App\Modules\Warehouses\Repositories;

use App\Modules\Warehouses\Exports\ReportTerminalExport;
use App\Modules\Warehouses\Imports\FileImport;
use App\Modules\Warehouses\Models\Terminal;
use Auth;
use Datatable;
use Maatwebsite\Excel\Facades\Excel;

class TerminalRepository implements TerminalInterface
{
    protected $terminal;

    /**
     * TerminalRepository constructor.
     *
     * @param  Terminal  $terminal
     */
    public function __construct(Terminal $terminal)
    {
        $this->model = $terminal;
    }

    /******************************Registrar Terminal*******************************/
    public function create($request)
    {
        $arr = [];
        if ($this->hasFile($request)) {
            $array_terminal = (new FileImport)->toArray(request()->file('file_terminal'));
            $array = reset($array_terminal);

            foreach ($array as $key => $value) {
                if (count($value) == 1) {
                    $query = $this->model->where('terminals.serial', 'LIKE', $value[0])->first();

                    if (!isset($query)) {
                        $arr = [
                            'fechpro' => $request['fechpro'], 'company_id' => $request['company_id'], 'modelterminal_id' => $request['mterm_id'], 'serial' => $value[0],
                            'status' => $request['statusc'], 'user_created_id' => Auth::user()->id, 'created_at' => date('Y-m-d H:i:s'),
                        ];

                        $data[] = ['serial' => $value[0], 'observacion' => 'Registrado Correctamente'];
                    } else {
                        $data[] = ['serial' => $value[0], 'observacion' => 'Terminal ya registrado en el Sistema'];
                    }
                } else {
                    $data[] = ['serial' => $value[0], 'observacion' => 'Error(es) en algun(os) campo(s)'];
                }
                $this->model->insert($arr);
            }

            return $data;
        }

        return false;
    }

    /***************Asignar Terminales x Zona y Cambiar Status***************/
    public function assign($request, $action)
    {
        if ($action == 'A') {
            if ($this->hasFile($request)) {
                $array_terminal = (new FileImport)->toArray(request()->file('file_terminal'));
                $array = reset($array_terminal);
                $status = $request['statusc'];
            } else {
                return false;
            }
        } elseif ($action == 'D') {
            $array_terminal = unserialize($request['data_terminal']);
            $array = reset($array_terminal);
            $status = 'Disponible';
        }

        foreach ($array as $key => $value) {
            if (count($value) == 1) {
                $serial = trim($value[0]);
                $model = $this->model->query();
                $model->select('terminals.id', 'mt.description as modelterminal', 'terminals.serial')
                    ->join('modelterminal as mt', 'mt.id', '=', 'terminals.modelterminal_id')
                    ->where('terminals.serial', $serial)
                    ->whereNotIn('terminals.status', ['Desactivado', 'Asignado']);

                if (\Request::exists('valid_fechpro')) {
                    $model->whereNotExists(function ($q) {
                        $q->select(\DB::raw(1))->from('assignments')
                            ->whereRaw('assignments.terminal_id = terminals.id')
                            ->whereNull('assignments.deleted_at');
                    });

                    $model->whereNotExists(function ($q) {
                        $q->select(\DB::raw(1))->from('contracts')
                            ->whereRaw('contracts.terminal_id = terminals.id')
                            ->whereIn('contracts.status', ['Activo', 'Pendiente'])
                            ->whereNull('contracts.deleted_at');
                    });
                }

                $query = $model->first();

                if ($query) {
                    if ($request['type_action'] == 'assign') {
                        if ($request->has('valid_status')) {
                            $arr = [
                                'status' => $request['statusc'], 'user_updated_id' => Auth::user()->id, 'updated_at' => date('Y-m-d H:i:s'),
                            ];
                        } else {
                            $arr = [
                                'user_updated_id' => Auth::user()->id, 'updated_at' => date('Y-m-d H:i:s'),
                            ];
                        }
                    } else {
                        $arr = [
                            'status' => $status, 'user_updated_id' => Auth::user()->id, 'updated_at' => date('Y-m-d H:i:s'),
                        ];
                    }

                    if ($action != 'D') {
                        if ($request->has('valid_zone')) {
                            $array1 = [
                                'company_id' => $request['company_id'],
                            ];
                            $arr = array_merge($arr, $array1);
                        }

                        if ($request->has('valid')) {
                            $array2 = [
                                'modelterminal_id' => $request['mterm_id'],
                            ];
                            $arr = array_merge($arr, $array2);
                        }

                        if ($request->has('valid_fechpro')) {
                            $array3 = [
                                'fechpro' => $request['fechpro'],
                            ];
                            $arr = array_merge($arr, $array3);
                        }
                    } else {
                        $array1 = [
                            'company_id' => $request['company_id'],
                        ];
                        $arr = array_merge($arr, $array1);
                    }

                    $result = $query->update($arr);
                    if ($result) {
                        $result = $query->toArray();
                        $data[] = ['status' => '0', 'serial' => $result['serial'], 'device' => $result['modelterminal'], 'observacion' => 'Asignado Correctamente'];
                    } else {
                        $data[] = ['status' => '-1', 'serial' => $value[0], 'device' => '----', 'observacion' => 'Error en la Asignación'];
                    }
                } else {
                    $data[] = ['status' => '-1', 'serial' => $value[0], 'device' => '----', 'observacion' => 'Ya Asignado/No Registrado'];
                }
            } else {
                $data[] = ['status' => '-1', 'serial' => $value[0], 'device' => '----', 'observacion' => 'Error(es) en algun(os) campo(s)'];
            }
        }

        return $data;
    }

    /********************Buscar Información Cliente**************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /********************Buscar Información Cliente**************************/
    public function findSerial($serial)
    {
        return $this->model->where('serial', 'LIKE', $serial)->first();
    }

    /******************Actualizar Información Cliente************************/
    public function update($request, $id)
    {
        $data = [
            'user_updated_id' => Auth::user()->id,
            'user_assignated_id' => Auth::user()->id,
            'status' => 'Asignado',
            'assignated_at' => date('Y-m-d H:i:s'),
        ];

        if ($model = $this->model->findOrfail($id)) {
            $result = $model->update($data);
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /************************************************************************/
    public function reassign($request, $id)
    {
        $model = $this->model->findOrfail($id);
        if (isset($model)) {
            $data = [
                'company_id' => (int) $request['company_assign_id'],
                'user_updated_id' => Auth::user()->id,
            ];

            $result = $model->update($data);
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /*******************Actualizar Información Simcard***********************/
    public function posted($request, $id)
    {
        $data = [
            'user_updated_id' => Auth::user()->id,
            'user_posted_id' => Auth::user()->id,
            'status' => 'Entregado',
            'posted_at' => date('Y-m-d H:i:s', strtotime($request['date'])),
        ];
        $model = $this->model->where('terminals.id', $id)->first();
        if (isset($model)) {
            $result = $model->update($data);
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /*******************Eliminar Información Cliente*************************/
    public function delete($id)
    {
        $model = $this->model->where('id', '=', $id)->where('status', '=', 'Disponible')->first();
        if (isset($model)) {
            $model->user_deleted_id = Auth::user()->id;
            $result = $model->update();

            if ($result) {
                $result = $model->delete();
                if ($result) {
                    return $data = true;
                }
            }
        }

        return false;
    }

    /**********************Restaurar Información Cliente**********************/
    public function restore($id)
    {
        $model = $this->model->where('id', '=', $id)->whereIn('status', ['Desactivado', 'Inactivo', 'Asignado'])->first();
        if (isset($model)) {
            $model->user_assignated_id = null;
            $model->assignated_at = null;
            $model->status = 'Disponible';
            $model->user_updated_id = Auth::user()->id;
            $result = $model->update();

            if ($result) {
                return true;
            }
        }

        return false;
    }

    /************************Restaurar Contrato******************************/
    public function restoreContract($id)
    {
        $model = $this->model->where('id', '=', $id)->first();
        if (isset($model)) {
            $model->user_assignated_id = null;
            $model->assignated_at = null;
            $model->status = 'Disponible';
            $model->user_posted_id = null;
            $model->posted_at = null;
            $model->user_updated_id = Auth::user()->id;
            $result = $model->update();

            if ($result) {
                return true;
            }
        }

        return false;
    }

    /****************Api Datatable - Consulta General Customer*****************/
    public function datatable($request)
    {
        $query = $this->model->query();
        $query->select(
            'terminals.id',
            'marks.description as marca',
            'modelterminal.description as modelo',
            'terminals.serial',
            \DB::raw("(CASE WHEN (cp.description IS NULL) THEN '----' ELSE cp.description END) as company"),
            \DB::raw("(CASE WHEN (cs.business_name IS NULL) THEN '-----' ELSE cs.business_name END) as business_name"),
            \DB::raw("(CASE WHEN (terminals.assignated_at IS NULL) THEN '----' ELSE DATE_FORMAT(terminals.assignated_at, '%d/%m/%Y') END) as assignated"),
            \DB::raw(" (CASE WHEN (assign.status = 'A' || assign.status = 'F') THEN 'En Almacén' WHEN (assign.status = 'D') THEN 'En Despacho' WHEN (assign.status = 'C') THEN 'Entregado Cliente' WHEN (assign.status IS NULL) THEN '----' ELSE CONCAT(usr.name,' ', usr.last_name) END) as user"),
            'terminals.status',
            \DB::raw("(CASE WHEN (terminals.fechpro IS NULL) THEN '-----' ELSE terminals.fechpro END) as fechpro")
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.terminal_id', '=', 'terminals.id');
                $join->whereIn('ct.status', ['Activo', 'Pendiente', 'Cancelado', 'Suspendido']);
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'ct.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('assignments as assign', function ($join) {
                $join->on('assign.terminal_id', '=', 'terminals.id');
                $join->whereNull('assign.deleted_at');
            })
            ->leftjoin('companies as cp', 'cp.id', '=', 'terminals.company_id')
            ->leftjoin('modelterminal', 'modelterminal.id', '=', 'terminals.ModelTerminal_id')
            ->leftjoin('marks', 'marks.id', '=', 'modelterminal.mark_id')
            ->leftjoin('users as usr', 'usr.id', '=', 'assign.user_assign_id');
        if (!is_null(Auth::user()->company_id)) {
            $query->where('terminals.company_id', '=', Auth::user()->company_id);
        }

        $data = $query->where('terminals.status', 'LIKE', $request['status'])->whereNull('assign.deleted_at')->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $action = '<center>';
                if ($data->status == 'Disponible') {
                    if (auth()->user()->can('terminals.destroy')) {
                        $action .= '<button class="btn btn-sm btn-danger waves-effect waves-light" href="#" data-toggle="modal" OnClick="terminalsDelete(this);" data-target="#terminalsDelete" value="' . (int) $data->id . '" title="Eliminar"><i class="i-Close"></i></button>';
                    } else {
                        $action .= '----';
                    }
                }
                if ($data->status == 'Desactivado' || $data->status == 'Inactivo') {
                    if (auth()->user()->can('terminals.edit')) {
                        $action .= '&nbsp;<button class="btn btn-sm btn-info" href="#" data-toggle="modal" OnClick="TerminalRestore(this);" data-target="#restoreTerminal" value="' . $data->id . '" title="Restaurar Disponibilidad"><i class="i-yes"></i></button>';
                    } else {
                        $action .= '----';
                    }
                }

                if ($data->status != 'Disponible' && $data->status != 'Desactivado') {
                    $action .= '----';
                }

                $action .= '</center>';

                return $action;
            })->rawColumns(['actions'])->toJson();
    }

    /******************************Verificar Existencia ***********************/
    public function hasFile($request)
    {
        if (!is_object($request)) {
            return false;
        }
        if (!$request->hasFile('file_terminal')) {
            return false;
        }

        return true;
    }

    /***********************Terminales Disponibles x Zona *********************/
    public function available($request)
    {
        $model = $this->model->query();
        $company = $request['company_id'];
        $mterminal = $request['mterminal_id'];

        $model->select(\DB::raw("CONCAT(terminals.serial,' | ', mt.description) as description"), 'terminals.id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'terminals.modelterminal_id')
            ->where('terminals.company_id', '=', $company)
            ->where('terminals.modelterminal_id', '=', $mterminal)
            ->where('terminals.status', '=', 'Disponible')
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))->from('assignments')
                    ->whereRaw('assignments.terminal_id = terminals.id')
                    ->where('assignments.status', '!=', 'X')
                    ->whereNull('assignments.deleted_at');
            });

        $destino = explode(',', $request['destino']);
        if ($destino != '') {
            $model->whereNotIn('terminals.id', $destino);
        }
        $data = $model->whereNull('terminals.deleted_at')->orderBy('terminals.serial', 'ASC')->get();

        return \Response::json($data);
    }

    /**************************Reporte de Terminales***************************/
    public function report($request)
    {
        return Excel::download(new ReportTerminalExport($request), 'Reporte Inventario Equipo ' . date('Y-m-d') . '.xlsx');
    }

    /**************************************************************************/
    public function totalAvailable($request)
    {
        $cont = 0;
        if ($request->has('modelterminal_id')) {
            $model = $this->model->query();
            $model->leftjoin('companies as cp', 'cp.id', '=', 'terminals.company_id')
                ->leftjoin('modelterminal as mt', 'mt.id', '=', 'terminals.modelterminal_id')
                ->whereIn('terminals.status', ['Disponible']);
            $model->where('terminals.modelterminal_id', $request['modelterminal_id'])
                ->where('terminals.company_id', $request['company_id']);

            $data = $model->get();

            if (count($data) > 0) {
                $cont = count($data);
            }
        }

        return \Response::json($cont);
    }

    /**************************************************************************/
    public function totalStore()
    {
        $available = $this->totalAvailable();
        $data = $available->toArray();

        return $data;
    }

    public function totalTerminals()
    {
        $total_order = $this->model->select(\DB::raw("(CASE WHEN (terminals.status = 'Disponible') THEN 'D' ELSE 'PI' END) as terminal_status"), \DB::raw('count(*) as total'))
            ->whereIn('terminals.status', ['Disponible'])
            ->whereNull('terminals.deleted_at')
            ->get();

        $data = $total_order->toArray();

        return $data;
    }
}
