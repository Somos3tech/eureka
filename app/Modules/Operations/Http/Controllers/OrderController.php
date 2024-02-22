<?php

namespace App\Modules\Operations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Operations\Http\Requests\OrderUpdateRequest;
use App\Modules\Operations\Repositories\OrderInterface;
use App\Modules\Operations\Repositories\Service\ServiceInterface;
//Repository Order dentro de Modulo
use App\Modules\Operations\Repositories\Transfer\TransferInterface;
use App\Modules\Warehouses\Repositories\Assignment\AssignmentInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    protected $service;

    protected $assignment;

    protected $transfer;

    public function __construct(OrderInterface $order, ServiceInterface $service, AssignmentInterface $assignment, TransferInterface $transfer)
    {
        $this->model = $order;
        $this->service = $service;
        $this->assignment = $assignment;
        $this->transfer = $transfer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('operations::orders.index', ['identity' => 'Ordenes de Servicio']);
    }

    /**************************************************************************/
    public function programmer()
    {
        return view('operations::orders.programmer', ['identity' => 'Ordenes de Servicio - Programación']);
    }

    /**************************************************************************/
    public function office()
    {
        return view('operations::orders.office', ['identity' => 'Ordenes de Servicio - Despacho']);
    }

    /**************************************************************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function edit($id)
    {
        $data = $this->model->find($id);

        return View('operations::orders.edit', ['data' => $data, 'identity' => 'Gestión Orden de Servicio']);
    }

    /**************************************************************************/
    public function update(OrderUpdateRequest $request, $id)
    {
        if (!$data = $this->service->management($request, $id)) {
            toastr()->error('Error en la gestión de la Orden de Servicio');

            return redirect()->back()->withInput();
        }
        toastr()->info($data);

        ////////////////////////////////////////////////////////////
        //AGREGADO ALCIDES DA SILVA 02/06/2023
        if (!empty($request['nropos'])) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://192.168.0.23:9191/profit/GrabarSerial/' . $request['contract_id']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
        }
        /////////////////////////////////////////////////////////////

        return redirect()->to('orders/programmer');
    }

    /**************************************************************************/
    public function updateService(Request $request, $id)
    {
        if ($data = $this->service->management($request, $id)) {
            return response()->json(['success' => 'true', 'message' => $data]);
        }

        return response()->json(['success' => 'false', 'message' => 'Error en la Gestión de Orden de Servicio ']);
    }

    /**************************************************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**************************************************************************/
    public function datatableUser($id)
    {
        return $this->model->datatableUser($id);
    }

    /**************************************************************************/
    public function dataStatus(Request $request)
    {
        return $this->model->dataStatus($request);
    }

    /**************************************************************************/
    public function reportProgrammer()
    {
        return $this->model->reportProgrammer();
    }

    /**************************************************************************/
    public function reportCredicard()
    {
        return $this->model->reportCredicard();
    }

    /**************************************************************************/
    public function reportPlatco()
    {
        return $this->model->reportPlatco();
    }

    /**************************************************************************/
    public function restoreManagement(Request $request, $id)
    {
        if ($this->service->restoreManagement($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Gestión Orden de Servicio restaurada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error en la Gestión Orden de Servicio']);
    }

    /**************************************************************************/
    public function csupportManagement(Request $request, $id)
    {
        if ($this->service->csupportManagement($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Gestión Notificación x Cambios procesada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error en la Gestión Notificación x Cambios']);
    }

    /**************************************************************************/
    public function totalStatus()
    {
        return $this->model->totalStatus();
    }

    /**************************************************************************/
    public function posted($id)
    {
        $data = $this->model->find($id);

        return view('operations::orders.posted', ['identity' => 'Gestión Entrega Punto de Venta Cliente', 'data' => $data]);
    }

    /**************************************************************************/
    public function pdf($id)
    {
        return $this->model->pdf((int) $id);
    }

    /**************************************************************************/
    public function managePosted(Request $request, $id)
    {
        if (!$data = $this->transfer->posted($request, (int) $id)) {
            toastr()->error('Error en la Gestión de Entrega x Despacho a Cliente');

            return redirect()->back();
        }
        toastr()->info('La Gestión de de Despacho se realizo Correctamente');

        return redirect()->to('/orders/office');
    }
}
