<?php

namespace App\Modules\Sales\Repositories;

interface InvoiceInterface extends RepositoryInterface
{
    public function datatable($request);

    public function findInvoice($request);

    public function viewDocument($id);

    public function viewPDF($id);

    public function totalInvoice();

    public function findCustomer($id);

    public function datatableFinancing();

    public function findContract($id);

    public function findInvoiceId($id);

    public function updateSupport($request, $id);

    public function findService($request);

    public function findValid($id);
}
