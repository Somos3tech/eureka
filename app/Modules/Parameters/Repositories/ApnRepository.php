<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Apn;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class ApnRepository implements ApnInterface
{
    use TaskTrait;

    protected $apn;

    /**
     * ApnRepository constructor.
     *
     * @param  Apn  $apn
     */
    public function __construct(Apn $apn)
    {
        $this->model = $apn;
    }

    /***************************Registrar APN********************************/
    public function create($request)
    {
        $result = $this->model->create([
            'operator_id' => $request['operator_id'],
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************Buscar Información APN**************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /*************************Actualizar APN********************************/
    public function update($request, $id)
    {
        $data = [
            'operator_id' => $request['operator_id'],
            'description' => $request['description'],
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /****************************Eliminar APN********************************/
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

    /******************************Datatable APN******************************/
    public function datatable()
    {
        $data = $this->model->select('apn.id as id', 'apn.description', 'operators.description as operator')
            ->leftjoin('operators', function ($join) {
                $join->on('operators.id', '=', 'apn.operator_id');
                $join->whereNull('operators.deleted_at');
            })->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'apn', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /*****************************Select APN***********************************/
    public function select($request)
    {
        $model = $this->model->query();
        $model->select('apn.id as id', \DB::raw("CONCAT(operators.description,' | ', apn.description) as description"))
            ->leftjoin('operators', function ($join) {
                $join->on('operators.id', '=', 'apn.operator_id');
                $join->whereNull('operators.deleted_at');
            });
        if ($request['operator_id'] != '') {
            $model->where('operator_id', '=', $request['operator_id']);
        }

        return $model->get();
    }
}
