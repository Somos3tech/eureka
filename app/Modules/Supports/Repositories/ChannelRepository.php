<?php

namespace App\Modules\Supports\Repositories;

use App\Modules\Supports\Models\Channel;
use App\Traits\TaskTrait;
use Auth;

class ChannelRepository implements ChannelInterface
{
    use TaskTrait;

    protected $channel;

    /**
     * ChannelRepository constructor.
     *
     * @param  Channel  $channel
     */
    public function __construct(Channel $channel)
    {
        $this->model = $channel;
    }

    /**************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
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
                return $this->buttonActionS(true, true, 'channels', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function select()
    {
        return $this->model->select('id', 'description')->get();
    }
}
