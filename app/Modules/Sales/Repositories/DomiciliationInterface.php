<?php

namespace App\Modules\Sales\Repositories;

interface DomiciliationInterface extends RepositoryInterface
{
    public function datatable($request);

    public function download($id);

    public function downloadResponse($id);

    public function send($id);

    public function process($id);

    public function upload($request);
}
