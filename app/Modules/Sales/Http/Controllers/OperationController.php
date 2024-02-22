<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Exports\OperationResponseExport;
use App\Modules\Sales\Repositories\Operation\OperationInterface;
use Illuminate\Http\Request;
//Repository Collection dentro de Modulo
use Illuminate\Support\Collection as Collection;
use Maatwebsite\Excel\Facades\Excel;

class OperationController extends Controller
{
    protected $operation;

    public function __construct(OperationInterface $operation)
    {
        $this->model = $operation;
    }

    /**************************************************************************/
    public function index()
    {
        return View('sales::operations.index', ['identity' => 'Gestión Cobranza Servicios']);
    }

    /**************************************************************************/
    public function create()
    {
        return View('sales::operations.create', ['identity' => 'Gestión Cobranza Servicios']);
    }

    /**************************************************************************/
    public function masive()
    {
        return View('sales::operations.masive', ['identity' => 'Gestión Cobranza Servicios Másiva']);
    }

    /**************************************************************************/
    public function store(Request $request)
    {
        if (! $this->model->create($request)) {
            toastr()->error('Error al Procesar Gestión Cobranza Servicio(s)');

            return redirect()->back();
        }
        toastr()->info('Gestión Cobranza Servicio(s) Procesada Correctamente');

        return redirect()->to('operations/create');
    }

    /**************************************************************************/
    public function masiveStore(Request $request)
    {
        if (! $data = $this->model->masive($request)) {
            toastr()->error('Error al Cargar Registro de Cobro x Servicio');

            return redirect()->back();
        }
        toastr()->info('Se Cargo Pagos de Cobro x Servicio Correctamente');

        return Excel::download(new OperationResponseExport(Collect($data)), 'Resultado Gestión Operaciones Diaria Masivas - Cobranza Servicios  '.date('Y-m-d').'.xlsx');
    }

    /**************************************************************************/
    public function download()
    {
        return $this->model->download();
    }

    /**************************************************************************/
    public function edit()
    {
        return View('sales::operations.edit', ['identity' => 'Actualizar Gestión Cobranza Servicios']);
    }

    /**************************************************************************/
    public function update(Request $request, $id)
    {
        if (! $this->model->manage($request, $id)) {
            toastr()->error('Error al Actualizar Gestión Cobro x Servicio');

            return redirect()->back();
        }
        toastr()->info('Gestión Cobro x Servicio Actualizado Correctamente');

        return redirect()->to('operations');
    }

    /**************************************************************************/
    public function show(Request $request, $id)
    {
        return $this->model->find($request, $id);
    }

    /**************************************************************************/
    public function delete()
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Anulado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Anulado Registro']);
    }
}
