<?php

namespace App\Modules\Operations\Repositories\Service;

interface ServiceInterface
{
    public function management($request, $id);

    public function restoreManagement($request, $id);

    public function csupportManagement($request, $id);
}
