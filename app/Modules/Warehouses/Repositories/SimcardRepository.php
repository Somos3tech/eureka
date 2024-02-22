<?php

namespace App\Modules\Warehouses\Repositories;

use App\Modules\Warehouses\Exports\ReportSimcardExport;
use App\Modules\Warehouses\Imports\FileImport;
use App\Modules\Warehouses\Models\Simcard;
use Auth;
use Datatable;
use Maatwebsite\Excel\Facades\Excel;

class SimcardRepository implements SimcardInterface
{
    protected $simcard;

    /**
     * SimcardRepository constructor.
     *
     * @param  Simcard  $simcard
     */
    public function __construct(Simcard $simcard)
    {
        $this->model = $simcard;
    }

    /******************************Registrar Simcard*******************************/
    public function create($request)
    {
        $arr = [];
        if ($this->hasFile($request)) {
            $array_simcard = (new FileImport)->toArray(request()->file('file_simcard'));
            $array = reset($array_simcard);
            foreach ($array as $key => $value) {
                if (count($value) == 2) {
                    $query = $this->model->where('serial_sim', 'LIKE', $value[0])->first();
                    if (!isset($query)) {
                        $arr = [
                            'company_id' => $request['company_id'], 'operator_id' => $request['operator_id'], 'apn_id' => $request['apn_id'], 'number_mobile' => $value[1], 'serial_sim' => $value[0],
                            'status' => $request['statusc'], 'created_at' => date('Y-m-d H:i:s'), 'user_created_id' => Auth::user()->id,
                        ];

                        $data[] = ['serial' => $value[0], 'observacion' => 'Registrado Correctamente'];
                    } else {
                        $data[] = ['serial' => $value[0], 'observacion' => 'Registro ya Existe en el Sistema'];
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

    /*****************Asignar Simcard x Zona y Cambiar Status****************/
    public function assign($request, $action)
    {
        if ($action == 'A') {
            if ($this->hasFile($request)) {
                $array_simcard = (new FileImport)->toArray(request()->file('file_simcard'));
                $array = reset($array_simcard);
                $status = $request['statusc'];
            } else {
                return false;
            }
        } elseif ($action == 'D') {
            $array_simcard = unserialize($request['data_simcard']);
            $array = reset($array_simcard);
            $status = 'Disponible';
        }

        foreach ($array as $key => $value) {
            if (isset($value[0])) {
                $serial = trim($value[0]);
                $query = $this->model->select('simcards.id', 'op.description as operator', 'simcards.serial_sim')
                    ->join('operators as op', 'op.id', '=', 'simcards.operator_id')
                    ->where('simcards.serial_sim', 'LIKE', $serial)
                    ->whereNotExists(function ($q) {
                        $q->select(\DB::raw(1))->from('assignments')
                            ->whereRaw('assignments.simcard_id = simcards.id')
                            ->whereNull('assignments.deleted_at');
                    })
                    ->whereNotIn('simcards.status', ['Entregado', 'Desactivado', 'Asignado'])
                    ->first();
                if ($query) {
                    $arr = [
                        'status' => $status, 'user_updated_id' => Auth::user()->id, 'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    if ($action != 'D') {
                        if ($request->has('valid_zone')) {
                            $array1 = [
                                'company_id' => $request['company_id'],
                            ];
                            $arr = array_merge($arr, $array1);
                        }

                        if ($request->has('valid')) {
                            $array2 = [
                                'operator_id' => $request['operator_id'], 'apn_id' => $request['apn_id'],
                            ];
                            $arr = array_merge($arr, $array2);
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
                        $data[] = ['status' => '0', 'serial' => $result['serial_sim'], 'device' => $result['operator'], 'observacion' => 'Asignado Correctamente'];
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

    /************************Buscar Información Simcard**********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /*******************Actualizar Información Simcard***********************/
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
        $model = $this->model->where('simcards.id', $id)->first();
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

    /*************************Restaurar Simcard******************************/
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

    /***************** Api Datatable - Simcard*********************************/
    public function datatable($request)
    {
        $model = $this->model->query();

        $model->select(
            'simcards.id',
            'operators.description as operator',
            \DB::RAW("(CASE WHEN (simcards.apn_id IS NULL) THEN '---' ELSE apn.description END) AS apn"),
            'simcards.serial_sim',
            \DB::raw("(CASE WHEN (cp.description IS NULL) THEN '----' ELSE cp.description END) as company"),
            \DB::raw("(CASE WHEN (cs.business_name IS NULL) THEN '-----' ELSE cs.business_name END) as business_name"),
            \DB::raw("(CASE WHEN (simcards.assignated_at IS NULL) THEN '----' ELSE DATE_FORMAT(simcards.assignated_at, '%d/%m/%Y') END) as assignated"),
            \DB::raw(" (CASE WHEN (assign.status = 'A' || assign.status = 'F') THEN 'En Almacén' WHEN (assign.status = 'D') THEN 'En Despacho' WHEN (assign.status = 'C') THEN 'Entregado Cliente' WHEN (assign.status IS NULL) THEN '----' ELSE CONCAT(usr.name,' ', usr.last_name) END) as user"),
            'simcards.status'
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.simcard_id', '=', 'simcards.id');
                $join->whereIn('ct.status', ['Activo', 'Pendiente', 'Cancelado', 'Suspendido']);
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'ct.dcustomer_id')
            ->leftjoin('assignments as assign', function ($join) {
                $join->on('assign.simcard_id', '=', 'simcards.id');
                $join->whereNull('assign.deleted_at');
            })
            ->leftjoin('apn', function ($join) {
                $join->on('apn.id', '=', 'simcards.apn_id');
                $join->whereNull('apn.deleted_at');
            })
            ->leftjoin('companies as cp', 'cp.id', '=', 'simcards.company_id')
            ->join('operators', 'operators.id', '=', 'simcards.operator_id')
            ->leftjoin('users as usr', 'usr.id', '=', 'assign.user_assign_id');

        if (!is_null(Auth::user()->company_id)) {
            $model->where('simcards.company_id', '=', Auth::user()->company_id);
        }
        $data = $model->where('simcards.status', 'LIKE', $request['status'])->whereNull('simcards.deleted_at')->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $action = '<center>';

                if ($data->status == 'Disponible') {
                    if (auth()->user()->can('simcards.destroy')) {
                        $action .= '<button class="btn btn-sm btn-danger waves-effect waves-light" href="#" data-toggle="modal" OnClick="simcardsDelete(this);" data-target="#simcardsDelete" value="' . (int) $data->id . '" title="Eliminar"><i class="i-Close"></i></button>';
                    } else {
                        $action .= '----';
                    }
                } elseif ($data->status == 'Desactivado' || $data->status == 'Inactivo') {
                    if (auth()->user()->can('simcards.desteditroy')) {
                        $action .= '&nbsp;<button class="btn btn-sm btn-info" href="#" data-toggle="modal" OnClick="SimcardRestore(this);" data-target="#restoreSimcard" value="' . $data->id . '" title="Restaurar Disponibilidad"><i class="i-yes"></i></button>';
                    } else {
                        $action .= '----';
                    }
                } elseif ($data->status == 'Asignado' || $data->status == 'Entregado') {
                    $action .= '----';
                }

                $action .= '</center>';

                return $action;
            })->rawColumns(['actions'])->toJson();
    }

    /*************************Verificar Existencia ****************************/
    public function hasFile($request)
    {
        if (!is_object($request)) {
            return false;
        }
        if (!$request->hasFile('file_simcard')) {
            return false;
        }

        return true;
    }

    /********************************Disponible********************************/
    public function available($request)
    {
        $model = $this->model->query();
        $company = $request['company_id'];
        $operator = $request['operator_id'];

        $model->select(\DB::raw("CONCAT(simcards.serial_sim,' | ', op.description) as description"), 'simcards.id')
            ->leftjoin('operators as op', 'op.id', '=', 'simcards.operator_id')
            ->where('simcards.company_id', '=', $company)
            ->where('simcards.operator_id', '=', $operator)
            ->where('simcards.status', 'LIKE', 'Disponible')
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))->from('assignments')
                    ->whereRaw('assignments.simcard_id = simcards.id')
                    ->where('assignments.status', '!=', 'X')
                    ->whereNull('assignments.deleted_at');
            });

        $destino = explode(',', $request['destino']);
        if ($destino != '') {
            $model->whereNotIn('simcards.id', $destino);
        }
        $data = $model->whereNull('simcards.deleted_at')->orderBy('simcards.serial_sim', 'ASC')->get();

        return \Response::json($data);
    }

    /******************************Reporte de Terminales*****************************/
    public function report($request)
    {
        return Excel::download(new ReportSimcardExport($request), 'Reporte Inventario Simcard ' . date('Y-m-d') . '.xlsx');
    }
}
