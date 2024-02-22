<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Concept;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class ConceptRepository implements ConceptInterface
{
    use TaskTrait;

    protected $concept;

    /**
     * ConceptRepository constructor.
     *
     * @param  Concept  $concept
     */
    public function __construct(Concept $concept)
    {
        $this->model = $concept;
    }

    /****************************Registrar Concepto****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'abrev' => $request['abrev'],
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /***********************Buscar Información Concepto************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /**************************Actualizar Concepto*****************************/
    public function update($request, $id)
    {
        $data = [
            'abrev' => $request['abrev'],
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

    /***************************Eliminar Concepto******************************/
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

    /***************************Datatable Concepto*****************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'concept', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************Api Select Concepto*****************************/
    public function select()
    {
        return $this->model->select('id', 'description')->get();
    }
}
