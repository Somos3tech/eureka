<?php

namespace App\Modules\Operations\Repositories\Transfer;

use App\Modules\Operations\Repositories\OrderRepository;
use App\Modules\Sales\Repositories\ContractRepository;
use App\Modules\Warehouses\Repositories\Assignment\AssignmentRepository;
use App\Modules\Warehouses\Repositories\SimcardRepository;
use App\Modules\Warehouses\Repositories\TerminalRepository;

class TransferRepository implements TransferInterface
{
    protected $order;

    protected $assignment;

    protected $contract;

    protected $terminal;

    protected $simcard;

    public function __construct(OrderRepository $order, AssignmentRepository $assignment, ContractRepository $contract, TerminalRepository $terminal, SimcardRepository $simcard)
    {
        $this->order = $order;
        $this->assignment = $assignment;
        $this->contract = $contract;
        $this->terminal = $terminal;
        $this->simcard = $simcard;
    }

    /************************************************************************/
    public function posted($request, $id)
    {
        if ($order = $this->order->update($request, $id)) {
            if ($request->has('date') && $request['date'] != '') {
                if ($contract = $this->contract->update($request, (int) $order['contract_id'])) {
                    $request['terminal_id'] = $contract['terminal_id'];
                    $assignment_terminal = $this->assignment->updateDevice($request, 'T');
                    $terminal = $this->terminal->posted($request, (int) $contract['terminal_id']);

                    $request['simcard_id'] = $contract['simcard_id'];
                    $assignment_simcard = $this->assignment->updateDevice($request, 'S');

                    $simcard = $this->simcard->posted($request, (int) $contract['simcard_id']);
                }
            }

            return true;
        }

        return false;
    }
}
