<?php

namespace App\Modules\Sales\Repositories;

use App\Events\Invoice as InvoiceEvent;
use App\Modules\Parameters\Repositories\CurrencyValueInterface;
use App\Modules\Sales\Models\Invoice;
//Metodos de Pago
use App\Modules\Sales\Repositories\Conciliation\ConciliationFactory;
use App\Modules\Sales\Repositories\Payment\PaymentFactory;
use App\Modules\Sales\Repositories\Service\ServiceInvoiceFactory;
use Auth;

class InvoiceRepository implements InvoiceInterface
{
    protected $invoice;

    protected $currency_value;

    /*
      * InvoiceRepository constructor.
      * @param Invoice $invoice
    */

    public function __construct(Invoice $invoice, CurrencyValueInterface $currency_value)
    {
        $this->model = $invoice;
        $this->currency_value = $currency_value;
    }

    /******************************Registrar Invoice***************************/
    public function create($request)
    {
        $sum = 0;
        $paymentFactory = new PaymentFactory();
        $payment = $paymentFactory->initialize($request['pmethod_id']);
        $valid_data = $payment->pay($request);

        $request_data = [
            'customer_id' => $request['customer_id'],
            'fechpro' => $request['fechpro'] != null ? $request['fechpro'] : date('Y-m-d'),
            'rif' => $request['rif'],
            'business_name' => $request['business_name'],
            'payment_date' => date('Y-m-d'),
            'type_sale' => 'basic',
            'frec_invoice' => 'D',
            'conciliation_doc' => $request['payment_path'],
            'user_created_id' => $request['user_id'],
            'user_updated_id' => Auth::user()->id,
        ];
        $data = array_merge($valid_data, $request_data);

        if ($result = $this->model->create($data)) {
            $data = $this->totalInvoice();
            event(new InvoiceEvent($data));

            return $result;
        }

        return false;
    }

    /************************Buscar Información Invoice************************/
    public function find($id)
    {
        $model = $this->model->query();
        $data = $model->query()->salepos()->collect()->where('invoices.id', $id)->get();

        return $data;
    }

    /**************************************************************************/
    public function findValid($id)
    {
        $model = $this->model->query();
        $data = $model->query()->salepos()->where('invoices.id', $id)->get();

        return $data;
    }

    /***************************Actualizar Invoice*****************************/
    public function update($request, $id)
    {
        $model = $this->model->where('invoices.id', '=', (int) $id)->first();
        if (isset($model)) {
            $conciliationFactory = new ConciliationFactory();
            $conciliate = $conciliationFactory->initialize($request['payment_method']);
            $valid_data = $conciliate->conciliate($request);

            $request_data = [
                'user_updated_id' => Auth::user()->id,
            ];
            if ($result = $model->update(array_merge($valid_data, $request_data))) {
                $data = $this->totalInvoice();
                event(new InvoiceEvent($data));

                return $model;
            }
        }

        return false;
    }

