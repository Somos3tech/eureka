<?php

namespace App\Modules\Sales\Repositories;

interface InvoiceMasiveInterface
{
    public function affiliateStore($request);

    public function reportAffiliateStore($request);

    public function affiliateResponse($request);

    public function downloadBankReport($request);

    public function serviceStore($request);

    public function reportService();

    public function serviceDatatable();

    public function reportFinancial($request);

    public function activeReport($request);

    public function demographicReport($request);

    public function downloadInvoiceDetail($request);

    public function getServiceBank($request);

    public function downloadReportAffiliate($request);
}
