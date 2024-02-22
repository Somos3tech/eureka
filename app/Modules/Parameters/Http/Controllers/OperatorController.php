<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\OperatorRequest;
use App\Modules\Parameters\Repositories\OperatorInterface;

class OperatorController extends Controller
{
    protected $operator;

    /**
     * OperatorRepository constructor.
     *
     * @param  Operator  $operator
     **/
    public function __construct(OperatorInterface $operator)
    {
        $this->model = $operator;
    }

    /*********************Listado Registro Operador(es)************************/
    public function index()
    {
        return view('parameters::operators.index', ['identity' => 'Registro Operador']);
    }

    /**********************Guardar Registro Operador***************************/
    public function store(OperatorRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Operador']);
    }

    /***********************Buscar Registro Operador***************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**********************Actualizar Registro Operador************************/
    public function update(OperatorRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /**************************Eliminar Operador(es)***************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /*********************Datatable Consulta Operador(es)**********************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /***************************Select Operador********************************/
    public function select()
    {
        return $this->model->select();
    }
}
