<?php

namespace App\Modules\Supports\Repositories;

use App\Modules\Sales\Repositories\ContractRepository;
use App\Modules\Supports\Models\Csupport;
use Auth;

class CsupportRepository implements CsupportInterface
{
    protected $csupport;

    protected $contract;

    /**
     * CsupportRepository constructor.
     *
     * @param  Consultant  $csupport
     */
    public function __construct(Csupport $csupport, ContractRepository $contract)
    {
        $this->model = $csupport;
        $this->contract = $contract;
    }

    /*************************Registrar Cambio Soporte***********************/
    public function create($request)
    {
        $result = $this->model->create([
            'contract_id' => $request['contract_id'],
            'type_support' => $request['type_support'],
            'observation' => $request['observation'],
            'status' => 'G',
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    public function validAffiliate($data)
    {
        $contract = $this->contract->model->leftjoin('dcustomers', function ($join) {
            $join->on('dcustomers.id', '=', 'contracts.dcustomer_id');
            $join->whereNull('dcustomers.deleted_at');
        })->where('contracts.id', $data['contract_id'])->first();
        if (isset($contract)) {
            if (isset($contract['affiliate_number']) && (strlen($contract['affiliate_number']) != 8 && strlen($contract['affiliate_number']) != 13)) {
                $result = $this->model->create([
                    'contract_id' => $data['contract_id'],
                    'type_support' => 'contract',
                    'observation' => 'Actualizar el Nro. Afiliación, Pendiente Orden de Servicio pr Procesar',
                    'status' => 'G',
                    'user_created_id' => Auth::user()->id,
                ]);
            }
        }
    }

    /**************************Buscar Cambio Soporte*************************/
    public function find($id)
    {
        $data = $this->model->select('csupports.id', 'csupports.contract_id', 'csupports.type_support as type', 'csupports.observation', 'csupports.observation_response')->where('csupports.id', $id)->first();

        return $data;
    }

    /**************************Buscar Cambio Soporte*************************/
    public function findContract($contract_id)
    {
        $data = $this->model->where('csupports.contract_id', $contract_id)->where('csupports.status', 'G')->first();
        if ($data) {
            return $data;
        }

        return false;
    }

    /****************************Actualizar Cambio Soporte*******************/
    public function update($request, $id)
    {
        $data = [
            'observation_response' => $request['observation_response'],
            'status' => 'F',
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /**************************Registrar Cambio Soporte**********************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->status = 'X';
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

    /***************************Datatable Aliado*****************************/
    public function datatable()
    {
        $model = $this->model->query();
        $data = $model->select('csupports.id', 'csupports.created_at', 'csupports.contract_id', 'cs.rif', 'cs.business_name', 'csupports.type_support', 'csupports.observation', 'csupports.status', \DB::raw("CONCAT(us.name,' ', us.last_name) as user_sale"), \DB::raw("CONCAT(user.name,' ', user.last_name) as user_support"))
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'csupports.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('users as us', function ($join) {
                $join->on('us.id', '=', 'ct.user_created_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('users as user', function ($join) {
                $join->on('user.id', '=', 'csupports.user_created_id');
                $join->whereNull('cs.deleted_at');
            })->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                //if ($data['status'] == 'G') {
                if (auth()->user()->can('csupports.edit', 'csupports.destroy')) {
                    $actions = '<center><button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                                    </button><div class="dropdown-menu" x-placement="bottom-start"></center';
                } else {
                    $actions = '<div><center>---</center>';
                }

                if (auth()->user()->can('csupports.edit')) {
                    $actions .= '<center><button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '"  OnClick="csupports(this);" data-target="#csupportsUpdate" title="Gestión Soporte Administrativo">Gestión </button></center';
                }

                if (auth()->user()->can('csupports.destroy')) {
                    $actions .= '<center><button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '"  OnClick="csupportsDelete(this);" data-target="#csupportsDelete" title="Eliminar">Eliminar</button></center>';
                }
                $actions .= '</div>';
                //} else {
                //    $actions = '<center>----</center>';
                //}

                return $actions;
            })->rawColumns(['actions'])
            ->toJson();
    }
}
