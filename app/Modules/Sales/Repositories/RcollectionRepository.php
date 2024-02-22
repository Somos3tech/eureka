<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Exports\RcollectionReportExport;
use App\Modules\Sales\Models\Rcollection;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class RcollectionRepository implements RcollectionInterface
{
    protected $rcollection;

    /**
     * RcollectionRepository constructor.
     *
     * @param  Rcollections  $rcollection
     */
    /****************************************************************************/
    /****************************************************************************/
    public function __construct(Rcollection $rcollection)
    {
        $this->model = $rcollection;
    }

    /****************************************************************************/
    public function create($row)
    {
        $result = $this->model->create($row);
        if ($result) {
            return $result;
        }

        return false;
    }

    /****************************************************************************/
    public function find($id)
    {
        //
    }

    /****************************************************************************/
    public function update($request, $id)
    {
        //
    }

    /****************************************************************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        if ($result = $model->update()) {
            if ($result = $model->delete()) {
                return $model;
            }
        }

        return false;
    }

    /****************************************************************************/
    public function report($request)
    {
        ini_set('memory_limit', '4096M');
        $export = new RcollectionReportExport($request);

        return Excel::download($export, 'Reporte Carga Resultados Bancarios '.date('Y-m-d').'.xlsx');
    }
}
