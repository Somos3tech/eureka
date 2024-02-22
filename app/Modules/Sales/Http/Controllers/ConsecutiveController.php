<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Repositories\ConsecutiveInterface;
use Illuminate\Http\Request;

class ConsecutiveController extends Controller
{
    protected $consecutive;

    public function __construct(ConsecutiveInterface $consecutive)
    {
        $this->model = $consecutive;
    }

    /**************************************************************************/
    public function destroyConsecutiveBank(Request $request)
    {
        return $this->model->destroyConsecutiveBank($request);
    }
}
