<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Http\Requests\AffiliateStoreRequest;
use App\Modules\Sales\Http\Requests\InvoiceDetailRequest;
use App\Modules\Sales\Http\Requests\ReportAffiliateRequest;
use App\Modules\Sales\Http\Requests\ServiceBankRequest;
use App\Modules\Sales\Http\Requests\ServiceReportBankRequest;
use App\Modules\Sales\Http\Requests\ServiceStoreRequest;
use App\Modules\Sales\Repositories\InvoiceMasiveInterface;
use Illuminate\Http\Request;

class InvoiceMasiveController extends Controller
{
    private $invoice_masive;

    public function __construct(InvoiceMasiveInterface $invoice_masive)
    {
        $this->masive = $invoice_masive;
    }

    /**************************************************************************/
    public function create()
    {
        return View('sales::invoices.services.create')->with('identity', 'Módulo Cobranza Servicios');
    }

    /**************************************************************************/
    public function index()
    {
        return View('sales::invoices.services.index')->with('identity', 'Dashboard Pronostico Cobranza');
    }

    /*************************Dashboard Conciliación***************************/
    public function report()
    {
        return View('sales::invoices.services.report')->with('identity', 'Generar Archivos Cobranza Servicios');
    }

    /**************************************************************************/
    public function affiliate()
    {
        return View('sales::invoices.services.affiliate')->with('identity', 'Afiliación Bancaría');
    }

    /**************************************************************************/
    public function reportInvoiceDetail()
    {
        return View('sales::invoices.services.reports.detail')->with('identity', 'Consolidado de Pagos Procesados');
    }

    /**************************************************************************/
    public function reportAffiliate()
    {
        return View('sales::invoices.services.reports.affiliate')->with('identity', 'Reporte Afiliación Bancaría');
    }

    /**************************************************************************/
    public function reportService()
    {
        return $this->masive->reportService();
    }

    /**************************************************************************/
    public function downloadBankReport(ServiceReportBankRequest $request)
    {
        return $this->masive->downloadBankReport($request);
    }

    /**************************************************************************/
    public function serviceDatatable()
    {
        return $this->masive->serviceDatatable();
    }

    /**************************************************************************/
    public function serviceStore(ServiceStoreRequest $request)
    {
        return $this->masive->serviceStore($request);
    }

    /**************************************************************************/
    public function getServiceBank(ServiceBankRequest $request)
    {
        return $this->masive->getServiceBank($request);
    }

    /**************************************************************************/
    public function affiliateStore(AffiliateStoreRequest $request)
    {
        return $this->masive->affiliateStore($request);
    }

    /**************************************************************************/
    public function affiliateResponse(Request $request)
    {
        return $this->masive->affiliateResponse($request);
    }

    /**************************************************************************/
    public function reportAffiliateResponse(Request $request)
    {
        $data = $request['data'];

        return Excel::download(new AffiliateResponseExport($data), 'Resultados Afiliación Bancaria '.date('Y-m-d').'.xlsx');
    }

    /**************************************************************************/
    public function downloadReportAffiliate(ReportAffiliateRequest $request)
    {
        return $this->masive->downloadReportAffiliate($request);
    }

    /**************************************************************************/
    public function financial()
    {
        return View('sales::invoices.services.reports.financial')->with('identity', 'Reporte Cartera Financiera');
    }

    /**************************************************************************/
    public function reportFinancial(Request $request)
    {
        return $this->masive->reportFinancial($request);
    }

    /**
     * ! Alcides Da Silva
     * * Reporte de resumen bancario solicitado por dpto de cobranza.
     */
    public function bankmovement()
    {
        return View('sales::invoices.services.reports.bankmovement')->with('identity', 'Reporte Resumen Bancario');
    }

    /**************************************************************************/
    public function reportBankMovement(Request $request)
    {
        return $this->masive->reportBankMovement($request);
    }

    /**************************************************************************/
    public function downloadInvoiceDetail(InvoiceDetailRequest $request)
    {
        return $this->masive->downloadInvoiceDetail($request);
    }

    /**************************************************************************/
    public function active()
    {
        return View('sales::invoices.services.reports.active')->with('identity', 'Reporte Cartera Activa');
    }

    /**************************************************************************/
    public function activeReport(Request $request)
    {
        return $this->masive->activeReport($request);
    }

    /**************************************************************************/
    public function demographic()
    {
        return View('sales::invoices.services.reports.demographic')->with('identity', 'Reporte Cartera Demográfica');
    }

    /**************************************************************************/
    public function demographicReport(Request $request)
    {
        return $this->masive->demographicReport($request);
    }
}
