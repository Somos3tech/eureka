<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Commission;
use Auth;

class CommissionRepository implements CommissionInterface
{
    private $commission;

    /**
     * Commission Repository constructor.
     *
     * @param  Commission  $commission
     **/
    public function __construct(Commission $commission)
    {
        $this->model = $commission;
    }

    /******************************Registrar Bank****************************/
    public function create($request)
    {
        $sum = 0;
        /******************************Crear Comisión Servicio***************************/
        $modalitys = [
            'range' => $request['range'],
            'value' => $request['value'],
        ];

        $data = [
            'description' => $request['description'],
            'observation' => $request['observations'],
            'type_condition' => $request['type_condition'],
            'user_created_id' => Auth::user()->id,
            'status' => 'Activo',
        ];

        $modalities = [];

        foreach ($modalitys as $key => $value) {
            if (($key == 'range') || ($key == 'value')) {
                array_push($modalities, $key);
            }
        }

        for ($i = 0; $i < count($modalitys['range']); $i++) {
            $range = 'range' . ($i + 1);
            $value = 'value' . ($i + 1);

            $arr = [
                $range => $modalitys['range'][$i],
                $value => $modalitys['value'][$i],
            ];
            //uno los arrays y muestro el array resultante
            $data = array_merge($data, $arr);
        }

        $result = $this->model->create($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /******************************BuscarInformación Banco********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    public function commissionArray($request)
    {
    }

    /******************************Actualizar Bank***************************/
    public function update($request, $id)
    {
        $model = $this->model->findOrfail($id);

        $sum = 0;
        /******************************Crear Comisión Servicio***************************/
        $modalitys = [
            'range' => $request['range'],
            'value' => $request['value'],
        ];

        $data = [
            'description' => $request['description'],
            'observation' => $request['observations'],
            'type_condition' => $request['type_condition'],
            'user_updated_id' => Auth::user()->id,
            'status' => $request['statusc'],
        ];

        $modalities = [];

        foreach ($modalitys as $key => $value) {
            if (($key == 'range') || ($key == 'value')) {
                array_push($modalities, $key);
            }
        }

        for ($i = 0; $i < count($modalitys['range']); $i++) {
            $range = 'range' . ($i + 1);
            $value = 'value' . ($i + 1);

            $arr = [
                $range => $modalitys['range'][$i],
                $value => $modalitys['value'][$i],
            ];
            //uno los arrays y muestro el array resultante
            $data = array_merge($data, $arr);
        }
        $result = $model->update($data);
        if ($result) {
            return true;
        }

        return false;
    }

    /******************************Registrar Banco****************************/
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

    /******************************Datatable Banco****************************/
    public function datatable()
    {
        return $this->model->all();
    }

    public function select($request)
    {
        $raw = \DB::raw('id, description');
        $query = $this->model->where('type_conditions', 'LIKE', $request->get('condition'))->select($raw, 'id')->get();

        return $query->toArray();
    }

    public function api()
    {
        $raw = \DB::raw("*, CONCAT(commissions.description, ' - ',commissions.type_condition) as fullname");

        return $this->model->select($raw)
            ->whereNull('commissions.deleted_at')
            ->pluck('fullname', 'commissions.id');
    }
}
