<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Negotiation;
use Auth;
use Illuminate\Support\Facades\Input;

class NegotiationRepository implements NegotiationInterface
{
    protected $negotiation;

    /**
     * NegotiationRepository constructor.
     *
     * @param  Negotiation  $negotiation
     */
    public function __construct(Negotiation $negotiation)
    {
        $this->model = $negotiation;
    }

    /***************************Registrar Modo Negocio********************************/
    public function create($request)
    {
        $result = $this->model->create([
            'bank_id' => $request['bank_id'],
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************Buscar Información Modo Negocio**************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /*************************Actualizar Modo Negocio********************************/
    public function update($request, $id)
    {
        $data = [
            'bank_id' => $request['bank_id'],
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

    /****************************Eliminar Modo Negocio********************************/
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

    /******************************Datatable Modo Negocio******************************/
    public function datatable()
    {
        return $this->model->select('negotiations.id', 'negotiations.description', 'bk.description as bank_name')
            ->leftjoin('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'negotiations.bank_id');
            })
            ->get();
    }

    /*****************************Select Modo Negocio***********************************/
    public function api()
    {
        $model = $this->model->query();
        $model->select('negotiations.id', 'negotiations.description')
            ->leftjoin('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'negotiations.bank_id');
            });
        if (Input::get('dcustomer_id') != null) {
            $model->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.bank_id', '=', 'negotiations.bank_id');
            })->where('dc.id', '=', Input::get('dcustomer_id'));
        }

        if (Input::get('bank_id') != null) {
            $model->where('negotiations.bank_id', '=', Input::get('bank_id'));
        }

        return $model->get();
    }
}
