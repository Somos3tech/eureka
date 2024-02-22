<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Operator;
use App\Traits\TaskTrait;
use Auth;

class OperatorRepository implements OperatorInterface
{
    use TaskTrait;

    protected $operator;

    /**
     * OperatorRepository constructor.
     *
     * @param  Operator  $Operator
     */
    public function __construct(Operator $operator)
    {
        $this->model = $operator;
    }

    /***************************Registrar Operador***************************/
    public function create($request)
    {
        $result = $this->model->create([
            'description' => $request['description'],
            'observations' => $request['observations'],
            'is_simcard' => $this->isSimcard($request),
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /*************************Buscar Información Operador********************/
    public function find($id)
    {
        return \Response::json($this->model->where('id', '=', $id)->first());
    }

    /****************************Actualizar Operador*************************/
    public function update($request, $id)
    {
        $data = [
            'description' => $request['description'],
            'observations' => $request['observations'],
            'is_simcard' => $this->isSimcard($request),
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /****************************Eliminar Operador***************************/
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

    /**************************Datatable Operador****************************/
    public function datatable()
    {
        $data = $this->model->select('operators.id', 'operators.description', \DB::raw(" (CASE WHEN (operators.is_simcard IS NULL) THEN 'No' WHEN (operators.is_simcard = 0) THEN 'No' ELSE 'Si' END) as simcard"))->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'operators', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************Select Operador*******************************/
    public function select()
    {
        return $this->model->select('id', 'description')->get();
    }

    /**************************************************************************/
    protected function isSimcard($request)
    {
        if ($request->get('is_simcard') != null) {
            return 1;
        }

        return 0;
    }
}
