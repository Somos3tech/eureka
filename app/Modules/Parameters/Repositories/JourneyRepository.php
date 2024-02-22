<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Journey;
use Auth;
use Illuminate\Support\Facades\Input;

class JourneyRepository implements JourneyInterface
{
    protected $journey;

    /**
     * JourneyRepository constructor.
     *
     * @param  Journey  $journey
     */
    public function __construct(Journey $journey)
    {
        $this->model = $journey;
    }

    /******************************Registrar Jornada****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'description' => $request['description'],
            'company_id' => $request['company_id'],
            'status' => $request['status'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /**************************Buscar Información Jornada***********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /******************************Actualizar Jornada***************************/
    public function update($request, $id)
    {
        $data = [
            'description' => $request['description'],
            'company_id' => $request['company_id'],
            'status' => $request['status'],
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /******************************Eliminar Jornada*****************************/
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

    /******************************Datatable Jornada*****************************/
    public function datatable()
    {
        return $this->model->select('journeys.id', 'journeys.description', 'cp.description as company', 'journeys.status')
            ->join('companies as cp', 'cp.id', 'journeys.company_id')
            ->get();
    }

    /*******************************Select Jornada********************************/
    public function api()
    {
        return $this->model->select('id', 'description')->where('company_id', '=', Input::get('company_id'))->where('status', 'Activo')->get();
    }
}
