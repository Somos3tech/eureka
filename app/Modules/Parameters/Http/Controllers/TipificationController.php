<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\TipificationRequest;
use App\Modules\Parameters\Repositories\TipificationInterface;

class TipificationController extends Controller
{
    private $tipification;

    /**
     * TipificationRepository constructor.
     *
     * @param  Tipification  $tipification
     **/
    public function __construct(TipificationInterface $tipification)
    {
        $this->model = $tipification;
    }

    /*********************Listado Registro Tipification************************/
    public function index()
    {
        return view('parameters::tipifications.index', ['identity' => 'Registro Tipificación Soporte']);
    }

    /***********************Guardar Registro Tipificación**********************/
    public function store(TipificationRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Tipificación']);
    }

    /**********************Buscar Registro Tipification************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /********************Actualizar Registro Tipification**********************/
    public function update(TipificationRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /**************************Eliminar Tipificación***************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /*******************Datatable Consulta Tipification************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**********************Api Select Tipification*****************************/
    public function select()
    {
        return $this->model->select();
    }
}
