<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\ConceptRequest;
use App\Modules\Parameters\Http\Requests\ConceptUpdateRequest;
use App\Modules\Parameters\Repositories\ConceptInterface;

class ConceptController extends Controller
{
    private $concept;

    /**
     * ConceptRepository constructor.
     *
     * @param  Concept  $concept
     **/
    public function __construct(ConceptInterface $concept)
    {
        $this->model = $concept;
    }

    /*******************Listado Registro Concepto Servicio*********************/
    public function index()
    {
        return view('parameters::concepts.index', ['identity' => 'Registro Tipificación Venta']);
    }

    /*******************Guardar Registro Concepto Servicio*********************/
    public function store(ConceptRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Tipificación Venta']);
    }

    /*******************Buscar Registro Concepto Servicio**********************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /***************Actualizar Registro Concepto Servicio**********************/
    public function update(ConceptUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /********************Eliminar Concepto Servicio****************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /******************Api Consulta Concepto Servicio**************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**********************Api Select Concepto Servicio************************/
    public function select()
    {
        return $this->model->select();
    }
}
