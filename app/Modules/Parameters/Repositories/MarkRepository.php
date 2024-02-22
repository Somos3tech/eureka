<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Mark;
use App\Traits\TaskTrait;
use Auth;

class MarkRepository implements MarkInterface
{
    use TaskTrait;

    protected $mark;

    /**
     * MarkRepository constructor.
     *
     * @param  Mark  $Mark
     */
    public function __construct(Mark $mark)
    {
        $this->model = $mark;
    }

    /******************************Registrar Marca****************************/
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

    /**************************Buscar Información Marca***********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /******************************Actualizar Marca***************************/
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

    /******************************Eliminar Marca*****************************/
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

    /******************************Datatable Marca*****************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'marks', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /*******************************Select Marca********************************/
    public function select()
    {
        return $this->model->select('id', 'description')->get();
    }
}
