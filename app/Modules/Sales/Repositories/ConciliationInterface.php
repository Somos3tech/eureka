<?php

namespace App\Modules\Sales\Repositories;

interface ConciliationInterface
{
    public function conciliate($request, $id);

    public function reconciliate($request, $id);

    public function manage($request, $id);

    public function restore($request, $data);

    public function storeMasive($request);
}
