<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Http\Requests\RoleCreateRequest;
use App\Modules\Users\Http\Requests\RoleUpdateRequest;
use App\Modules\Users\Repositories\Permission\PermissionInterface;
//Interface
use App\Modules\Users\Repositories\Role\RoleInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $role;

    private $permission;

    /**
     * RoleRepository constructor.
     *
     * @param  Role  $role
     * @param  Permission  $permission
     **/
    public function __construct(RoleInterface $role, PermissionInterface $permission)
    {
        $this->model = $role;
        $this->permission = $permission;
    }

    /***********************Listado Registro Role(s)***************************/
    public function index()
    {
        return view('users::roles.index', ['identity' => 'Registro Perfil(es)']);
    }

    /************************Crear Registro Role(s)****************************/
    public function create()
    {
        $permissions = $this->permission->model->get();
        $titles = $this->permission->model->select('description', \DB::raw("SUBSTRING_INDEX(name, '.', 1) as slug"))->where('name', 'LIKE', '%.index')->get();

        return view('users::roles.create', ['permissions' => $permissions, 'titles' => $titles, 'identity' => 'Registrar Perfil']);
    }

    /**********************Guardar Registro Role(s)****************************/
    public function store(RoleCreateRequest $request)
    {
        if ($this->model->create($request)) {
            toastr()->info('Perfil Creado Correctamente');

            return redirect()->to('roles');
        }
        toastr()->error('Error al Registrar Perfil');

        return redirect()->back()->withInput();
    }

    /**********************Buscar Registro Role(s)*****************************/
    public function edit($id)
    {
        $data = $this->model->find($id);
        $permissions = $this->permission->model->get();
        $permissions_user = $this->model->model->select('permissions.name')
            ->join('role_has_permissions as rp', 'rp.role_id', '=', 'roles.id')
            ->join('permissions', 'permissions.id', '=', 'rp.permission_id')
            ->where('roles.id', $id)
            ->get();

        $titles = $this->permission->model->select('description', \DB::raw("SUBSTRING_INDEX(name, '.', 1) as slug"))->where('name', 'LIKE', '%.index')->get();

        return view('users::roles.edit', ['identity' => 'Actualizar Perfíl', 'data' => $data, 'permissions' => $permissions, 'permissions_user' => $permissions_user->toArray(), 'titles' => $titles]);
    }

    /**********************Guardar Registro Role(s)****************************/
    public function update(RoleUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            toastr()->info('Perfil Actualizado Correctamente');

            return redirect()->to('roles');
        }
        toastr()->error('Error al Actualizar registro');

        return redirect()->back()->withInput();
    }

    /**********************Eliminar Registro Role(s)***************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**************************Datatable Role(s)*******************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**************************Consulta Role(s)********************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }

    /******************************************Api Consulta Role***************************************************/
    public function validRole(Request $request)
    {
        return response()->json($this->model->validRole($request['role'], $request['slug']));
    }

    /******************************************Api Consulta Role***************************************************/
    public function getRole()
    {
        return response()->json($this->model->getRole());
    }
}
