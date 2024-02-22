<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
//Repository TypeCompany dentro de Módulo
use App\Modules\Parameters\Http\Requests\TypeCompanyRequest;
use App\Modules\Parameters\Repositories\TypeCompanyInterface;

class TypeCompanyController extends Controller
{
    private $type_company;

    /**
     * TypeCompanyInterface constructor.
     *
     * @param  TypeCompanyInterface  $type_company
     **/
    public function __construct(TypeCompanyInterface $type_company)
    {
        $this->model = $type_company;
    }

    /******************Listado Registro Categoría Almacén**********************/
    public function index()
    {
        return view('parameters::typecompanies.index', ['identity' => 'Registro Categoría Almacén']);
    }

    /******************Guardar Registro Categoría Almacén**********************/
    public function store(TypeCompanyRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Categoría Almacén']);
    }

    /******************Buscar Registro Categoría Almacén***********************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /****************Actualizar Registro Categoría Almacén*********************/
    public function update(TypeCompanyRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /**********************Eliminar Categoría Almacén**************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /***************Datatable Consulta Categoría Almacén***********************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*******************Api Select Categoría Almacén***************************/
    public function select()
    {
        return $this->model->select();
    }
}
