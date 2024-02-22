<?php

namespace App\Modules\Users\Repositories\User;

use App\Modules\Users\Models\User;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class UserRepository implements UserInterface
{
    use TaskTrait;

    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /***************************Registrar Usuario****************************/
    public function create($request)
    {
        if (! $model = $this->model->create($data = $this->arrayData($request, $this->listBank($request['banklist'])))) {
            return false;
        }
        $model->syncRoles([$request->get('role')]);

        return true;
    }

    /*************************Actualizar Usuario*****************************/
    public function update($request, $id)
    {
        $model = $this->model->findOrfail($id);
        if (! $result = $model->update($data = $this->arrayData($request, $this->listBank($request['banklist'])))) {
            return false;
        }
        $model->syncRoles([$request->get('role')]);

        return true;
    }

    /*******************Otras Funciones de Reuso de Usuario******************/
    private function arrayData($request, $banklist)
    {
        switch ($this->validPassword($request['password'])) {
            case 'Valid_pass':
                return [
                    'document' => $request['doc'],
                    'name' => $request['name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'password' => $this->hashPassword($request['password']),
                    'jobtitle' => $request['jobtitle'],
                    'company_id' => $request['company_id'],
                    'banklist' => $banklist,
                    'status' => $request['statusc'],
                ];
                break;

            default:
                return [
                    'doc' => $request['document'],
                    'name' => $request['name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'jobtitle' => $request['jobtitle'],
                    'company_id' => $request['company_id'],
                    'banklist' => $banklist,
                    'status' => $request['statusc'],
                ];
                break;
        }
    }

    /************Eliminar Usuario (Suspendido - Elimnar Softdeleted)*********/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->status = 'Inactivo';
        if (! $result = $model->update()) {
            return false;
        }

        return true;
    }

    /************************Datatable Usuario*******************************/
    public function datatable()
    {
        $data = $this->model->select('users.id', \DB::raw("CONCAT(users.name,' ', users.last_name) as name"), 'users.jobtitle', 'users.email', \DB::raw(" (CASE WHEN (cp.description IS NULL) THEN 'No Asignada' ELSE cp.description END) as company"), 'users.status as status', 'roles.description as profile')
            ->leftjoin('model_has_roles as mr', 'mr.model_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=', 'mr.role_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'users.company_id')
            ->orderby('id', 'ASC')->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonAction(true, true, 'users', $data['id']);
            })->rawColumns(['status', 'actions'])
            ->toJson();
    }

    /**********************Consulta Información Usuario**********************/
    public function find($id)
    {
        $model = $this->model->select('users.id', 'users.document', 'users.name', 'users.last_name', 'users.jobtitle', 'users.email', 'users.status as statusc', 'users.company_id', \DB::raw(" (CASE WHEN (users.banklist = '[null]') THEN NULL ELSE users.banklist END) as banklist"), 'cp.description as company', 'roles.name as role')
            ->leftjoin('model_has_roles as mr', 'mr.model_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=', 'mr.role_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'users.company_id')
            ->findOrfail($id);

        return $model;
    }

    /************************Cambiar Contraseña Usuario**********************/
    public function changePassword($password)
    {
        $model = $this->model->findOrFail(Auth::user()->id);
        if ($model) {
            $model->password = \Hash::make($password);

            return $model->update();
        }

        return false;
    }

    /************************Select con Variable Slug************************/
    public function select($slug, $user_id, $company_id)
    {
        $query = $this->model->query();
        $query->select('users.id', \DB::raw("CONCAT(users.name,' ', users.last_name) as description"), 'rol.name')
            ->join('model_has_roles as ru', 'ru.model_id', '=', 'users.id')
            ->join('roles as rol', 'rol.id', '=', 'ru.role_id')
            ->where('users.status', 'LIKE', 'Activo');

        return $query->whereIn('rol.name', ['sales', 'preafiliation', 'assistant', 'preafiliation.office'])->orWhere('rol.name', 'LIKE', 'sales.%')->get();
    }

    /************************************************************************/
    public function assignment($request)
    {
        $model = $this->model->query();
        $model->select('users.id', \DB::raw("CONCAT(users.name,' ', users.last_name) as description"))
            ->join('model_has_roles as ru', 'ru.model_id', '=', 'users.id')
            ->join('roles as rol', 'rol.id', '=', 'ru.role_id');

        if ($request['user_id'] != '' && $request['filter'] == '') {
            $model->where('users.id', '=', $request['user_id']);
        } elseif ($request['filter'] == 'assign') {
            $model->where('users.id', '!=', $request['user_id']);
        }

        $model->whereIn('rol.name', ['programmer', 'superadmin']);

        if (Auth::user()->company_id != null) {
            $model->where('users.company_id', '=', Auth::user()->company_id);
        } elseif ($request['company_id'] != null) {
            $model->where('users.company_id', '=', $request['company_id'])->orWhereNull('users.company_id');
        }

        return $model->where('users.status', 'LIKE', 'Activo')->get();
    }

    /************************************************************************/
    private function validPassword($password)
    {
        if (! is_null($password)) {
            return 'Valid_pass';
        }

        return false;
    }

    /************************************************************************/
    private function hashPassword($password)
    {
        return \Hash::make($password);
    }

    private function listBank($banklist)
    {
        if ($banklist != null) {
            return json_encode($banklist, true);
        }

        return $banklist;
    }
}
