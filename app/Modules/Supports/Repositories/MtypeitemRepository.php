<?php

namespace App\Modules\Supports\Repositories;

use App\Modules\Supports\Models\Mtypeitem;
use App\Traits\TaskTrait;
use Auth;

class MtypeitemRepository implements MtypeitemInterface
{
    use TaskTrait;

    protected $mtypeitem;

    /**
     * MtypeitemRepository constructor.
     *
     * @param  Mtypeitem  $mtypeitem
     */
    public function __construct(Mtypeitem $mtypeitem)
    {
        $this->model = $mtypeitem;
    }

    /**************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'managementtype_id' => $request['managementtype_id'],
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
        return \Response::json($this->model->query()->where('mtypeitems.id', $id)->first());
    }

    /**************************************************************************/
    public function update($request, $id)
    {
        $data = [
            'managementtype_id' => $request['managementtype_id'],
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
        $model = $this->model->query();
        $data = $model->select('mtypeitems.id', 'mtypes.description as managementtype', 'mtypeitems.description as mtypeitem')->leftjoin('managementtypes as mtypes', 'mtypes.id', '=', 'mtypeitems.managementtype_id')->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'mtypeitems', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function select($request)
    {
        $model = $this->model->query();
        $model->select('mtypeitems.id', 'mtypeitems.description')
            ->leftjoin('managementtypes as mt', 'mt.id', '=', 'mtypeitems.managementtype_id');
        if ($request->has('managementtype_id')) {
            $model->where('mtypeitems.managementtype_id', $request['managementtype_id']);
        }

        if ($request->has('slug')) {
            $model->where('mt.slug', $request['slug']);
        }

        return $model->get();
    }
}
