<?php

namespace App\Modules\Warehouses\Repositories\Assignment;

use App\Modules\Warehouses\Repositories\RepositoryInterface;

interface AssignmentInterface extends RepositoryInterface
{
    public function createId($data);

    public function assigned($request);

    public function reassign($request);

    public function assignedProgrammer($request);

    public function updateDevice($request, $device);

    public function deleteAssignment($type, $id);
}
