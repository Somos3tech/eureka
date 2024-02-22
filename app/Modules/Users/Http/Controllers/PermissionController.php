<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Http\Requests\PermissionCreateRequest;
use App\Modules\Users\Http\Requests\PermissionUpdateRequest;
//Interface
use App\Modules\Users\Repositories\Permission\PermissionInterface;

class PermissionController extends Controller
{
    private $permission;

    /**
     * PermissionRepository constructor.
     *
     * @param  Permission  $permission
     **/
    public function __construct(PermissionInterface $permission)
    {
        $this->model = $permission;
    }

    /***********************************Listado Registro Permiso(s)**************************************/
    public function index()
    {
        return view('users::permissions.index', ['identity' => 'Permiso(s)']);
    }

    /*****************************************Crear Permisos*********************************************/
    public function create()
    {
        return view('users::permissions.create', ['identity' => 'Registrar Permiso']);
    }

    /***********************************Guardar Registro Permiso(s)**************************************/
    public function store(PermissionCreateRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Permiso']);
    }

    /***********************************Buscar Registro Permiso(s)***************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /***********************************Guardar Registro Permiso(s)**************************************/
    public function update(PermissionUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /*************************************Eliminar Permiso(s)********************************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /******************************Datatable Permiso(s)**************************************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /********************************Api Consulta Permiso(s)***********************************************/
    public function select()
    {
        return $this->model->select();
    }
}
