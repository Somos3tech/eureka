<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Models\Consecutive;
use Auth;

class ConsecutiveRepository implements ConsecutiveInterface
{
    protected $consecutive;

    public function __construct(Consecutive $consecutive)
    {
        $this->model = $consecutive;
    }

    /************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'fechpro' => $request['fechpro'],
            'invoice_id' => $request['invoice_id'],
            'consecutive' => $request['consecutive'],
            'is_management' => 1,
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    public function lastDomiciliation($request)
    {
        $consecutive = $this->model->select('consecutives.consecutive as consecutive_id')
            ->where('consecutives.bank_id', $request['bank_id'])->get();
        if (isset($consecutive)) {
            $consecutive = $consecutive->last();

            return $consecutive->consecutive_id;
        }

        return false;
    }

    /************************************************************************/
    public function getConsecutiveBank($request)
    {
        return $this->model->select('consecutives.consecutive as consecutive_id')
            ->where('consecutives.bank_id', $request['bank_id'])
            ->whereNull('consecutives.is_management')
            ->get();
    }

    /************************************************************************/
    public function destroyConsecutiveBank($request)
    {
        $consecutive = $this->consecutive->model->select('consecutives.consecutive as consecutive_id')
            ->where('consecutives.bank_id', $request['bank_id'])
            ->whereNull('consecutives.is_management')
            ->get();
        if (isset($consecutive)) {
            return $consecutive->consecutive_id;
        } else {
            $result = $consecutive->delete();
            if ($result) {
                return true;
            }
        }

        return false;
    }
}
