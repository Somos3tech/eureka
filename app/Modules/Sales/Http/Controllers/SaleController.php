<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Repositories\ContractInterface;
//Repository Sale dentro de Modulo
use App\Modules\Sales\Repositories\SaleInterface;
use Illuminate\Http\Request;

//Request

class SaleController extends Controller
{
    private $sale;

    private $contract;

    public function __construct(SaleInterface $sale, ContractInterface $contract)
    {
        $this->model = $sale;
        $this->contract = $contract;
    }

    /*************************Form Validación Cliente****************************/
    public function index()
    {
        return redirect()->to('/');
    }

    /******************Verificar - Crear Registro de Venta*********************/
    public function create()
    {
        return View('sales::sales.create', ['identity' => 'Registrar Equipo']);
    }

    /*********************Guardar Registro de Venta****************************/
    public function store(Request $request)
    {
        if (! $model = $this->model->create($request)) {
            toastr()->warning('Error al Registrar al registrar Equipo');

            return redirect()->back()->withInput();
        }
        toastr()->info('Venta de Equipo Generada Correctamente con  No. Contrato'.$request['contract_id'].' - No. Cobro:'.$model->id);

        return redirect()->to('/sales/create');
    }

    public function upload(Request $request)
    {
        return $this->model->upload($request);
    }
}
