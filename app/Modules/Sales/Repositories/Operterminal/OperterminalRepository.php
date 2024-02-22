<?php

namespace App\Modules\Sales\Repositories\Operterminal;

use App\Modules\Sales\Exports\OperterminalReportExport;
use App\Modules\Sales\Models\Operterminal;
use App\Modules\Sales\Repositories\ContractRepository;
use Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class OperterminalRepository implements OperterminalInterface
{
    protected $operterminal;

    protected $contract;

    public function __construct(Operterminal $operterminal, ContractRepository $contract)
    {
        $this->model = $operterminal;
        $this->contract = $contract;
    }

    /****************************************************************************/
    public function create($request)
    {
        $contract = $this->contract->model->select('contracts.*', 't.serial', 'terms.abrev as term_name')
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->where('contracts.id', $request['contract_id'])->first();

        if (isset($contract)) {
            if ($request['type_operation'] == 'activacion') {
                $status = 'Finalizado';
                $contract->status = 'Activo';
            } elseif ($request['type_operation'] == 'cambio') {
                $status = 'Finalizado';
                $contract->term_id = $request['term_id'];
            } elseif ($request['type_operation'] == 'suspension') {
                // Desactive verificación de fecha ya que no observo que afecte positivamente el flujo de procesos
                // $now = Carbon::now();
                // if ($now->gt($request['date_inactive']))
                if ($request['type_service'] == 'temporal') {
                    $status = 'Pendiente';
                    $contract->status = 'Suspendido';
                } elseif ($request['type_service'] == 'definitivo') {
                    $contract->status = 'Cancelado';
                    $status = 'Finalizado';
                } else {
                    return false;
                }
                /**
                 * TODO Crear un Evento que se ejecute Según Fecha Suspensión
                 * TODO Crear un Evento que se ejecute Según Fecha Reactivación
                 */
            } else {
                return false;
            }

            $contract->user_updated_id = Auth::user()->id;
            $result = $contract->update();

            if ($result) {
                $result = $this->model->create([
                    'contract_id' => $request['contract_id'],
                    'fechpro' => date('y-m-d'),
                    'type_operation' => $request['type_operation'],
                    'type_service' => $request->has('type_service') ? $request['type_service'] : null,
                    'term_id' => $request->has('term_id') ? $request['term_id'] : null,
                    'date_inactive' => $request->has('date_inactive') ? $request['date_inactive'] : null,
                    'date_reactive' => $request->has('date_reactive') ? $request['date_reactive'] : null,
                    'term_name' => $contract->term_name,
                    'serial_terminal' => $contract->serial,
                    'observations' => $request['observations'],
                    'status' => $status,
                    'user_created_id' => Auth::user()->id,
                ]);
                if ($result) {
                    return true;
                }
            }
        }

        return false;
    }

    /****************************************************************************/
    public function find($id)
    {
        $data = $this->model->select(
            \DB::raw("(CASE WHEN (operterminals.type_operation='activacion') THEN 'Activación Servicio' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='definitivo') THEN 'Cancelación Servicio' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='temporal') THEN 'Suspensión Servicio' WHEN (operterminals.type_operation='cambio') THEN 'Cambio Plan Servicio' ELSE '----' END) as type_operation_name"),
            'operterminals.type_operation',
            \DB::raw("(CASE WHEN (operterminals.type_operation='activacion') THEN '----' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='definitivo') THEN 'Definitivo' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='temporal') THEN 'Temporal' WHEN (operterminals.type_operation='cambio') THEN NULL ELSE '----' END) as type_service"),
            'terms.abrev as term',
            'terms.description as term_description',
            \DB::raw("LPAD(operterminals.id,6,'0') AS operterminal_id"),
            'operterminals.fechpro',
            'cs.rif',
            'cs.business_name',
            \DB::raw("LPAD(operterminals.contract_id ,6,'0') as contract_id"),
            'operterminals.observations',
            'operterminals.status',
            \DB::raw("DATE_FORMAT(operterminals.fechpro,'%Y-%m-%d') as created"),
            \DB::raw("(CASE WHEN (CONCAT(us.name,' ', us.last_name) IS NULL) THEN '----'  ELSE CONCAT(us.name,' ', us.last_name) END) as created_name"),
            \DB::raw("(CASE WHEN (operterminals.date_inactive IS NULL) THEN '----'  ELSE operterminals.date_inactive END) as date_inactive"),
            \DB::raw("(CASE WHEN (operterminals.date_reactive IS NULL) THEN '----'  ELSE operterminals.date_reactive END) as date_reactive"),
            \DB::raw("(CASE WHEN (operterminals.updated_at IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.updated_at,'%Y-%m-%d')  END) as updated"),
            \DB::raw("(CASE WHEN (CONCAT(users.name,' ', users.last_name) IS NULL) THEN '----'  ELSE CONCAT(users.name,' ', users.last_name) END) as updated_name")
        )
            ->join('contracts', 'contracts.id', '=', 'operterminals.contract_id')
            ->join('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->leftjoin('users as us', 'us.id', '=', 'operterminals.user_created_id')
            ->leftjoin('users', 'users.id', '=', 'operterminals.user_updated_id')
            ->where('operterminals.id', $id)
            ->first();

        return \Response::json($data);
    }

    /****************************************************************************/
    public function update($request, $id)
    {
        //
    }

    /****************************************************************************/
    public function datatable($request)
    {
        $model = $this->model->query();
        $model->select(
            \DB::raw("(CASE WHEN (operterminals.type_operation='activacion') THEN 'Activación Servicio' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='definitivo') THEN 'Cancelación Servicio' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='temporal') THEN 'Suspensión Temporal Servicio' WHEN (operterminals.type_operation='cambio') THEN 'Cambio Plan Servicio' ELSE '----' END) as type_operation"),
            \DB::raw("LPAD(operterminals.id,6,'0') AS operterminal_id"),
            'operterminals.fechpro',
            'cs.rif',
            'cs.business_name',
            \DB::raw("LPAD(operterminals.contract_id ,6,'0') as contract_id"),
            'operterminals.status',
            'operterminals.status as status_operterminal',
            \DB::raw("(CASE WHEN (CONCAT(us.name,' ', us.last_name) IS NULL) THEN '----'  ELSE CONCAT(us.name,' ', us.last_name) END) as name"),
            'operterminals.type_service',
            \DB::raw("(CASE WHEN (operterminals.updated_at IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.updated_at,'%Y-%m-%d')  END) as updated"),
            \DB::raw("(CASE WHEN (CONCAT(users.name,' ', users.last_name) IS NULL) THEN '----'  ELSE CONCAT(users.name,' ', users.last_name) END) as updated_name"),
            \DB::raw("(CASE WHEN (operterminals.date_inactive IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.date_inactive,'%Y-%m-%d')  END) as date_inactive"),
            \DB::raw("(CASE WHEN (operterminals.date_reactive IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.date_reactive,'%Y-%m-%d')  END) as date_reactive"),
            'terminals.serial as terminal_serial'
        )
            ->join('contracts', 'contracts.id', '=', 'operterminals.contract_id')
            ->join('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('terminals', 'terminals.id', '=', 'contracts.terminal_id')
            ->leftjoin('users as us', 'us.id', '=', 'operterminals.user_created_id')
            ->leftjoin('users', 'users.id', '=', 'operterminals.user_updated_id');

        if ($request->has('status')) {
            $model->where('operterminals.status', 'LIKE', $request['status']);
        }

        $data = $model->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                if (auth()->user()->can('operterminals.edit', 'operterminals.destroy')) {
                    $actions = '<center><button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                               </button><div class="dropdown-menu" x-placement="bottom-start">';
                    $actions .= '<button class="dropdown-item"  data-toggle="modal" value="'.(int) $data->operterminal_id.'"  OnClick="OperTerminalId(this);" data-target="#operterminalsView" title="Ver Información">Ver Información</button>';
                } else {
                    $actions = '<div><center>---</center>';
                }

                if (($data->status_operterminal == 'Pendiente') || ($data->status_operterminal == 'Finalizado' && $data->type_service == 'definitivo')) {
                    if (auth()->user()->can('operterminals.edit')) {
                        $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="'.(int) $data->operterminal_id.'"  OnClick="OperTerminalReactive(this);" data-target="#operterminalsReactiveView" title="Reactivar Servicio">Reactivar</button>';
                    }
                    if (auth()->user()->can('operterminals.destroy') && $data->status_operterminal == 'Pendiente') {
                        $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="'.(int) $data->operterminal_id.'"  OnClick="OperTerminalDelete(this);" data-target="#operterminalsDelete" title="Anular">Anular</button>';
                    }
                }
                $actions .= '</center></div>';

                return $actions;
            })->rawColumns(['status', 'actions'])
            ->toJson();
    }

    /************************Eliminar Información Pagos**************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->status = 'Anulado';
        $model->user_deleted_id = Auth::user()->id;

        if ($result = $model->update()) {
            return $model;
        }

        return false;
    }

    /****************************************************************************/
    public function reactive($id)
    {
        $message = '';
        $model = $this->model->where('operterminals.id', $id)->first();
        if (isset($model)) {
            $contract = $this->contract->model->select('contracts.*')->where('contracts.id', (int) $model->contract_id)->whereIn('contracts.status', ['Suspendido', 'Cancelado'])->first();

            if (isset($contract)) {
                $contract->status = 'Activo';
                $result = $contract->update();

                if (isset($result)) {
                    $message .= 'Servicio se Activo Correctamente';
                } else {
                    $message .= 'Error Al Activar Servicio';
                }
                $model->status = 'Finalizado';
                $result = $model->update();

                if (isset($result)) {
                    $message .= ', Se Finaliza Gestión Correctamente';
                } else {
                    $message .= ', Error al Finalizar Gestión';
                }
            } else {
                return 'Servicio ya se encuentra Activo, Inexistente o Anulado';
            }

            return $message;
        }

        return false;
    }

    /****************************************************************************/
    public function report($request)
    {
        ini_set('memory_limit', '4096M');

        return Excel::download(new OperterminalReportExport($request), 'Reporte Gestión Terminales '.date('Y-m-d').'.xlsx');
    }
}
