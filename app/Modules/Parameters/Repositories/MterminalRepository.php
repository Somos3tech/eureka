<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Mterminal;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class MterminalRepository implements MterminalInterface
{
    use TaskTrait;

    protected $mterminal;

    /**
     * MterminalRepository constructor.
     *
     * @param  Mterminal  $mterminal
     */
    public function __construct(Mterminal $mterminal)
    {
        $this->model = $mterminal;
    }

    /***********************Registrar Modelo Terminal************************/
    public function create($request)
    {
        $result = $this->model->create([
            'mark_id' => $request['mark_id'],
            'description' => $request['description'],
            'active' => $this->valid($request),
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /********************Buscar Información Modelo Terminal******************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /*********************Actualizar Modelo Terminal*************************/
    public function update($request, $id)
    {
        $data = [
            'mark_id' => $request['mark_id'],
            'description' => $request['description'],
            'active' => $this->valid($request),
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    public function valid($request)
    {
        if ($request->has('active')) {
            return true;
        }

        return false;
    }

    /*************************Eliminar Modelo Terminal***********************/
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

    /***********************Datatable Modelo Terminal*************************/
    public function datatable()
    {
        $data = $this->model->select('modelterminal.id as id', 'modelterminal.description', 'marks.description as mark')
            ->join('marks', function ($join) {
                $join->on('marks.id', '=', 'modelterminal.mark_id');
            })->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'mterminal', $data['id']);
            })->rawColumns(['actions'])
            ->toJson();
    }

    /*************************Select Modelo Terminal***************************/
    public function select($request)
    {
        $model = $this->model->query();

        $model->select('modelterminal.id as id', \DB::raw("CONCAT(modelterminal.description,' | ', marks.description) as description"))
            ->join('marks', function ($join) {
                $join->on('marks.id', '=', 'modelterminal.mark_id');
                $join->whereNull('marks.deleted_at');
            });
        if ($request->get('filter') == 'active') {
            $model->whereNotNull('modelterminal.active');
        }

        return $model->get();
    }
}
