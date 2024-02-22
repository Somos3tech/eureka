<?php

namespace App\Modules\Supports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Supports\Http\Requests\AtcmessageRequest;
use App\Modules\Supports\Repositories\AtcmessageInterface;

class AtcmessageController extends Controller
{
    protected $atcmessage;

    public function __construct(AtcmessageInterface $atcmessage)
    {
        $this->model = $atcmessage;
    }

    /**************************************************************************/
    public function store(AtcmessageRequest $request)
    {
        if (! $data = $this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Error al registrar Mensaje ATC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Mensaje ATC Creado Correctamente']);
    }

    /**************************************************************************/
    public function show($id)
    {
        return $this->model->find($id);
    }
}
