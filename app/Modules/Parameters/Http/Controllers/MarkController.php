<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\MarkRequest;
use App\Modules\Parameters\Repositories\MarkInterface;

class MarkController extends Controller
{
    private $mark;

    /**
     * MarkRepository constructor.
     *
     * @param  Mark  $mark
     **/
    public function __construct(MarkInterface $mark)
    {
        $this->model = $mark;
    }

    /***********************Listado Registro Marca*****************************/
    public function index()
    {
        return view('parameters::marks.index', ['identity' => 'Registro Marca']);
    }

    /***********************Guardar Registro Marca*****************************/
    public function store(MarkRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Marca']);
    }

    /***********************Buscar Registro Marca******************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**********************Actualizar Registro Marca***************************/
    public function update(MarkRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /***************************Eliminar Marca*********************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**********************Datatable Consulta Marca****************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*************************Api Select Marca*********************************/
    public function select()
    {
        return $this->model->select();
    }
}
