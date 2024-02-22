<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Repositories\Select;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /****************************Select Estado*************************************/
    public function states()
    {
        return Select::states();
    }

    /****************************Select Ciudad*************************************/
    public function cities(Request $request)
    {
        return Select::cities($request);
    }
}
