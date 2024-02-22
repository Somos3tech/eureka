<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Exports\CurrencyvalueReportExport;
use App\Modules\Parameters\Models\Currency;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class CurrencyRepository implements CurrencyInterface
{
    use TaskTrait;

    protected $currency;

    /**
     * CurrencyRepository constructor.
     *
     * @param  Currency  $currency
     */
    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    /**************************Registrar Divisa********************************/
    public function create($request)
    {
        $result = $this->model->create([
            'abrev' => $request['abrev'],
            'description' => $request['description'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /***********************Buscar Información Divisa**************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /*************************Actualizar Divisa********************************/
    public function update($request, $id)
    {
        $data = [
            'abrev' => $request['abrev'],
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

    /**************************Eliminar Divisa********************************/
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

    /****************************Datatable Divisa*******************************/
    public function datatable()
    {
        $data = $this->model->all();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'currencies', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function select($request)
    {
        $model = $this->model->query();
        $model->select('id', 'abrev');

        if ($request->get('local') == 'N') {
            $model->whereNotIn('id', [1]);
        }

        return $model->get();
    }

    /**************************************************************************/
    public function report($request)
    {
        $export = new CurrencyvalueReportExport($request->all());

        return Excel::download($export, 'Reporte Cambio Divisas '.date('Y-m-d').'.xlsx');
    }
}
