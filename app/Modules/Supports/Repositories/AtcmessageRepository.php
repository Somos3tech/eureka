<?php

namespace App\Modules\Supports\Repositories;

use App\Modules\Parameters\Models\Atc;
use Auth;

class AtcmessageRepository implements AtcInterface
{
    protected $atcmessage;

    /**
     * AtcRepository constructor.
     *
     * @param  Atc  $atc
     */
    public function __construct(Atcmessage $atcmessage)
    {
        $this->model = $atc;
    }

    /**************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'atc_id' => $request['atc_id'],
            'message' => $request['message'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /**************************************************************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }
}
