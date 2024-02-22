<?php

namespace App\Modules\Sales\Repositories;

interface InvoiceItemInterface
{
    public function create($request);

    public function update($request, $id);

    public function find($request);

    public function findInvoice($request, $id);

    public function statusInvoice($id);

    public function delete($id);
}
