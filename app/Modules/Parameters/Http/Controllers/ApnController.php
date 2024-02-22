<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\ApnRequest;
use App\Modules\Parameters\Repositories\ApnInterface;
use Illuminate\Http\Request;

class ApnController extends Controller
{
    private $apn;

    /**
     * ApnRepository constructor.
     *
     * @param  Apn  $apn
     **/
    public function __construct(ApnInterface $apn)
    {
        $this->model = $apn;
    }

    /*************************Listado Registro APN*****************************/
    public function index()
    {
        return view('parameters::apn.index', ['identity' => 'Registro APN']);
    }

    /************************Guardar Registro APN******************************/
    public function store(ApnRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar APN']);
    }

    /**************************Buscar Registro APN*****************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /***********************Actualiar Registro APN*****************************/
    public function update(ApnRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /****************************Eliminar APN**********************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /************************** Datatable APN *********************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*************************Api Select Modelo Terminal***********************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }
}
