<?php

namespace App\Modules\Users\Repositories\Role;

use App\Traits\TaskTrait;
use Auth;
use Datatable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleInterface
{
    use TaskTrait;

    protected $role;

    protected $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->model = $role;
        $this->permission = $permission;
    }

    /*****************************Registrar Role*****************************/
    public function create($request)
    {
        $permission = [];
        $model = $this->model->create([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);
        if ($model) {
            if ($request['permissions'] != null) {
                foreach ($request['permissions'] as $key => $value) {
                    $permission[$key] = $value;
                }
            }
            $model->givePermissionTo($permission);

            return true;
        }

        return false;
    }

    /*************************Buscar Información Role************************/
    public function find($id)
    {
        return $this->model->findOrfail($id);
    }

    /***************************Actualizar Role******************************/
    public function update($request, $id)
    {
        $permission = [];
        $model = $this->model->findOrfail($id);
        if ($model) {
            $data = [
                'name' => $request['name'],
                'description' => $request['description'],
            ];

            $result = $model->update($data);

            if ($result) {
                if ($request['permissions'] != null) {
                    foreach ($request['permissions'] as $key => $value) {
                        $permission[$key] = $value;
                    }
                }
                $model->syncPermissions($permission);
                $this->permission->syncRoles($model);

                return true;
            }
        }

        return false;
    }

    /***************************Registrar Role*******************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $result = $model->delete();
        if ($result) {
            return true;
        }

        return false;
    }

    /**************************Datatable Role********************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonAction(true, true, 'roles', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /****************************Select Role*********************************/
    public function select($request)
    {
        $model = $this->model->query();

        if ($request['action'] == 'zonerole') {
            $model->whereNotExists(function ($query) {
                $query->select('zone_role.id')
                    ->from('zone_role')
                    ->whereRaw('zone_role.role_id = roles.id')
                    ->whereNull('zone_role.deleted_at');
            });

            return $model->select('roles.id', 'roles.name', 'roles.description')
                ->whereNotIn('roles.name', ['superadmin', 'admin'])
                ->orderBy('roles.id')
                ->get();
        }

        $data = $model->select('roles.id', 'roles.name', 'roles.description')->orderBy('roles.id')->get();

        if (Auth::user()->id == 1) {
            $data->whereNotIn('roles.name', ['superadmin', 'admin']);
        }

        return $data;
    }

    /*************************************************************************/
    public function validRole($role, $slug)
    {
        $model = $this->model->query();
        if ($role != null) {
            $model = $model->where('roles.name', '=', $role)->first();
            $slug = explode(',', $slug);

            if (is_array($slug)) {
                for ($i = 0; $i < count($slug); $i++) {
                    if ($model->name == $slug[$i]) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**************************************************************************/
    public function getRole()
    {
        return $this->model->select('ru.model_id as user_id', 'roles.name as slug')
            ->join('model_has_roles as ru', 'ru.role_id', '=', 'roles.id')
            ->join('users', 'users.id', '=', 'ru.model_id')
            ->where('users.id', \Auth::user()->id)->first();
    }
}
