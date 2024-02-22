<?php

namespace App\Modules\Preafiliations\Repositories;

interface PreafiliationInterface extends RepositoryInterface
{
    public function documentPdf($request);

    public function validDatatable($request);

    public function tempUpload($request);

    public function upload($request);

    public function rcustomerDetail($request);

    public function updateValid($request, $id);

    public function getTotal();

    public function remove($request);

    public function support($request, $id);

    public function report($request);
}
