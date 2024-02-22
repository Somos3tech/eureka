<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Http\Requests\ConciliationCreateRequest;
//Repository Conciliation dentro de Modulo
use App\Modules\Sales\Repositories\ConciliationInterface;
//Request
use Illuminate\Http\Request;

class ConciliationController extends Controller
{
    private $conciliation;

    public function __construct(ConciliationInterface $conciliation)
    {
        $this->model = $conciliation;
    }

    /*********************Guardar Registro de Venta****************************/
    public function store(ConciliationCreateRequest $request)
    {
        if (! $this->model->create($request)) {
            toastr()->error('Error al registrar la Conciliación');

            return redirect()->back()->withInput();
        }
        toastr()->info('Se ha registrado Correctamente la Conciliación');

        return redirect()->back();
    }
}
