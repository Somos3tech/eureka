<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\City;
use App\Modules\Parameters\Models\State;

class Select
{
    /****************************Select Estado*************************************/
    public static function states()
    {
        $data = State::select('description', 'id')->orderBy('description', 'ASC')->get();

        return \Response::json($data);
    }

    /****************************Select Ciudad*************************************/
    public static function cities($request)
    {
        $data = City::select('description', 'id')->where('state_id', $request->get('state'))->orderBy('description', 'ASC')->get();

        return \Response::json($data);
    }
}
