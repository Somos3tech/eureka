<?php

namespace App\Modules\Supports\Repositories;

use App\Modules\Supports\Models\Managementtype;
use App\Traits\TaskTrait;
use Auth;

class ManagementtypeRepository implements ManagementtypeInterface
{
    use TaskTrait;

    protected $managementtype;

    /**
     * ManagementtypeRepository constructor.
     *
     * @param  Managementtype  $managementtype
     */
    public function __construct(Managementtype $managementtype)
    {
        $this->model = $managementtype;
    }

    /**************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'slug' => $request['slug'],
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /**************************************************************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /**************************************************************************/
    public function update($request, $id)
    {
        $data = [
            'slug' => $request['slug'],
            'description' => $request['description'],
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /**************************************************************************/
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

    /**************************************************************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'managementtypes', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function select($request)
    {
        $model = $this->model->query();
        $model->select('id', 'description');
        if ($request['slug'] != '' && $request['slug'] != 'internal') {
            $model->whereIn('slug', $request['slug']);
        } elseif ($request['slug'] == 'internal') {
            $model->whereIn('slug', ['internal', 'developer']);
        } else {
            $model->whereNotIn('slug', ['internal', 'developer']);
        }

        return $model->get();
    }
}
