<?php

namespace App\Modules\Warehouses\Repositories\Assignment;

use App\Modules\Warehouses\Repositories\SimcardInterface;
use App\Modules\Warehouses\Repositories\TerminalInterface;

class ReassignRepository implements ReassignInterface
{
    protected $assignment;

    protected $terminal;

    protected $simcard;

    public function __construct(AssignmentInterface $assignment, TerminalInterface $terminal, SimcardInterface $simcard)
    {
        $this->assignment = $assignment;
        $this->terminal = $terminal;
        $this->simcard = $simcard;
    }

    /******************************Registrar***********************************/
    public function reassign($request)
    {
        $count = count($request['destino']);
        if ($assignment = $this->assignment->reassign($request)) {
            for ($i = 0; $i < $count; $i++) {
                if ($request['device'] == 'T') {
                    return $this->terminal->reassign($request, $request['destino'][$i]);
                }
                if ($request['device'] == 'S') {
                    return $this->simcard->reassign($request, $request['destino'][$i]);
                }
            }
        }

        return false;
    }
}
