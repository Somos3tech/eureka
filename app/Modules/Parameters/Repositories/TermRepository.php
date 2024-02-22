<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Term;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class TermRepository implements TermInterface
{
    use TaskTrait;

    protected $term;

    /**
     * TermRepository constructor.
     *
     * @param  Term  $term
     */
    public function __construct(Term $term)
    {
        $this->model = $term;
    }

    /******************************Registrar Bank****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'abrev' => $request['abrev'],
            'description' => $request['description'],
            'observations' => $request['observations'],
            'type_conditions' => $request['type_conditions'],
            'type_conditions1' => $request['type_conditions1'],
            'currency_id' => $request['currency_id'],
            'comission_flatrate' => $request['comission_flatrate'],
            'comission_percentage' => $request['comission_percentage'],
            'comission_id' => $request['comission_id'],
            'comission_min' => $request['comission_min'],
            'amount_min' => $request['amount_min'],
            'amount_max' => $request['amount_max'],
            'prepaid' => $request['prepaid'],
            'type_invoice' => $request['type_invoice'],
            'status' => 'Activo',
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /******************************BuscarInformación Banco*******************/
    public function find($id)
    {
        $model = $this->model->query();
        $model->select(
            'terms.id',
            'terms.abrev',
            'terms.description',
            'terms.observations',
            'terms.type_conditions',
            'terms.type_conditions1',
            'currencies.id as currency',
            'terms.comission_flatrate',
            'terms.comission_percentage',
            'terms.comission_id',
            'terms.comission_min',
            'terms.amount_min',
            'terms.amount_max',
            'terms.prepaid',
            'terms.type_invoice',
            'terms.status'
        )
            ->leftjoin('currencies', 'currencies.id', '=', 'terms.currency_id')
            ->leftjoin('comissions as com', 'com.id', '=', 'terms.comission_id')
            ->where('terms.id', $id);

        return \Response::json($model->first());
    }

    /******************************Actualizar Bank***************************/
    public function update($request, $id)
    {
        $data = [
            'abrev' => $request['abrev'],
            'description' => $request['description'],
            'observations' => $request['observations'],
            'type_conditions' => $request['type_conditions'],
            'type_conditions1' => $request['type_conditions1'],
            'currency_id' => $request['currency_id'],
            'comission_flatrate' => $request['comission_flatrate'],
            'comission_percentage' => $request['comission_percentage'],
            'comission_id' => $request['comission_id'],
            'comission_min' => $request['comission_min'],
            'amount_min' => $request['amount_min'],
            'amount_max' => $request['amount_max'],
            'prepaid' => $request['prepaid'],
            'type_invoice' => $request['type_invoice'],
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /******************************Registrar Banco*****************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->status = 'Inactivo';
        $model->user_deleted_id = Auth::user()->id;

        if ($result = $model->update()) {
            if ($result = $model->delete()) {
                return true;
            }
        }

        return false;
    }

    /************************Datatable Terminos********************************/
    public function datatable()
    {
        $model = $this->model->query();
        $data = $model->select('terms.id', 'terms.abrev', 'terms.description', 'terms.type_conditions', 'terms.type_conditions1', 'currencies.abrev as currency', \DB::raw("(CASE WHEN (terms.type_invoice='M') THEN 'Cobro Mensual' WHEN (terms.type_invoice='D') THEN 'Cobro Diario' WHEN (terms.type_invoice='S') THEN 'Cobro Semanal' WHEN (terms.type_invoice='Q') THEN 'Cobro Quincenal' ELSE 'No definido' END) as type_invoice"), 'terms.created_at', 'terms.status')
            ->leftjoin('currencies', 'currencies.id', '=', 'terms.currency_id');

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'terms', $data['id']);
            })->rawColumns(['status', 'actions'])
            ->toJson();
    }

    /******************************Api Select**********************************/
    public function select($request)
    {
        if ($request->get('type_condition')) {
            return $this->model->select('id', 'description')->where('type_conditions1', '=', $request->get('type_condition'))->where('status', 'LIKE', 'Activo')->get();
        } else {
            return $this->model->select('id', 'description')->where('status', 'LIKE', 'Activo')->get();
        }
    }
}
