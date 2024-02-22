<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\ZoneRoleCreateRequest;
//Repository ZoneRole dentro de Modulo
use App\Modules\Parameters\Http\Requests\ZoneRoleUpdateRequest;
//Validación de Form request
use App\Modules\Parameters\Repositories\ZoneRoleInterface;
use Illuminate\Http\Request;

class ZoneRoleController extends Controller
{
    protected $zoner;

    /**
     * ZoneRoleRepository constructor.
     *
     * @param  ZoneRole  $zoner
     **/
    public function __construct(ZoneRoleInterface $zoner)
    {
        $this->model = $zoner;
    }

    /*********************Listado Registro Role Zona(s)************************/
    public function index()
    {
        return view('parameters::zoneroles.index', ['identity' => 'Registro Perfil(es) sin Zona']);
    }

    /********************Guardar Registro Role Zona(s)*************************/
    public function store(ZoneRoleCreateRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al registrar Perfiles sin Zona']);
    }

    /*********************Buscar Registro Role Zona(s)*************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /*********************Guardar Registro Role Zona(s)************************/
    public function update(ZoneRoleUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /*************************Eliminar Role Zona(s)****************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /************************Api Consulta Role Zona(s)*************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*********************Select Role Zona(s)**********************************/
    public function select()
    {
        return $this->model->api();
    }

    /******************Api Consulta Role Zona(s)*******************************/
    public function validCompany(Request $request)
    {
        return response()->json($this->model->validCompany($request['role']));
    }
}
