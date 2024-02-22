<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Typecompany;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class TypeCompanyRepository implements TypeCompanyInterface
{
    use TaskTrait;

    protected $type_company;

    /**
     * TypeCompanyRepository constructor.
     *
     * @param  Typecompany  $type_company
     */
    public function __construct(Typecompany $type_company)
    {
        $this->model = $type_company;
    }

    /**********************Registrar Tipo Almacén****************************/
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

    /******************Buscar Información Tipo Almacén***********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /**********************Actualizar Tipo Almacén***************************/
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

    /**********************Eliminar Tipo Almacén*****************************/
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

    /**********************Datatable Tipo Almacén*****************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'typecompanies', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /*********************Select Tipo Almacén********************************/
    public function select()
    {
        return $this->model->select('id', 'description')->get();
    }
}
