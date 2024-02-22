<?php

namespace App\Modules\Operations\Repositories\Service;

use Auth;

class PostedOrderService implements OrderServiceInterface
{
    public function updateField($request)
    {
        if ($request['observation'] != null) {
            $observation = $request['observation'];
        } else {
            $observation = null;
        }

        if ($request['date'] != null) {
            $posted_at = $request['date'];
            $status = 'C';
        } else {
            $posted_at = null;
            $status = 'D';
        }

        if ($request['date_send'] != null) {
            $date_send = $request['date_send'];
        } else {
            $date_send = null;
        }

        return ['observ_posted' => $observation, 'type_posted' => $request['type_posted'], 'date_send' => $date_send, 'number_control' => $request['number_control'], 'status' => $status, 'user_updated_id' => Auth::user()->id, 'posted_user_id' => Auth::user()->id, 'posted_at' => $posted_at];
    }
}
