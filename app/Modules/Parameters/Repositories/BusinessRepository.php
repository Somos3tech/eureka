<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Business;
use App\Traits\TaskTrait;
use Auth;

class BusinessRepository implements BusinessInterface
{
    use TaskTrait;

    protected $business;

    /**
     * Business Repository constructor.
     *
     * @param  Business  $business
     **/
    public function __construct(Business $business)
    {
        $this->model = $business;
    }

    /************************Registrar Empresa*******************************/
    public function create($request)
    {
        $result = $this->model->create([
            'rif' => $request['rif'],
            'name' => $request['name'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'user_created_id' => \Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /********************Buscar Información Empresa**************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /*************************Actualizar Empresa*****************************/
    public function update($request, $id)
    {
        $data = [
            'rif' => $request['rif'],
            'name' => $request['name'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'user_updated_id' => Auth::user()->id,
        ];
        $model = $this->model->findOrfail($id);
        $result = $model->update($data);
        if ($result) {
            return true;
        }

        return false;
    }

    /*************************Eliminar Empresa*******************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = \Auth::user()->id;
        if ($result = $model->update()) {
            if ($result = $model->delete()) {
                return true;
            }
        }

        return false;
    }

    /**************************Datatable Empresa*****************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'business', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /****************************Api Empresa*********************************/
    public function select()
    {
        return $this->model->select('id', 'name as description')->get();
    }
}