    /*************************Datatable Invoice********************************/
    public function datatable($request)
    {
        $model = $this->model->query();
        $data = $model->query();

        if ($request->has('customer_id')) {
            $data = $data->salecustomer()
                ->addSelect(\DB::raw('(SELECT COUNT(*) FROM collections as col INNER JOIN invoices as inv ON inv.id=col.invoice_id AND inv.deleted_at IS NULL WHERE col.invoice_id=invoices.id AND col.deleted_at IS NULL) as collection_total'))
                ->where('ct.customer_id', $request['customer_id'])
                ->distinct('invoices.id')
                ->get();

            return datatables()->of($data)
                ->addColumn('actions', function ($data) {
                    $actions = '<center>';
                    if ($data->conciliation_doc != '') {
                        $actions .= '<button class="btn btn-sm btn-info" data-toggle="modal" value="'.ltrim($data->id, '0').'" OnClick="InvoiceDocument(this);" data-target=".conciliation_doc" title="Ver Documento"><i class="i-File-Cloud"></i></button>&nbsp;';
                    }
                    if ($data->tipnot == 'Financiamiento' || $data->tipnot == 'Convenio' || $data->tipnot == 'Parcial' || $data->tipnot == 'DTEP') {
                        $actions .= '<button class="btn btn-sm btn-dark" type="button" data-toggle="modal" data-target="#showInvoiceItem" onclick="showInvoiceItem(this)" value="'.ltrim($data->id, '0').'" title="Información Cobro"><i class="i-Info"></i></button>&nbsp;';
                    }
                    if ($data->collection_total > 0) {
                        $actions .= '<button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#collectionsView" onclick="collectionsShow(this)" value="'.ltrim($data->id, '0').'" title="Ver Detalles de Cobro"><i class="i i-Coin"></i></button>&nbsp;';
                    }
                    if ($data->collection_total == 0 && $data->conciliation_doc == null) {
                        $actions .= '----';
                    }

                    $actions .= '</center>';

                    return $actions;
                })->rawColumns(['affiliate_number', 'status', 'actions'])
                ->toJson();
        }

        if ($request['action'] == 'postpago') {
            $data->where('invoices.tipnot', 'NOT LIKE', ['Financiamiento']);
        } elseif ($request['action'] == 'financing') {
            $data->where('invoices.tipnot', 'LIKE', ['Financiamiento']);
        }

        if ($request['status'] == 'C') {
            $data->whereIn('invoices.status', ['C', 'P']);
        } elseif ($request['status'] == 'P') {
            $data->where('invoices.status', '=', 'P');
        } else {
            $data->where('invoices.status', '=', 'G');
        }

        $data = $data->salepos()->distinct('invoices.id')->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                $actions .= '<a class="btn btn-sm btn-warning"  target="_blank" style="color:white;" href="/customers/'.(int) $data->customer_id.'" title="Ver Información Cliente"><i class="i i-Find-User"></i></a>';
                $actions .= '<button class="btn btn-sm btn-info" data-toggle="modal" value="'.$data->id.'"  OnClick="InvoiceId(this);" data-target="#showInvoice"  title="Información Cobro"><i class="i i-Information"></i></button>';
                if (auth()->user()->can('collections.create')) {
                    if ($data->total_support == 0) {
                        if ($data->status_invoice == 'G') {
                            if (((intval($data->amount_total) - intval($data->invoice_free)) == 0) || $data->tipnot == 'Postpago') {
                                $actions .= '<button class="btn btn-sm btn-success" data-toggle="modal" value="'.(int) $data->id.'|'.$data->tipnot.'|'.$data->status_invoice.'|'.(int) $data->contract_id.'"  OnClick="Conciliate(this);" data-target="#invoiceConciliate"  title="Conciliar Cobros"><i class="i i-Cash-Register"></i></button>';
                            } else {
                                $actions .= '<a href="/collections/create?invoice_id='.(int) $data->id.'&route=&view=conciliate&type_contract=&company_id=&journey_id=&invoiceitem_id=" class="btn btn-sm btn-success" title="Conciliar Cobros"><i class="i i-Financial"></i></a>';
                            }
                        } else {
                            $actions .= '<a href="/collections/create?invoice_id='.(int) $data->id.'&route=&view=conciliate&type_contract=&company_id=&journey_id=&invoiceitem_id=" class="btn btn-sm btn-success" title="Conciliar Cobros"><i class="i i-Financial"></i></a>';
                        }

                        if ($data->tipnot != 'Postpago' && $data->tipnot != 'Financiamiento') {
                            $actions .= '<button class="btn btn-sm btn-dark" data-toggle="modal" value="'.(int) $data->contract_id.'"  OnClick="changeSupport(this);" data-target="#changeSupport"  title="Solicitar Soporte Administrativo"><i class="i i-Gear" style="color:white;"></i></button>';
                        }
                    } else {
                        $actions .= '<br>En Soporte Administrativo';
                    }
                }
                $actions .= '</center>';

                return $actions;
            })
            ->addColumn('obs', function ($data) {
                if ($data->obs != null) {
                    return '<i class="ion-checkmark">'.$data->obs.'</i>';
                }

                return '---';
            })
            ->addColumn('conciliation_doc', function ($data) {
                $actions = '<center>';
                if ($data->conciliation_doc != null) {
                    $actions .= '<button class="btn btn-sm btn-danger" data-toggle="modal" value="'.$data->id.'" OnClick="InvoiceDocument(this);" data-target=".conciliation_doc" title="Ver Documento"><i class="i-File-Cloud"></i></button>&nbsp;';
                } else {
                    $actions .= '---';
                }

                $actions .= '</center>';

                return  $actions;
            })->rawColumns(['obs', 'status', 'conciliation_doc', 'actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function datatableFinancing()
    {
        $model = $this->model->query();
        $dicom = $this->currency_value->getLast();
        $dicom = str_replace(',', '', $dicom->amount);

        $data = $model->select(
            'invoices.id',
            'cs.id as customer_id',
            \DB::raw("LPAD(invit.id,7,'0')  as invoiceitem_id"),
            'invoices.created_at',
            'cs.rif',
            \DB::raw("(CASE WHEN(ct.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN(ct.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' ELSE 'MultiComercio' END) AS type_dcustomer"),
            \DB::raw("(CASE WHEN(ct.type_dcustomer = 'commerce') THEN dc.affiliate_number WHEN(ct.type_dcustomer = 'nodom') THEN dc.affiliate_number ELSE ct.dcustomer_multiple END) AS affiliate_number"),
            'cs.business_name',
            'cp.description as company',
            \DB::raw("(CASE WHEN (bk.description IS NULL) THEN '---' ELSE bk.description END) as bank"),
            \DB::raw("CONCAT(mt.description,'|',marks.description) as modelterminal"),
            'invoices.tipnot',
            'invoices.quota',
            'cu.abrev',
            \DB::raw('FORMAT(invoices.amount,2) amount'),
            \DB::raw('FORMAT(invoices.amount_currency,2) dicom'),
            \DB::raw('(FORMAT(invoices.amount*invoices.amount_currency,2)) as total_amount'),
            'invoices.status',
            \DB::raw('FORMAT(invit.amount,2) amount_quota'),
            \DB::raw("FORMAT($dicom,2) as dicom_new"),
            \DB::raw('(FORMAT(invit.amount*'.$dicom.',2)) as total_quota'),
            \DB::raw("(SELECT COUNT(*) FROM invoiceitems as invit1 WHERE invit1.invoice_id=invoices.id AND status LIKE 'P' AND invit1.item IS NOT NULL) as pending"),
            \DB::raw("(SELECT COUNT(*) FROM invoiceitems as invit1 WHERE invit1.invoice_id=invoices.id AND status LIKE 'C' AND invit1.item IS NOT NULL) as success"),
            \DB::raw('(FORMAT(invit.amount,2)) as amount_quota'),
            \DB::raw("FORMAT((invit.amount*$dicom),2) as total_quota"),
            \DB::raw("(CASE WHEN (invit.item IS NULL) THEN '----' ELSE invit.item END) as item"),
            'invoices.contract_id'
        )
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'invoices.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('invoiceitems as invit', function ($join) {
                $join->on('invit.invoice_id', '=', 'invoices.id');
                $join->whereIn('invit.status', ['P']);
                $join->whereNull('invit.deleted_at');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'ct.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
                $join->whereNull('bk.deleted_at');
            })
            ->leftjoin('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 'ct.modelterminal_id');
                $join->whereNull('mt.deleted_at');
            })
            ->leftjoin('marks', function ($join) {
                $join->on('marks.id', '=', 'mt.mark_id');
                $join->whereNull('marks.deleted_at');
            })
            ->leftjoin('companies as cp', function ($join) {
                $join->on('cp.id', '=', 'ct.company_id');
                $join->whereNull('cp.deleted_at');
            })
            ->leftjoin('currencies as cu', function ($join) {
                $join->on('cu.id', '=', 'invoices.currency_id');
                $join->whereNull('cu.deleted_at');
            })
            ->whereIn('invoices.tipnot', ['Parcial', 'Financiamiento', 'Convenio'])
            ->where('invoices.status', 'LIKE', 'P')
            ->get();

        return datatables()->of($data)
            ->editColumn('affiliate_number', function ($data) {
                return '<center>'.$data->affiliate_number.'</center>';
            })
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                $actions .= '<a class="btn btn-sm btn-secondary"  href="/customers/'.(int) $data->customer_id.'" title="Ver Información Cliente"><i class="i-user"></i></a>&nbsp;';
                if ($data->conciliation_doc != '') {
                    $actions .= '<button class="btn btn-sm btn-dark" data-toggle="modal" value="'.(int) $data->id.'" OnClick="InvoiceDocument(this);" data-target=".conciliation_doc" title="Ver Documento"><i class="i-File-Cloud"></i></button>&nbsp;';
                }
                if ($data->tipnot == 'Financiamiento') {
                    $actions .= '<button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#showInvoice" onclick="InvoiceId(this)" value="'.(int) $data->id.'" title="Información Cobro"><i class="ion-information-circled"></i></button>';
                }
                if (auth()->user()->can('collections.create')) {
                    $actions .= '<a href="/collections/create?invoice_id='.(int) $data->id.'&route=financing&view=conciliate&type_contract=&company_id=&journey_id=&invoiceitem_id='.(int) $data->invoiceitem_id.'" class="btn btn-sm btn-success" title="Conciliar Cobros"><i class="fa fa-check-square-o"></i></a>&nbsp;';
                }
                $actions .= '</center>';

                return $actions;
            })
            ->rawColumns(['affiliate_number', 'status', 'actions'])
            ->toJson();
    }

    /***************************Eliminar Invoice*******************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;

        if ($model->update()) {
            if ($model->delete()) {
                $data = $this->totalInvoice();
                event(new InvoiceEvent($data));

                return true;
            }
        }

        return false;
    }

    /*************************Buscar Información Pagos*************************/
    public function findCustomer($id)
    {
        $data = $this->model->select('cl.id as id', \DB::raw("LPAD(cl.invoice_id,6,'0') as refere"), \DB::raw("DATE_FORMAT(invoices.fechpro, '%d/%m/%Y') AS fechpro"), \DB::raw("(CASE WHEN (invoices.id IS NULL) THEN NULL ELSE 'COB' END) as type_register"), \DB::raw("CONCAT('COBRO - ',cp.description) as concept"), \DB::raw('FORMAT(invoices.amount,2) as amount_inv'), \DB::raw('FORMAT(cl.amount,2) as total'))
            ->join('collections as cl', function ($join) {
                $join->on('cl.invoice_id', '=', 'invoices.id');
                $join->whereNull('cl.deleted_at');
            })
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'invoices.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('billings', function ($join) {
                $join->on('billings.customer_id', '=', 'cs.id');
                $join->whereNull('billings.deleted_at');
            })
            ->join('concepts as cp', 'cp.id', '=', 'invoices.concept_id')
            ->where('cs.id', '=', $id)
            ->groupBy('id')
            ->get();

        return $data;
    }

    /************************Buscar Información Invoice************************/
    public function findContract($id)
    {
        $model = $this->model->query();

        return $model->where('invoices.contract_id', $id)->get();
    }

    /************************Buscar Información Invoice************************/
    public function findInvoiceId($id)
    {
        $model = $this->model->query();
        $data = $model->select(
            'cs.id as customer_id',
            'cs.rif',
            'cs.business_name',
            'invoices.id',
            'ct.id as contract_id',
            'invoices.status',
            'invoices.status as status_invoice',
            'invoices.fechpro',
            'invoices.payment_date',
            'com.description as company',
            \DB::raw("(CASE WHEN (ct.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN (ct.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' WHEN (ct.type_dcustomer = 'multicommerce') THEN 'MultiComercio' ELSE '----' END) type_dcustomer"),
            'mt.description as modelterminal',
            'invoices.tipnot',
            'invoices.refere',
            'cu.abrev as currency',
            'invoices.currency_id as currency_id',
            \DB::raw('FORMAT(invoices.amount,2) as amount'),
            \DB::raw('FORMAT(invoices.free,2) as free'),
            \DB::raw('FORMAT(invoices.amount_currency,2) as dicom'),
            \DB::raw("(CASE WHEN (invoices.conciliation_doc IS  NULL) THEN '----' ELSE 'Documento Adjunto' END) attachment"),
            'invoices.conciliation_doc'
        )
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'invoices.contract_id');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
            })
            ->leftjoin('companies as com', function ($join) {
                $join->on('com.id', '=', 'ct.company_id');
            })
            ->leftjoin('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 'ct.modelterminal_id');
            })
            ->leftjoin('currencies as cu', function ($join) {
                $join->on('cu.id', '=', 'invoices.currency_id');
            })
            //  ->invoiceitemt()
            ->collectiont()
            ->where('invoices.id', '=', $id)
            ->first();

        return $data;
    }

    /************************Buscar Información Invoice************************/
    public function findInvoice($request)
    {
        $model = $this->model->query();
        $model->query()->salepos()->where('invoices.id', $request['invoice_id']);

        if ($request['view'] == 'reconciliate') {
            $model->where('invoices.status', '=', 'C');
        } else {
            $model->whereIn('invoices.status', ['G', 'P']);
        }

        return $model->get();
    }

    /**************************************************************************/
    public function findService($request)
    {
        if (($request->has('type_operation') && $request['type_operation'] != '') && ($request->has('contract_id') && $request['contract_id'] != '')) {
            $model = $this->model->query();
            $model->select(
                'invoices.id as invoice_id',
                'invoices.fechpro',
                'invoices.refere',
                'invoices.status',
                \DB::raw("'Servicio Transaccional' as type_invoice"),
                'invoices.refere',
                'invoices.amount',
                \DB::raw('(SELECT ROUND(SUM(collections.amount),1) FROM collections INNER JOIN invoices as inv1 ON inv1.id=collections.invoice_id AND inv1.deleted_at IS NULL INNER JOIN contracts as ct1 ON ct1.id=inv1.contract_id AND ct1.deleted_at WHERE collections.invoice_id=invoices.id AND ct1.id='.$request['contract_id'].') as collection_amount')
            )
                ->join('contracts as ct', function ($join) {
                    $join->on('ct.id', '=', 'invoices.contract_id');
                });
            if ($request['type_operation'] == 'reverso') {
                $model->whereIn('invoices.status', ['E', 'C']);
            } elseif ($request['type_operation'] == 'credito' || $request['type_operation'] == 'anulacion' || $request['type_operation'] == 'exoneracion') {
                $model->whereIn('invoices.status', ['P', 'R', 'G']);
            }

            return $model->where('invoices.concept_id', '=', 2)->where('invoices.contract_id', $request['contract_id'])->get()->toArray();
        }

        return $data = [];
    }

    /**************************************************************************/
    public function receiptLast($request)
    {
        $model = $this->model->query();
        $query = $model->query()->salepos()->where('ct.journey_id', $request['journey_id'])->latest()->first();

        if ($query) {
            $data = $query['receipt_id'] + 1;

            return $data;
        }

        return 1;
    }

    /**************************************************************************/
    public function validReceipt($request)
    {
        if ($request['type_contract'] == 'journey') {
            $data = $this->receiptLast($request);

            return $data;
        }

        return null;
    }

    /**************************Actualizar Invoice******************************/
    public function updateSupport($request, $id)
    {
        $model = $this->model->findOrfail((int) $id);

        $serviceFactory = new ServiceInvoiceFactory();
        $service = $serviceFactory->initialize($request['type_service']);
        $valid_data = $service->support($request);

        $request_data = [
            'user_updated_id' => Auth::user()->id,
        ];
        if ($result = $model->update(array_merge($valid_data, $request_data))) {
            return $model;
        }

        return false;
    }

    /****************Visualizar Documento de Soporte de Pago*******************/
    public function viewDocument($id)
    {
        $model = $this->model->select('rif', 'conciliation_doc')->where('id', '=', (int) $id)->first();

        $path = storage_path('customers/'.$model->rif.'/').$model->conciliation_doc;

        return \Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$model->conciliation_doc.'"',
        ]);
    }

    /**************************************************************************/
    public function viewPDF($id)
    {
        $data = $this->model->select('invoices.id', 'invoices.receipt_journey as receipt_id', 'jr.description as journey', 'invoices.fechpro', 'cs.id as customer_id', 'cs.rif', 'cs.business_name', 'mt.description as modelterminal', 'op.description as operator', 'currencies.abrev as currency', 'invoices.tipnot', \DB::raw('FORMAT(invoices.amount,2) as amount'), \DB::raw('FORMAT(invoices.free,2) as free'), \DB::raw('FORMAT((invoices.free * invoices.amount_currency),2) as free_currency'), \DB::raw('FORMAT((invoices.amount - invoices.free),2) as total'), \DB::raw('FORMAT((invoices.amount * invoices.amount_currency),2) as amount_currency'), \DB::raw('FORMAT(((invoices.amount * invoices.amount_currency) - (invoices.free * invoices.amount_currency)),2) as total_currency'))
            ->leftjoin('customers as cs', 'cs.id', 'invoices.customer_id')
            ->leftjoin('contracts as ct', 'ct.id', '=', 'invoices.contract_id')
            ->leftjoin('modelterminal as mt', 'mt.id', 'ct.modelterminal_id')
            ->leftjoin('operators as op', 'op.id', '=', 'ct.operator_id')
            ->leftjoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->leftjoin('journeys as jr', 'jr.id', '=', 'ct.journey_id')
            ->where('invoices.id', '=', $id)
            ->first();

        $pdf = \PDF::loadView('sales::invoices.pdf', $data);

        return $pdf->stream('RECIBO-'.$data->id.'.pdf');
    }

    /*****************Validar Carga Documento de Soporte de Pago***************/
    private function hasFileCustomer($request)
    {
        //verificamos arhivo si existe para cargarlo al sistema
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // generar un nombre con la extension
            $path = $request['rif'].'_rm.'.$file->getClientOriginalExtension();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path().'/customers/'.$request['rif'].'/'.$path)) {
                $result = \Storage::disk('base')->delete($path);
            }
            $result = \Storage::disk('base')->put('customers/'.$request['rif'].'/'.$path, \File::get($file));
        } else {
            $path = null;
        }

        return $path;
    }

    /**************************************************************************/
    public function totalInvoice()
    {
        $data = $this->model->where('invoices.concept_id', 1)->where('invoices.status', 'G')->get();

        return $data->count();
    }
}
