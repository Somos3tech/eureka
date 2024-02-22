<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Consultant;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class ConsultantRepository implements ConsultantInterface
{
    use TaskTrait;

    protected $consultant;

    /**
     * ConsultantRepository constructor.
     *
     * @param  Consultant  $consultant
     */
    public function __construct(Consultant $consultant)
    {
        $this->model = $consultant;
    }

    /*************************Registrar Aliado*******************************/
    public function create($request)
    {
        $result = $this->model->create([
            'document_number' => $request['document_number'],
            'rif' => $request['rif'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'observation' => $request['observation'],
            'telephone' => $request['telephone'],
            'zone' => $request['zone'],
            'user_id' => $request['user_id'],
            'status' => $request['status'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************Buscar Información Aliado***********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /****************************Actualizar Aliado***************************/
    public function update($request, $id)
    {
        $data = [
            'document_number' => $request['document_number'],
            'rif' => $request['rif'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'observation' => $request['observation'],
            'telephone' => $request['telephone'],
            'zone' => $request['zone'],
            'user_id' => $request['user_id'],
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

    /**************************Registrar Aliado******************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->status = 'Inactivo';
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

    /***************************Datatable Aliado*******************************/
    public function datatable()
    {
        $data = $this->model->select('consultants.*', \DB::raw("CONCAT(users.name,' ', users.last_name) as user_associated"))
            ->join('users', 'users.id', '=', 'consultants.user_id')
            ->orderBy('consultants.status', 'ASC')
            ->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'consultants', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /******************************Select Aliado********************************/
    public function select()
    {
        return $this->model->select('id', \DB::raw("CONCAT(consultants.first_name,' ', consultants.last_name) as description"))->get();
    }

    /********************Select Usuario - Aliado,Vendedor***********************/
    public function select2($user_id)
    {
        $model = $this->model->query();
        $model->select('consultants.id', \DB::raw("CONCAT(consultants.first_name,' ', consultants.last_name) as description"))
            ->join('users', 'users.id', '=', 'consultants.user_id')
            ->where('consultants.user_id', '=', $user_id);

        return $model->where('consultants.status', 'LIKE', 'Activo')->get();
    }
}
