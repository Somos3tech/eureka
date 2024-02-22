<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Http\Requests\RcollectionRequest;
use App\Modules\Sales\Repositories\RcollectionInterface;

class RcollectionController extends Controller
{
    protected $rcollection;

    public function __construct(RcollectionInterface $rcollection)
    {
        $this->model = $rcollection;
    }

    /**************************************************************************/
    public function report()
    {
        return view('sales::rcollections.report', ['identity' => 'Reporte Operación Masiva - Resultados']);
    }

    /**************************************************************************/
    public function reportExport(RcollectionRequest $request)
    {
        return $this->model->report($request);
    }
}
