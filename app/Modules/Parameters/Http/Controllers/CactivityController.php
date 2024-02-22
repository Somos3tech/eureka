<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\CactivityRequest;
use App\Modules\Parameters\Repositories\CactivityInterface;

class CactivityController extends Controller
{
    private $cactivity;

    /**
     * CactivityRepository constructor.
     *
     * @param  Cactivity  $cactivity
     **/
    public function __construct(CactivityInterface $cactivity)
    {
        $this->model = $cactivity;
    }

    /***********************Listado Registro*****************************/
    public function index()
    {
        return view('parameters::cactivities.index', ['identity' => 'Registro Actividad Comercial']);
    }

    /***********************Guardar Registro*****************************/
    public function store(CactivityRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Actividad Comercial']);
    }

    /***********************Buscar Registro******************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**********************Actualizar Registro***************************/
    public function update(CactivityRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /***************************Eliminar*********************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**********************Datatable Consulta****************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*************************Api Select*********************************/
    public function select()
    {
        return $this->model->select();
    }
}
