<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Models\Aconsecutive;
use Auth;

class AconsecutiveRepository implements AconsecutiveInterface
{
    protected $aconsecutive;

    public function __construct(Aconsecutive $aconsecutive)
    {
        $this->model = $aconsecutive;
    }

    /************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'fechpro' => $request['fechpro'],
            'contract_id' => $request['contract_id'],
            'refere' => $request['refere'],
            'is_management' => 1,
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }
}
