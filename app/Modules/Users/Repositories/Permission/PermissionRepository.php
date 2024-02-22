<?php

namespace App\Modules\Users\Repositories\Permission;

use App\Traits\TaskTrait;
use DataTable;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionInterface
{
    use TaskTrait;

    protected $permission;

    /**
     * PermissionRepository constructor.
     *
     * @param  Permission  $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /************************Registrar Permission****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'description' => $request['description'],
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************Información Permission****************************/
    public function find($id)
    {
        return \Response::json($this->model->where('id', '=', $id)->first());
    }

    /************************Actualizar Permission*******^*********************/
    public function update($request, $id)
    {
        $data = [
            'name' => $request['name'],
            'slug' => $request['slug'],
            'description' => $request['description'],
        ];

        $model = $this->model->findOrfail($id);

        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /***************************Eliminar Permission****************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $result = $model->delete();

        if ($result) {
            return true;
        }

        return false;
    }

    /***************************Datatable Permission***************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'permissions', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /***********************************Select*********************************/
    public function select()
    {
        return $this->model->select('id', 'name as description')->get();
    }
}
