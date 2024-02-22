<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Exports\ReportLogExport;
use App\Modules\Parameters\Models\Log;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class LogRepository implements LogInterface
{
    protected $log;

    /**
     * ApnRepository constructor.
     *
     * @param  Log  $log
     */
    public function __construct(Log $log)
    {
        $this->model = $log;
    }

    /***************************Registrar Log********************************/
    public function create($request)
    {
        $result = $this->model->create([
            'customer_id' => $this->customerId($request),
            'contract_id' => $this->contractId($request),
            'item_method' => $request['item_method'],
            'item_table' => $request['item_table'],
            'data_old' => $request['data_old'],
            'data_new' => $request['data_new'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************Buscar Información APN**************************/
    public function activity($id, $item_table)
    {
        $model = $this->model->query();
        $model->where('item_table', '=', $item_table);
        if ($item_table == 'Cliente') {
            $model->where('customer_id', '=', $id);
        } else {
            $model->where('contract_id', '=', $id);
        }

        return \Response::json($model->get());
    }

    /************************************************************************/
    protected function customerId($request)
    {
        if ($request['item_table'] == 'customers') {
            return $request['id'];
        } elseif (($request['item_table'] != 'invoices') && ($request['item_table'] != 'contracts')) {
            return $request['customer_id'];
        }

        return null;
    }

    /************************************************************************/
    protected function contractId($request)
    {
        if ($request['item_table'] == 'contracts') {
            return $request['id'];
        } elseif ($request['item_table'] == 'invoices') {
            return $request['contract_id'];
        }

        return null;
    }

    /************************************************************************/
    public function report($request)
    {
        $data = [];
        $i = 0;
        $model = $this->model->query();
        $model->select('logs.created_at as created_log', 'logs.customer_id', 'cs.rif', 'cs.business_name', \DB::raw(" (CASE WHEN (logs.contract_id IS NULL) THEN '----' ELSE logs.contract_id END) as contract_id"), 'logs.data_old', 'logs.data_new', 'logs.created_at', \DB::raw("CONCAT(us.name,' ',us.last_name) as user_created"))
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'logs.customer_id');
            })
            ->leftjoin('users as us', function ($join) {
                $join->on('us.id', '=', 'logs.user_created_id');
            });

        if ($request['start'] != '' && $request['end'] != '') {
            $model->whereBetween('logs.created_at', [$request['start'].' %', $request['end'].' %']);
        }

        if (isset($request['rif'])) {
            $model->where('cs.rif', 'LIKE', $request['rif']);
        }

        if (isset($request['business_name'])) {
            $model->where('cs.business_name', 'LIKE', $request['business_name']);
        }
        $log = $model->orderBy('logs.created_at', 'DESC')->get();

        foreach ($log as $row) {
            $data[$i]['created'] = $row['created_log'];
            $data[$i]['customer_id'] = $row['customer_id'];
            $data[$i]['rif'] = $row['rif'];
            $data[$i]['business_name'] = $row['business_name'];
            $data[$i]['contract_id'] = $row['contract_id'];
            $data[$i]['data_new'] = unserialize($row['data_new']);

            if ($row['data_old'] != null) {
                $data[$i]['data_old'] = unserialize($row['data_old']);
            } else {
                $data[$i]['data_old'] = '----';
            }

            $data[$i]['created_at'] = $row['created_at'];
            $data[$i]['user_created'] = $row['user_created'];
            $i++;
        }

        return Excel::download(new ReportLogExport($data), 'Reporte Modificaciones Cliente '.date('Y-m-d').'.xlsx');
    }
}
