<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Tipification;
use App\Traits\TaskTrait;
use Auth;
use DataTable;

class TipificationRepository implements TipificationInterface
{
    use TaskTrait;

    protected $tipification;

    /**
     * TipificationRepository constructor.
     *
     * @param  Tipification  $tipification
     */
    public function __construct(Tipification $tipification)
    {
        $this->model = $tipification;
    }

    /**********************Registrar Tipificación****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /******************Buscar Información Tipificación***********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /**********************Actualizar Tipificación***************************/
    public function update($request, $id)
    {
        $data = [
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

    /**********************Eliminar Tipificación*****************************/
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

    /**********************Datatable Tipificación*****************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'tipifications', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /*******************************Select Tipificación********************************/
    public function select()
    {
        return $this->model->select('id', 'description')->get();
    }
}
