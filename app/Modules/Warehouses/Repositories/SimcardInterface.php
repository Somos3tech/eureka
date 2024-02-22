<?php

namespace App\Modules\Warehouses\Repositories;

interface SimcardInterface extends RepositoryInterface
{
    public function available($request);

    public function assign($request, $action);

    public function posted($request, $id);

    public function report($request);

    public function reassign($request, $id);

    public function restoreContract($id);

    public function datatable($request);
}
