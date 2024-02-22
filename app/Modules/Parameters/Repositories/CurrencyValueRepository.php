<?php

namespace App\Modules\Parameters\Repositories;

use App\Events\CurrencyValue as CurrencyValueEvent;
use App\Modules\Parameters\Exports\CurrencyValueReportExport;
use App\Modules\Parameters\Models\CurrencyValue;
use App\Traits\TaskTrait;
use Auth;
use Datatable;
use Maatwebsite\Excel\Facades\Excel;

class CurrencyValueRepository implements CurrencyValueInterface
{
    use TaskTrait;

    protected $currency_value;

    /**
     * CurrencyValueRepository constructor.
     *
     * @param  CurrencyValue  $currency_value
     */
    public function __construct(CurrencyValue $currency_value)
    {
        $this->model = $currency_value;
    }

    /************************Registrar Valor Divisa****************************/
    public function create($request)
    {
        if ($request['description'] == '') {
            $description = null;
        } else {
            $description = $request['description'];
        }

        $result = $this->model->create([
            'date_value' => $request['date_value'],
            'currency_id' => $request['currency_id'],
            'amount' => str_replace(',', '', $request['amount']),
            'description' => $description,
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            $data = $this->getLast();
            event(new CurrencyValueEvent($data->toArray()));

            return true;
        }

        return false;
    }

    /*********************Buscar Información Valor Divisa**********************/
    public function find($id)
    {
        $model = $this->model->select('currencyvalues.id', 'currencyvalues.date_value', 'currencies.abrev as currency', 'currencyvalues.amount as amount_up', 'currencyvalues.description')
            ->join('currencies', 'currencies.id', 'currencyvalues.currency_id')
            ->where('currencyvalues.id', $id)
            ->first();

        return \Response::json($model);
    }

    /***************************Actualizar Valor Divisa************************/
    public function update($request, $id)
    {
        $data = [
            'amount' => str_replace(',', '', $request['amount']),
            'description' => $request['description'],
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            $data = $this->getLast();
            event(new CurrencyValueEvent($data->toArray()));

            return true;
        }

        return false;
    }

    /************************Eliminar Valor Divisa ****************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                $data = $this->getLast();
                event(new CurrencyValueEvent($data->toArray()));

                return true;
            }
        }

        return false;
    }

    /*************************Datatable Valor Divisa***************************/
    public function datatable()
    {
        $data = $this->model->select('currencyvalues.id', 'currencyvalues.date_value', 'currencies.abrev as currency', 'currencyvalues.amount', 'currencyvalues.description')
            ->join('currencies', 'currencies.id', 'currencyvalues.currency_id')
            ->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'currencyvalues', $data['id']);
            })->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function select()
    {
    }

    /**************************************************************************/
    public function getCurrencyValue()
    {
        $model = $this->model->query();

        $query = $model->select('currencyvalues.id', 'currencyvalues.date_value', 'currencyvalues.amount as amountc', 'currencyvalues.description')
            ->join('currencies', 'currencies.id', 'currencyvalues.currency_id')
            ->where('currencyvalues.currency_id', '=', '2')
            ->orderby('currencyvalues.date_value', 'DESC')
            ->take(20)->get();
        $query = $query->sortBy('date_value');
        foreach ($query as $row) {
            $data[] = $row;
        }

        return $data;
    }

    /**************************************************************************/
    public function valueDycon($request)
    {
        $model = $this->model->query();
        if ($request->get('currency_id') != null) {
            $data = $model->select('currencyvalues.date_value', 'currencyvalues.amount as dicom', 'currencies.abrev as currency')
                ->join('currencies', 'currencies.id', 'currencyvalues.currency_id')
                ->where('currencyvalues.currency_id', '=', $request->get('currency_id'))
                ->whereNull('currencyvalues.deleted_at')
                ->where('currencyvalues.date_value', '=', $request->get('date_value'))
                ->orWhere('currencyvalues.date_value', '=', now()->format('Y-m-d'))
                ->get()
                ->last();
            if ($data) {
                return $data;
            } else {
                $model = $this->model->query();

                return $model->select('currencyvalues.date_value', 'currencyvalues.amount as dicom', 'currencies.abrev as currency')
                    ->join('currencies', 'currencies.id', 'currencyvalues.currency_id')
                    ->get()
                    ->last();
            }
        }

        return false;
    }

    /**************************************************************************/
    public function last()
    {
        $model = $this->model->query();

        return $model->select(\DB::raw("CONCAT('Bs. ',FORMAT(currencyvalues.amount,2)) as value"), 'currencyvalues.description', \DB::raw("DATE_FORMAT(currencyvalues.date_value, '%d/%m/%Y') as  date_value"))->get();
    }

    /**************************************************************************/
    public function getLast()
    {
        $model = $this->model->query();

        return $model->select('currencyvalues.date_value', \DB::raw('FORMAT(currencyvalues.amount,2) as value'))->get()->last();
    }

    public function report($request)
    {
        $export = new CurrencyValueReportExport($request->all());

        return Excel::download($export, 'Reporte Cambio Tasa Divisas  '.date('Y-m-d').'.xlsx');
    }
}
