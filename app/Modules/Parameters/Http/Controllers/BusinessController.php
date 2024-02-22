<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\BusinessRequest;
use App\Modules\Parameters\Repositories\BusinessInterface;

class BusinessController extends Controller
{
    private $business;

    /**
     * BusinessRepository constructor.
     *
     * @param  Business  $business
     **/
    public function __construct(BusinessInterface $business)
    {
        $this->model = $business;
    }

    /***********************Listado Registro Empresa****************************/
    public function index()
    {
        return view('parameters::business.index', ['identity' => 'Registrar Empresa']);
    }

    /***********************Guardar Registro Empresa***************************/
    public function store(BusinessRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Empresa']);
    }

    /***********************Buscar Registro Empresa****************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**********************Actualizar Registro Empresa***************************/
    public function update(BusinessRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /***************************Eliminar Empresa*******************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**********************Datatable Consulta Empresa**************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*************************Api Select Empresa*******************************/
    public function select()
    {
        return $this->model->select();
    }
}
