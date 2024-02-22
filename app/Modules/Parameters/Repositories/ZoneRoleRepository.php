<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\ZoneRole;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class ZoneRoleRepository implements ZoneRoleInterface
{
    use TaskTrait;

    protected $zoner;

    /**
     * ZoneRoleRepository constructor.
     *
     * @param  ZoneRole  $zoner
     */
    public function __construct(ZoneRole $zoner)
    {
        $this->model = $zoner;
    }

    /******************************Registrar Operador****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'role_id' => $request['role_id'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /******************************BuscarInformación Operador********************/
    public function find($id)
    {
        return \Response::json($this->model->where('id', '=', $id)->first());
    }

    /******************************Actualizar Operador***************************/
    public function update($request, $id)
    {
        $data = [
            'role_id' => $request['role_id'],
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /******************************Registrar Operador****************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /******************************Datatable*********************************/
    public function datatable()
    {
        $data = $this->model->select('zone_role.id as id', 'name', 'description')
            ->join('roles', 'roles.id', '=', 'zone_role.role_id')
            ->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                if ($data->name != 'superadmin') {
                    return $this->buttonActionS(true, true, 'zonerole', $data['id']);
                } else {
                    return '<center>---</center>';
                }
            })->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function validCompany($role)
    {
        $rol = $this->model->select('name as slug')
            ->join('roles', 'roles.id', '=', 'zone_role.role_id')
            ->where('roles.name', $role)
            ->first();
        if (isset($rol)) {
            return false;
        }

        return true;
    }

    /**************************************************************************/
    public function api()
    {
    }
}
