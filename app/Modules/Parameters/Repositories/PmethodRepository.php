<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Pmethod;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class PmethodRepository implements PmethodInterface
{
    use TaskTrait;

    protected $pmethod;

    public function __construct(Pmethod $pmethod)
    {
        $this->model = $pmethod;
    }

    /***********************Registrar Método Pago****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'slug' => $request['slug'],
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /**********************Buscar Información Método Pago********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /***********************Actualizar Método Pago***************************/
    public function update($request, $id)
    {
        $data = [
            'slug' => $request['slug'],
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

    /************************Eliminar Método Pago****************************/
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

    /************************Datatable Método Pago****************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'pmethods', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************Select Método Pago******************************/
    public function select()
    {
        return $this->model->select('id', 'slug', 'description')->get();
    }
}
