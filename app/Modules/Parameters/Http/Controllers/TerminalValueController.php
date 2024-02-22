<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Events\TerminalValue;
use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\TerminalValueRequest;
use App\Modules\Parameters\Http\Requests\TerminalValueUpdateRequest;
use App\Modules\Parameters\Repositories\TerminalValueInterface;
use Illuminate\Http\Request;

class TerminalValueController extends Controller
{
    private $terminal_value;

    /**
     * TerminalValueRepository constructor.
     *
     * @param  TerminalValueInterface  $terminal_value
     **/
    public function __construct(TerminalValueInterface $terminal_value)
    {
        $this->model = $terminal_value;
    }

    /******************Listado Registro Valor Precio Terminal******************/
    public function index()
    {
        return view('parameters::terminalvalues.index', ['identity' => 'Registro Valor Equipo']);
    }

    /*****************Guardar Registro Valor Precio Terminal*******************/
    public function store(TerminalValueRequest $request)
    {
        if ($this->model->create($request)) {
            $data = $this->model->getLast();
            event(new TerminalValue($data->toArray()));

            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Valor Equipo']);
    }

    /*****************Buscar Registro Valor Precio Terminal********************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /*****************Guardar Registro Valor Precio Terminal*******************/
    public function update(TerminalValueUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            $data = $this->model->getLast();
            event(new TerminalValue($data->toArray()));

            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /********************Eliminar Valor Precio Terminal************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            $data = $this->model->getLast();
            event(new TerminalValue($data->toArray()));

            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /******************Api Datable Valor Precio Terminal***********************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /******************Get Monto Valor Precio Terminal*************************/
    public function getAmount(Request $request)
    {
        return $this->model->getAmount($request);
    }

    /**************************************************************************/
    public function getLast()
    {
        return $this->model->getLast();
    }
}
