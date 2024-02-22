<?php

namespace App\Modules\Operations\Repositories\Service;

use App\Modules\Operations\Repositories\DashboardInterface;
use App\Modules\Operations\Repositories\OrderInterface;
use App\Modules\Sales\Repositories\ContractInterface;
use App\Modules\Supports\Repositories\CsupportInterface;
use App\Modules\Warehouses\Repositories\Assignment\AssignmentInterface;
use App\Modules\Warehouses\Repositories\SimcardInterface;
use App\Modules\Warehouses\Repositories\TerminalInterface;
use Auth;

//Events

class ServiceRepository implements ServiceInterface
{
    protected $dashboard;

    protected $order;

    protected $contract;

    protected $terminal;

    protected $simcard;

    protected $csupport;

    protected $assignment;

    /**
     * Repository constructor.
     *
     * @param
     */
    public function __construct(OrderInterface $order, ContractInterface $contract, TerminalInterface $terminal, SimcardInterface $simcard, DashboardInterface $dashboard, CsupportInterface $csupport, AssignmentInterface $assignment)
    {
        $this->order = $order;
        $this->contract = $contract;
        $this->terminal = $terminal;
        $this->simcard = $simcard;
        $this->dashboard = $dashboard;
        $this->csupport = $csupport;
        $this->assignment = $assignment;
    }

    public function management($request, $id)
    {
        if ($order = $this->order->update($request, $id)) {
            if ($request->type_service == 'Terminal' || $request->type_service == 'Simcard' || $request->type_service == 'OutSimcard') {
                if (! $contract = $this->contract->update($request, $request->contract_id)) {
                    return 'Error en la Gestión del Servicio al Actualizar Registro de Terminal';
                }
            }

            if ($request->type_service == 'Terminal') {
                if (! $terminal = $this->terminal->update($request, $request->terminal_id)) {
                    return 'Error en la Gestión del Servicio al Actualizar Registro de Terminal';
                }
            }

            if ($request->type_service == 'Simcard') {
                if (! $simcard = $this->simcard->update($request, $request->simcard_id)) {
                    return 'Error en la Gestión del Servicio al Actualizar Registro de Simcard';
                }
                $assignment = $this->assignment->model->where('simcard_id', '=', $request['simcard_id'])->first();
                if ($assignment) {
                    $assignment->update(['status' => 'D', 'user_updated_id' => Auth::user()->id]);
                }
            }

            return 'La Gestión de Orden de Servicio fue procesada Correctamente';
        }

        return false;
    }

    /************************************************************************/
    /************************************************************************/
    public function restoreManagement($request, $id)
    {
        $contract = $this->contract->search($request['contract_id']);
        if ($contract) {
            if ($request['type_support'] == 'restore') {
                if ($this->terminal->restore($contract->terminal_id)) {
                }
            }

            if ($request['type_support'] == 'simcard' || $request['type_support'] == 'restore') {
                if ($this->simcard->restore($contract->simcard_id)) {
                }
            }

            if ($result = $this->contract->restoreManagement($request, $request['contract_id'])) {
                return $this->order->update($request, $id);
            }
        }

        return false;
    }

    /************************************************************************/
    /************************************************************************/
    public function csupportManagement($request, $id)
    {
        if ($csupport = $this->csupport->findContract($request['contract_id'])) {
            if ($result = $this->csupport->update($request, (int) $csupport['id'])) {
                $request['csupport_id'] = (int) $csupport['id'];

                return $this->order->update($request, $id);
            }
        }

        return false;
    }
}
