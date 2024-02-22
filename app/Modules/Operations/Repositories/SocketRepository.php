<?php

namespace App\Modules\Operations\Repositories;

use App\Modules\Parameters\Repositories\CurrencyValueInterface;

class SocketRepository implements SocketInterface
{
    protected $currency_vale;

    /**
     * OrderRepository constructor.
     *
     * @param  Order  $order
     */
    public function __construct(CurrencyValueInterface $currency_vale)
    { //, RoleRepository $role
        $this->currency_vale = $currency_vale;
        //  $this->role = $role;
    }

    /******************************Registrar Order***************************/
    public function totalDashboard()
    {
        return $this->currency_vale->getLast();
    }
}
