<?php

namespace App\Modules\Warehouses\Repositories\Assignment;

use App\Modules\Warehouses\Models\Assignment;
use Auth;

//use App\Modules\Warehouses\Repositories\Assignment\AssignmentServiceFactory;

class AssignmentRepository implements AssignmentInterface
{
    protected $assignment;

    /************************************************************************/
    public function __construct(Assignment $assignment)
    {
        $this->model = $assignment;
    }

    /************************************************************************/
    public function createId($data)
    {
        $result = $this->model->create($data);
        if ($result) {
            return true;
        }

        return false;
    }

    /**************************Registrar Asignación**************************/
    public function create($request)
    {
        if (($request['device'] == 'T') || ($request['device'] == 'S')) {
            $count = count($request['destino']);
            $sum = 0;

            if ($request['device'] == 'T') {
                $device = 'terminal_id';
            }
            if ($request['device'] == 'S') {
                $device = 'simcard_id';
            }

            for ($i = 0; $i < $count; $i++) {
                $result = $this->model->create([
                    $device => $request['destino'][$i],
                    'user_assign_id' => $request['user_assignated'],
                    'company_id' => $request['company_id'],
                    'observations' => $request['observations'],
                    'status' => 'P',
                    'user_created_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                if ($result) {
                    $sum++;
                }
            }

            if ($sum > 0) {
                return true;
            }
        }

        return false;
    }

    /**************************Registrar Asignación**************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /***********************Actualizar Asignación****************************/
    public function update($request, $id)
    {
        //
    }

    /************************************************************************/
    public function updateDevice($request, $device)
    {
        /*$factory = new AssignmentServiceFactory();
        $assignmentService = $factory->initialize($request->type_service);
        $data = $assignmentService->updateField($request);*/
        $data = ['status' => 'C', 'user_updated_id' => Auth::user()->id];
        if ($device == 'T') {
            $model = $this->model->where('terminal_id', '=', $request['terminal_id'])->first();
        }

        if ($device == 'S') {
            $model = $this->model->where('simcard_id', '=', $request['simcard_id'])->first();
        }

        if ($model) {
            if ($result = $model->update($data)) {
                return true;
            }
        }

        return false;
    }

    /***********************Actualizar Asignación****************************/
    public function reassign($request)
    {
        $count = count($request['destino']);
        $sum = 0;
        $result = '';
        if ($request['device'] == 'T') {
            $device = 'terminal_id';
        }

        if ($request['device'] == 'S') {
            $device = 'simcard_id';
        }

        if (isset($request['user_assign'])) {
            $data = ['user_assign_id' => $request['user_assign'], 'user_updated_id' => Auth::user()->id];
        } else {
            $data = [$device => null, 'user_assign_id' => null, 'status' => 'X', 'user_updated_id' => Auth::user()->id, 'user_deleted_id' => Auth::user()->id];
        }

        for ($i = 0; $i < $count; $i++) {
            $model = $this->model->where($device, '=', $request['destino'][$i])->whereNull('deleted_at')->first();

            if ($model) {
                if (! isset($request['user_assign'])) {
                    $result_destroy = $model->delete();

                    return true;
                } else {
                    if ($model->update($data)) {
                        $sum++;
                    }
                }
            }
        }
        if ($sum > 0) {
            return true;
        }

        return false;
    }

    /**************************Eliminar Asignación***************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /**************************Eliminar Asignación***************************/
    public function deleteAssignment($type, $id)
    {
        $model = $this->model->where($type, '=', $id)->first();
        if ($model) {
            $result = $model->delete();
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /*************************************************************************/
    public function select()
    {
    }

    /************************Select o Contador Response**********************/
    public function assigned($request)
    {
        $model = $this->model->query();

        if ($request['device'] == 'T') {
            if ($request['count'] != 'Y') {
                $model->select('terminals.id', \DB::raw('CONCAT(terminals.serial,"|",mt.description) as modelterminal'));
                $model->where('mt.id', '=', $request['mterminal_id']);

                if ($request['destino'] != '') {
                    $destino = explode(',', $request['destino']);
                    $model->whereNotIn('terminals.id', $destino);
                }
            } else {
                $model->select(\DB::raw('count(*) as count'), \DB::raw("(CASE WHEN (mt.description IS NULL) THEN 'Ningún Asignado' ELSE mt.description END) as modelterminal"))->groupBy('modelterminal');
            }

            $model->join('terminals', function ($join) {
                $join->on('terminals.id', '=', 'assignments.terminal_id');
                $join->where('terminals.status', '=', 'Disponible');
                $join->whereNull('terminals.deleted_at');
            })->join('modelterminal as mt', 'mt.id', '=', 'terminals.modelterminal_id');
        }

        if ($request['device'] == 'S') {
            if ($request['count'] != 'Y') {
                $model->select('s.id', \DB::raw('CONCAT(s.serial_sim,"|",op.description) as operator'));
                $model->where('op.id', '=', $request['operator_id']);

                if ($request['destino'] != '') {
                    $destino = explode(',', $request['destino']);
                    $model->whereNotIn('s.id', $destino);
                }
            } else {
                $model->select(\DB::raw('count(*) as count'), \DB::raw("(CASE WHEN (op.description IS NULL) THEN 'Ningún Asignado' ELSE op.description END) as operator"))->groupBy('operator');
            }

            $model->join('simcards as s', function ($join) {
                $join->on('s.id', '=', 'assignments.simcard_id');
                $join->where('s.status', '=', 'Disponible');
                $join->whereNull('s.deleted_at');
            })
                ->join('operators as op', 'op.id', '=', 's.operator_id');
        }

        return $model->where('assignments.user_assign_id', '=', $request['user_id'])
            ->where('assignments.status', '=', 'P')
            ->whereNull('assignments.deleted_at')
            ->get();
    }

    /***************Select Terminales Asignados a Programador****************/
    public function assignedProgrammer($request)
    {
        $model = $this->model->query();
        if ($request['device'] == 'T') {
            if ($request['opc'] != 'update') {
                $model->join('terminals', function ($join) {
                    $join->on('terminals.id', '=', 'assignments.terminal_id');
                    $join->where('terminals.status', 'Disponible');
                    $join->whereNull('terminals.deleted_at');
                });
            } else {
                $model->join('terminals', function ($join) {
                    $join->on('terminals.id', '=', 'assignments.terminal_id');
                    $join->where('terminals.status', 'Asignado');
                    $join->whereNull('terminals.deleted_at');
                });
            }

            $model->select('terminals.id', 'terminals.serial as description')
                ->where('terminals.modelterminal_id', '=', $request['mterminal_id'])
                ->where('terminals.company_id', '=', $request['company_id']);

            if (! Auth::user()->hasRole('superadmin')) {
                $model->where('assignments.user_assign_id', '=', Auth::user()->id);
            }

            return $model->where('assignments.status', '=', 'P')
                ->whereNull('assignments.deleted_at')
                ->get();
        }

        if ($request['device'] == 'S') {
            $model->join('simcards as s', function ($join) {
                $join->on('s.id', '=', 'assignments.simcard_id');
                $join->where('s.status', '=', 'Disponible');
                $join->whereNull('s.deleted_at');
            });
            $model->select('s.id', 's.serial_sim as description')
                ->where('s.operator_id', '=', $request['operator_id'])
                ->where('s.company_id', '=', $request['company_id']);

            if (! Auth::user()->hasRole('superadmin')) {
                $model->where('assignments.user_assign_id', '=', Auth::user()->id);
            }

            return $model->where('assignments.status', '=', 'P')
                ->whereNull('assignments.deleted_at')
                ->get();
        }
    }

    /**************************************************************************/
    public function assignmentUser($request)
    {
        $user_assignated = $request['user_assignated'];
        $destino = $request['destino'];
        $destino = explode(',', $destino);
        $model = $this->model->query();

        $data = $model->select(\DB::raw("CONCAT(cs.business_name,' | ',mt.description,' | ',t.serial,' | ',op.description,' | ',s.serial_sim) as serial"), 't.id')
            ->join('contracts as ct', 'ct.terminal_id', '=', 'assignments.terminal_id')
            ->join('orders as or', 'or.contract_id', '=', 'ct.id')
            ->join('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->join('terminals as t', 't.id', '=', 'ct.terminal_id')
            ->join('modelterminal as mt', 'mt.id', '=', 't.modelterminal_id')
            ->join('operators as op', 'op.id', '=', 'ct.operator_id')
            ->join('simcards as s', 's.id', '=', 'ct.simcard_id')
            ->where('or.status', '=', 'PF')
            ->where('assignments.status', '=', 'P')
            ->where('assignments.user_assign_id', '=', $user_assignated);

        if (isset($destino)) {
            $model->whereNotIn('t.id', $destino);
        }
        $data = $model->get();

        return \Response::json($data);
    }
}
