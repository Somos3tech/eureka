<?php

namespace App\Modules\Sales\Repositories\Payment;

interface PayableInterface
{
    public function pay($request);
}
