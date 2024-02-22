<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Repositories\Operterminal\OperterminalInterface;
use Illuminate\Http\Request;
//Repository Collection dentro de Modulo
use Illuminate\Support\Collection as Collection;

class OperterminalController extends Controller
{
    protected $operterminal;

    public function __construct(OperterminalInterface $operterminal)
    {
        $this->model = $operterminal;
    }

    /**************************************************************************/
    public function index()
    {
        return View('sales::operterminals.index', ['identity' => 'Gestión Terminales']);
    }

    /**************************************************************************/
    public function create()
    {
        return View('sales::operterminals.create', ['identity' => 'Gestión Terminal']);
    }

    /**************************************************************************/
    public function store(Request $request)
    {
        if (! $this->model->create($request)) {
            toastr()->error('Error al Generar Gestión Terminal');

            return redirect()->back();
        }
        toastr()->info('Gestión Terminal Generada Correctamente');

        return redirect()->to('operterminals/create');
    }

    /**************************************************************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Anulado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Anulado Registro']);
    }

    /**************************************************************************/
    public function reactive($id)
    {
        if ($result = $this->model->reactive($id)) {
            return response()->json(['success' => 'true', 'message' => $result]);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Reactivar Contrato']);
    }

    /**************************************************************************/
    public function show(Request $request, $id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**************************************************************************/
    public function report(Request $request)
    {
        return View('sales::operterminals.report', ['identity' => 'Reporte Gestión Terminal']);
    }

    /**************************************************************************/
    public function reportExport(Request $request)
    {
        return $this->model->report($request);
    }
}
