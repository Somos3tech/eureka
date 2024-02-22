<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Repositories\RaffiliateInterface;
use Illuminate\Http\Request;

class RaffiliateController extends Controller
{
    protected $raffilliate;

    public function __construct(RaffiliateInterface $raffilliate)
    {
        $this->model = $raffilliate;
    }

    /**************************************************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }
}
