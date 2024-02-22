<?php

namespace App\Modules\Sales\Repositories;

interface StatementInterface
{
    public function getCustomer($request);

    public function statementExportPDF($request);

    public function datatableBankCustomer($request);

    public function datatableBankContractCustomer($request);

    public function getHistorialManagement($request);

    public function getInformationCustomer($request);

    public function getHistorialDomiciliationOperation($request);

    public function getHistorialDomiciliationBank($request);

    public function getTotalServiceCustomer($request);

    public function getTotalServicePending();

    public function getHistorialOperterminal($request);
}
