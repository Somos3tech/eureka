<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\TerminalValue;
use App\Traits\TaskTrait;
use Auth;
use Carbon\Carbon;
use Datatable;

class TerminalValueRepository implements TerminalValueInterface
{
    use TaskTrait;

    protected $terminal_value;

    /**
     * TerminalValueRepository constructor.
     *
     * @param  TerminalValue  $terminal_value
     */
    public function __construct(TerminalValue $terminal_value)
    {
        $this->model = $terminal_value;
    }

    /**********************Registrar Valor Terminal**************************/
    public function create($request)
    {
        if ($request['description'] == '') {
            $description = null;
        } else {
            $description = $request['description'];
        }

        $result = $this->model->create([
            'date_value' => $request['date_value'],
            'modelterminal_id' => $request['modelterminal_id'],
            'currency_id' => $request['currency_id'],
            'amount_currency' => str_replace(',', '', $request['amount_currency']),
            'amount_local' => str_replace(',', '', $request['amount_local']),
            'description' => $description,
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /******************Buscar Información Valor Terminal*********************/
    public function find($id)
    {
        $model = $this->model->select('terminalvalues.id', 'terminalvalues.date_value', 'mt.description as modelterminal', 'currencies.abrev as currency', 'terminalvalues.amount_local as amount_local_up', 'terminalvalues.amount_currency as amount_currency_up', 'terminalvalues.description')
            ->join('modelterminal as mt', 'mt.id', 'terminalvalues.modelterminal_id')
            ->join('currencies', 'currencies.id', 'terminalvalues.currency_id')
            ->where('terminalvalues.id', $id)
            ->first();

        return \Response::json($model);
    }

    /*********************Actualizar Valor Terminal**************************/
    public function update($request, $id)
    {
        $data = [
            'amount_currency' => str_replace(',', '', $request['amount_currency']),
            'amount_local' => str_replace(',', '', $request['amount_local']),
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

    /*********************Eliminar Valor Terminal****************************/
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

    /**********************Datatable Valor Terminal****************************/
    public function datatable()
    {
        $data = $this->model->select('terminalvalues.id', 'terminalvalues.date_value', 'mt.description as modelterminal', 'currencies.abrev as currency', 'terminalvalues.amount_local', 'terminalvalues.amount_currency', 'terminalvalues.description')
            ->join('modelterminal as mt', 'mt.id', 'terminalvalues.modelterminal_id')
            ->join('currencies', 'currencies.id', 'terminalvalues.currency_id')
            ->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'terminalvalues', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /*************************Api Valor Terminal*******************************/
    public function select()
    {
        //
    }

    /***********************Select Valor Terminal******************************/
    public function getAmount($request)
    {
        $date = Carbon::now();
        $model = $this->model->query();
        if ($request->get('modelterminal_id') != null && $request->get('currency_id') != null && $request->get('date_value') != null) {
            $model->select('terminalvalues.date_value as date', 'terminalvalues.currency_id', 'terminalvalues.amount_local as local', 'terminalvalues.amount_currency as currency', 'terminalvalues.description', 'currencies.abrev as currency_denomination')
                ->join('currencies', 'currencies.id', 'terminalvalues.currency_id')
                ->where('terminalvalues.modelterminal_id', '=', $request->get('modelterminal_id'));
            if ($request->has('date_value')) {
                $model->where('terminalvalues.date_value', '=', $request->get('date_value'));
            } else {
                $model->where('terminalvalues.date_value', '=', $date->format('Y-m-d'));
            }

            if ($request->get('currency_id') > 1) {
                $model->where('terminalvalues.currency_id', '=', $request->get('currency_id'));
            }

            return $model->get();
        }

        return null;
    }

    /**************************************************************************/
    public function getLast()
    {
        $count = 0;
        $date = Carbon::now();
        while ($count == 0) {
            $data = $this->model->select('terminalvalues.id', 'terminalvalues.date_value', 'mt.description as modelterminal', 'currencies.abrev as currency', 'terminalvalues.description', 'terminalvalues.amount_currency', 'terminalvalues.amount_local')
                ->leftjoin('modelterminal as mt', 'mt.id', '=', 'terminalvalues.modelterminal_id')
                ->leftjoin('currencies', 'currencies.id', '=', 'terminalvalues.currency_id')
                ->where('terminalvalues.date_value', 'LIKE', $date->format('Y-m-d'))
                ->get();
            if ($data != '[]') {
                $count = 1;
            } else {
                $date->subDay();
                $data = '';
            }
        }

        return $data;
    }
}
