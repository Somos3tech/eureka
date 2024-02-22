<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Repositories\InvoiceItemInterface;
//Repository Invoice dentro de Modulo
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    private $invoiceitem;

    public function __construct(InvoiceItemInterface $invoiceitem)
    {
        $this->model = $invoiceitem;
    }

    /**************************ver Registro Cobro******************************/
    public function find(Request $request)
    {
        return $this->model->find($request);
    }

    /**************************ver Registro Cobro******************************/
    public function show(Request $request, $id)
    {
        return $this->model->findInvoice($request, (int) $id);
    }
}
