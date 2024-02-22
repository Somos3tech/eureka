<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Exports\BusinessSalesReportExport;
use App\Modules\Sales\Exports\CollectionReportExport;
use App\Modules\Sales\Exports\ConciliationReportExport;
use App\Modules\Sales\Exports\SalesReportCanceledExport;
use App\Modules\Sales\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class SaleRepository implements SaleInterface
{
    protected $contract;

    protected $invoice;

    protected $invoiceItem;

    /**
     * ContractRepository constructor.
     *
     * @param  Contract  $contract
     */
    public function __construct(ContractInterface $contract, InvoiceInterface $invoice, InvoiceItemInterface $invoiceItem)
    {
        $this->contract = $contract;
        $this->invoice = $invoice;
        $this->invoiceItem = $invoiceItem;
    }

    /******************************Registrar Contrato***************************/
    public function create($request)
    {
        if (array_key_exists('amountm', $request->all())) {
            $request['amount'] = $request['amountm'];
        }
        if ($contract = $this->contract->create($request)) {
            if ($find = $this->invoice->find($contract->id)) {
                $request['contract_id'] = $contract->id;
                if ($invoice = $this->invoice->create($request)) {
                    if ($request['payment_method'] == 'Convenio' || $request['payment_method'] == 'Parcial' || $request['payment_method'] == 'Financiamiento' || $request['payment_method'] == 'DTEP') {
                        $request['invoice_id'] = $invoice->id;
                        if ($invoiceItem = $this->invoiceItem->create($request)) {
                            return $invoice;
                        }
                    }

                    return $invoice;
                }
            }
        }

        return false;
    }

    /******************************Reporte de Ventas**************************/
    public function report($request)
    {
        ini_set('memory_limit', '8196M');
        if ($request->has('statusc') && $request['statusc'] == 'Anulado') {
            $export = new SalesReportCanceledExport($request);
        } else {
            $export = new SalesReportExport($request);
        }

        return Excel::download($export, 'Reporte Ventas '.date('Y-m-d').'.xlsx');
    }

    /******************************Reporte de Ventas**************************/
    public function reportbusiness($request)
    {
        $export = new BusinessSalesReportExport($request);

        return Excel::download($export, 'Reporte Ingeligencia de Negocios '.date('Y-m-d').'.xlsx');
    }

    /******************************Reporte de Ventas**************************/
    public function reportconciliation($request)
    {
        ini_set('memory_limit', '8196M');
        $export = new ConciliationReportExport($request);

        return Excel::download($export, 'Reporte Administración '.date('Y-m-d').'.xlsx');
    }

    /******************************Reporte de Conciliación**************************/
    public function reportCollection($request)
    {
        return Excel::download(new CollectionReportExport($request), 'Reporte Pago de Ventas '.date('Y-m-d').'.xlsx');
    }

    /*************************************************************************/
    public function upload($request)
    {
        $type_document = $request['type_document'].'_contract_'.rand();

        $path = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // generar un nombre con la extension
            $path = $request['rif'].'_'.$type_document.'.'.$file->getClientOriginalExtension();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path().'/customers/'.$request['rif'].'/'.$path)) {
                $result = Storage::disk('base')->delete('customers/'.$request['rif'].'/'.$path);
            }
            $result = Storage::disk('base')->put('customers/'.$request['rif'].'/'.$path, \File::get($file));
        }
        if ($result) {
            return $path;
        }

        return false;
    }
}
