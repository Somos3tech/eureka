<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Cactivity;
use App\Traits\TaskTrait;
use Auth;

class CactivityRepository implements CactivityInterface
{
    use TaskTrait;

    protected $cactivity;

    /**
     * CactivityRepository constructor.
     *
     * @param  Cactivity  $cactivity
     */
    public function __construct(Cactivity $cactivity)
    {
        $this->model = $cactivity;
    }

    /******************************Registrar****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'code_cactivity' => $request['code_cactivity'],
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /**************************Buscar Información***********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /******************************Actualizar***************************/
    public function update($request, $id)
    {
        $data = [
            'code_cactivity' => $request['code_cactivity'],
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

    /******************************Eliminar*****************************/
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

    /******************************Datatable*****************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'cactivities', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /*******************************Select********************************/
    public function select()
    {
        return $this->model->select('id', 'description')->orderBy('description', 'ASC')->get();
    }
}
