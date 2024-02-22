<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Customers\Repositories\CustomerInterface;
use App\Modules\Sales\Exports\StatementExcelReportExport;
use App\Modules\Sales\Repositories\Operation\OperationInterface;
use App\Modules\Sales\Repositories\Operterminal\OperterminalInterface;
use App\Traits\TaskTrait;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class StatementRepository implements StatementInterface
{
    use TaskTrait;

    protected $customer;

    protected $contract;

    protected $invoice;

    protected $collection;

    protected $rcollection;

    protected $operation;

    protected $operterminal;

    public function __construct(
        ContractInterface $contract,
        InvoiceInterface $invoice,
        CollectionInterface $collection,
        CustomerInterface $customer,
        RcollectionInterface $rcollection,
        OperationInterface $operation,
        OperterminalInterface $operterminal
    ) {
        $this->customer = $customer;
        $this->contract = $contract;
        $this->invoice = $invoice;
        $this->collection = $collection;
        $this->rcollection = $rcollection;
        $this->operation = $operation;
        $this->operterminal = $operterminal;
    }

    /**************************************************************************/
    public function getCustomer($request)
    {
        if ($request->has('term')) {
            $data = $this->contract->model->select('contracts.id as id', \DB::raw("CONCAT(cs.rif,' ',cs.business_name,' Serial: ',(CASE WHEN(t.serial IS NOT NULL) THEN t.serial ELSE '----' END),' Contrato: ', contracts.id) as description"))
                ->leftjoin('customers as cs', 'cs.id', '=', 'contracts.customer_id')
                ->leftjoin('terminals as t', function ($join) {
                    $join->on('t.id', '=', 'contracts.terminal_id');
                    $join->whereNull('t.deleted_at');
                })->whereNotIn('contracts.status', ['Anulado', 'Pendiente'])
                ->where('cs.rif', 'LIKE', '%' . $request['term'] . '%')
                ->orWhere('t.serial', 'LIKE', '%' . $request['term'] . '%')
                ->orWhere('cs.business_name', 'LIKE', '%' . $request['term'] . '%')
                ->get();

            return $data;
        }

        return '[]';
    }

    /**************************************************************************/
    public function getInformationCustomer($request)
    {
        $model = $this->contract->model->select(
            \DB::raw("LPAD(cs.id,6,'0') as customer_id"),
            \DB::raw("(CASE WHEN(cs.foreign_id IS NOT NULL) THEN LPAD(cs.foreign_id,6,'0') ELSE '----' END) as foreign_id"),
            'cs.rif',
            'cs.business_name',
            \DB::raw("(CASE WHEN(cs.address IS NOT NULL) THEN cs.address ELSE '----' END) as address"),
            \DB::raw("(CASE WHEN(cs.state_id IS NOT NULL) THEN states.description ELSE '----' END) as state"),
            \DB::raw("(CASE WHEN(cs.city_id IS NOT NULL) THEN cities.description ELSE '----' END) as city"),
            \DB::raw("(CASE WHEN(cs.municipality IS NOT NULL) THEN cs.municipality ELSE '----' END) as municipality"),
            \DB::raw("(CASE WHEN(cs.postal_code IS NOT NULL) THEN cs.postal_code ELSE '----' END) as postal_code"),
            \DB::raw("(CASE WHEN(cs.email IS NOT NULL) THEN cs.email ELSE '----' END) as email"),
            \DB::raw("(CASE WHEN(cs.mobile IS NOT NULL) THEN cs.mobile ELSE '----' END) as mobile"),
            'companies.description as company',
            \DB::raw("LPAD(contracts.id,6,'0') as contract_id"),
            't.serial as terminal',
            'contracts.nropos',
            'contracts.status as statusc',
            \DB::raw("(CASE WHEN (type_dcustomer='commerce') THEN dc.affiliate_number WHEN (type_dcustomer='nodom') THEN dc.affiliate_number ELSE 'Multicomercio' END) AS affiliate_number"),
            'dc.bank_id',
            'terms.description as term',
            \DB::raw('(terms.comission_flatrate+(terms.comission_flatrate*0.19)) as term_amount'),
            'mt.description as modelterminal',
            \DB::raw("DATE_FORMAT(contracts.created_at,'%Y-%m-%d') as created"),
            \DB::raw("(CASE WHEN (type_dcustomer='commerce') THEN bk.description WHEN (type_dcustomer='nodom') THEN bk.description ELSE 'Multicomercio' END) AS bank"),
            \DB::raw("(CASE WHEN (orders.posted_at IS NULL) THEN '----' ELSE DATE_FORMAT(orders.posted_at,'%Y-%m-%d') END) AS posted"),
            \DB::raw("(CASE WHEN(op.id IS NOT NULL) THEN op.description ELSE '----' END) as operator"),
            \DB::raw("CONCAT(users.name ,' ', users.last_name) as user"),
            \DB::raw("CONCAT(cn.first_name ,' ', cn.last_name) as consultant"),
            's.serial_sim as simcard'
        )
            ->leftjoin('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('companies', 'companies.id', '=', 'contracts.company_id')
            ->leftjoin('operators as op', 'op.id', '=', 'contracts.operator_id')
            ->leftjoin('simcards as s', 's.id', '=', 'contracts.simcard_id')
            ->leftjoin('users', 'users.id', '=', 'contracts.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'contracts.consultant_id')
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'cs.city_id')
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'contracts.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->leftjoin('orders', function ($join) {
                $join->on('orders.contract_id', '=', 'contracts.id');
                $join->whereNull('orders.deleted_at');
            });

        $data = $model->whereNotIn('contracts.status', ['Anulado', 'Pendiente'])
            ->where('contracts.id', (int) $request['find'])->get();

        return $data->toArray();
    }

    /********************************Datatable*********************************/
    public function datatableBankCustomer($request)
    {
        $data = [];
        $cont = 0;
        $customer_id = '';
        $rif = '';
        $business_name = '';
        $amount_pending = 0;
        $total_pending = 0;
        $amount_collection = 0;
        $total_collection = 0;

        $invoice = $this->invoice->model->select('cs.id as customer', 'cs.rif as rif', 'cs.business_name', \DB::raw("CONCAT('C') as type"), \DB::raw('COUNT(*) as total'), \DB::raw('SUM(invoices.amount) AS amount'), 'invoices.status AS status_invoice')
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'invoices.customer_id');
                $join->whereNull('cs.deleted_at');
            })->where('invoices.concept_id', 2)
            ->whereIn('invoices.status', ['G', 'C'])->groupBy('invoices.rif')->get();

        $collection = $this->collection->model->select('cs.id as customer', 'cs.rif as rif', 'cs.business_name', \DB::raw("CONCAT('P') as type"), \DB::raw('COUNT(*) as total'), \DB::raw('SUM(collections.amount) AS amount'), 'invoices.status AS status_invoice')
            ->join('invoices', function ($join) {
                $join->on('invoices.id', '=', 'collections.invoice_id');
                $join->where('invoices.status', 'LIKE', 'C');
                $join->where('invoices.concept_id', 2);
                $join->whereNull('invoices.deleted_at');
            })->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'invoices.customer_id');
                $join->whereNull('cs.deleted_at');
            })->whereNull('collections.deleted_at')->groupBy('invoices.rif')->get();

        $array = array_merge($invoice->toArray(), $collection->toArray());
        sort($array);

        foreach ($array as $value) {
            if ($customer_id == '' || ($customer_id == $value['customer'])) {
                $customer_id = (int) $value['customer'];
                $data[$cont]['customer_id'] = $value['customer'];
                $data[$cont]['rif'] = $value['rif'];
                $data[$cont]['business_name'] = $value['business_name'];

                if ($value['type'] == 'C') {
                    $data[$cont]['amount_pending'] = $value['amount'];
                    $data[$cont]['total_pending'] = $value['total'];
                    $data[$cont]['amount_collection'] = isset($data[$cont]['amount_collection']) ? $data[$cont]['amount_collection'] : '0.00';
                    $data[$cont]['total_collection'] = isset($data[$cont]['total_collection']) != '' ? $data[$cont]['total_collection'] : '';
                } elseif ($value['type'] == 'P') {
                    $data[$cont]['amount_pending'] = isset($data[$cont]['amount_pending']) ? $data[$cont]['amount_pending'] : '0.00';
                    $data[$cont]['total_pending'] = isset($data[$cont]['total_pending']) ? $data[$cont]['total_pending'] : '';
                    $data[$cont]['amount_collection'] = $value['amount'];
                    $data[$cont]['total_collection'] = $value['total'];
                }
            } else {
                $cont++;
                $customer_id = (int) $value['customer'];
                $data[$cont]['customer_id'] = $value['customer'];
                $data[$cont]['rif'] = $value['rif'];
                $data[$cont]['business_name'] = $value['business_name'];

                $data[$cont]['amount_pending'] = 0;
                $data[$cont]['total_pending'] = 0;
                $data[$cont]['amount_collection'] = 0;
                $data[$cont]['total_collection'] = 0;

                if ($value['type'] == 'C') {
                    $data[$cont]['amount_pending'] = $value['amount'];
                    $data[$cont]['total_pending'] = $value['total'];
                    $data[$cont]['amount_collection'] = isset($data[$cont]['amount_collection']) ? $data[$cont]['amount_collection'] : '0.00';
                    $data[$cont]['total_collection'] = isset($data[$cont]['total_collection']) != '' ? $data[$cont]['total_collection'] : '0';
                } elseif ($value['type'] == 'P') {
                    $data[$cont]['amount_pending'] = isset($data[$cont]['amount_pending']) ? $data[$cont]['amount_pending'] : '0.00';
                    $data[$cont]['total_pending'] = isset($data[$cont]['total_pending']) ? $data[$cont]['total_pending'] : '0';
                    $data[$cont]['amount_collection'] = $value['amount'];
                    $data[$cont]['total_collection'] = $value['total'];
                }
            }
        }

        return datatables()->of(Collect($data))
            ->addColumn('actions', function ($data) {
                $actions = '<button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                                     </button><div class="dropdown-menu" x-placement="bottom-start">';
                $actions .= '<a class="dropdown-item" href="#"  data-toggle="modal" data-target="#contractsStatement" onclick="statementCustomer(' . $data['customer_id'] . ')"  title="Información Estado Cuenta">Ver Información Contratos</a>';
                $actions .= '<a class="dropdown-item" href="/statements/datatableBankContractCustomer?type=&customer_id=' . (int) $data['customer_id'] . '" title="Descargar Estado de Cuenta x Cliente">Descargar PDF</a>';
                $actions .= '</div>';

                return $actions;
            })->editColumn('amount_pending', function ($data) {
                return '$. ' . number_format($data['amount_pending'] != '' ? $data['amount_pending'] : '0.00', 2, ',', '.');
            })
            ->editColumn('amount_collection', function ($data) {
                return '$. ' . number_format($data['amount_collection'] != '' ? $data['amount_collection'] : '0.00', 2, ',', '.');
            })
            ->editColumn('balance', function ($data) {
                return '$. ' . number_format(($data['amount_pending'] != '' ? $data['amount_pending'] : '0.00') - ($data['amount_collection'] != '' ? $data['amount_collection'] : '0.00'), 2, ',', '.');
            })
            ->editColumn('total_pending', function ($data) {
                return $data['total_pending'] != '' ? $data['total_pending'] : 0;
            })
            ->editColumn('total_collection', function ($data) {
                return $data['total_collection'] != '' ? $data['total_collection'] : 0;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function datatableBankContractCustomer($request)
    {
        $data = [];
        $cont = 0;
        $contract_id = '';

        $invoice = $this->invoice->model->select(\DB::raw("LPAD(invoices.contract_id,8,'0') AS contract_id"), 'cs.id as customer_id', 'cs.rif as rif', 'cs.business_name', \DB::raw("CONCAT('C') as type"), 'terms.abrev as term_name', \DB::raw("(CASE WHEN (terminals.serial IS NULL) THEN '----' ELSE terminals.serial END) as serial"), 'banks.description as bank_name', \DB::raw('COUNT(*) as total'), \DB::raw('SUM(invoices.amount) AS amount'), 'invoices.status AS status_invoice', 'contracts.status AS status_contract')
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'invoices.customer_id');
                $join->whereNull('cs.deleted_at');
            })->join('contracts', function ($join) {
                $join->on('contracts.id', '=', 'invoices.contract_id');
                $join->whereNull('contracts.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('banks', function ($join) {
                $join->on('banks.id', '=', 'dc.bank_id');
            })
            ->leftjoin('terminals', function ($join) {
                $join->on('terminals.id', '=', 'contracts.terminal_id');
                $join->whereNull('terminals.deleted_at');
            })->leftjoin('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
                $join->whereNull('terms.deleted_at');
            });
        if ($request->has('customer_id')) {
            $invoice->where('invoices.customer_id', (int) $request['customer_id']);
        }
        $invoice = $invoice->where('invoices.concept_id', 2)->whereIn('invoices.status', ['G', 'C'])->groupBy('invoices.contract_id')->distinct()->get();

        $collection = $this->collection->model->select(\DB::raw("LPAD(invoices.contract_id,8,'0') AS contract_id"), 'cs.id as customer_id', 'cs.rif as rif', 'cs.business_name', \DB::raw("CONCAT('P') as type"), 'terms.abrev as term_name', \DB::raw("(CASE WHEN (terminals.serial IS NULL) THEN '-----' ELSE terminals.serial END) as serial"), 'banks.description as bank_name', \DB::raw('COUNT(*) as total'), \DB::raw('SUM(collections.amount) AS amount'), 'invoices.status AS status_invoice', 'contracts.status AS status_contract')
            ->join('invoices', function ($join) {
                $join->on('invoices.id', '=', 'collections.invoice_id');
                $join->where('invoices.status', 'LIKE', 'C');
                $join->where('invoices.concept_id', 2);
                $join->whereNull('invoices.deleted_at');
            })->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'invoices.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('contracts', function ($join) {
                $join->on('contracts.id', '=', 'invoices.contract_id');
                $join->whereNull('contracts.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('banks', function ($join) {
                $join->on('banks.id', '=', 'dc.bank_id');
            })
            ->leftjoin('terminals', function ($join) {
                $join->on('terminals.id', '=', 'contracts.terminal_id');
                $join->whereNull('terminals.deleted_at');
            })->leftjoin('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
                $join->whereNull('terms.deleted_at');
            })->whereNull('collections.deleted_at');
        if ($request->has('customer_id')) {
            $collection->where('invoices.customer_id', (int) $request['customer_id']);
        }

        $collection = $collection->groupBy('invoices.contract_id')->distinct()->get();

        $array = array_merge($invoice->toArray(), $collection->toArray());
        asort($array);

        foreach ($array as $value) {
            if ($contract_id == '' || ($contract_id == (int) $value['contract_id'])) {
                $contract_id = $value['contract_id'];
                $data[$cont]['customer_id'] = (int) $value['customer_id'];
                $data[$cont]['contract_id'] = $value['contract_id'];
                $data[$cont]['rif'] = $value['rif'];
                $data[$cont]['business_name'] = $value['business_name'];
                $data[$cont]['bank_name'] = $value['bank_name'];
                $data[$cont]['terminal'] = $value['serial'];
                $data[$cont]['term_name'] = $value['term_name'];
                $data[$cont]['status'] = $value['status_contract'];

                if ($value['type'] == 'C') {
                    $data[$cont]['amount_pending'] = number_format($value['amount'], 2, '.', ',');
                    $data[$cont]['total_pending'] = $value['total'];
                    $data[$cont]['amount_collection'] = isset($data[$cont]['amount_collection']) ? $data[$cont]['amount_collection'] : '0.00';
                    $data[$cont]['total_collection'] = isset($data[$cont]['total_collection']) != '' ? $data[$cont]['total_collection'] : '';
                } elseif ($value['type'] == 'P') {
                    $data[$cont]['amount_pending'] = isset($data[$cont]['amount_pending']) ? $data[$cont]['amount_pending'] : '0.00';
                    $data[$cont]['total_pending'] = isset($data[$cont]['total_pending']) ? $data[$cont]['total_pending'] : '';
                    $data[$cont]['amount_collection'] = number_format($value['amount'], 2, '.', ',');
                    $data[$cont]['total_collection'] = $value['total'];
                }
            } else {
                $cont++;
                $contract_id = $value['contract_id'];
                $data[$cont]['customer_id'] = (int) $value['customer_id'];
                $data[$cont]['contract_id'] = $value['contract_id'];
                $data[$cont]['rif'] = $value['rif'];
                $data[$cont]['business_name'] = $value['business_name'];
                $data[$cont]['bank_name'] = $value['bank_name'];
                $data[$cont]['term_name'] = $value['term_name'];
                $data[$cont]['terminal'] = $value['serial'];
                $data[$cont]['status'] = $value['status_contract'];

                $data[$cont]['amount_pending'] = '';
                $data[$cont]['total_pending'] = '';
                $data[$cont]['amount_collection'] = '';
                $data[$cont]['total_collection'] = '';

                if ($value['type'] == 'C') {
                    $data[$cont]['amount_pending'] = number_format($value['amount'], 2, '.', ',');
                    $data[$cont]['total_pending'] = $value['total'];
                    $data[$cont]['amount_collection'] = isset($data[$cont]['amount_collection']) ? $data[$cont]['amount_collection'] : '0.00';
                    $data[$cont]['total_collection'] = isset($data[$cont]['total_collection']) != '' ? $data[$cont]['total_collection'] : '';
                } elseif ($value['type'] == 'P') {
                    $data[$cont]['amount_pending'] = isset($data[$cont]['amount_pending']) ? $data[$cont]['amount_pending'] : '0.00';
                    $data[$cont]['total_pending'] = isset($data[$cont]['total_pending']) ? $data[$cont]['total_pending'] : '';
                    $data[$cont]['amount_collection'] = number_format($value['amount'], 2, '.', ',');
                    $data[$cont]['total_collection'] = $value['total'];
                }
            }
        }

        if (!$request->has('type')) {
            return datatables()->of(Collect($data))
                ->addColumn('actions', function ($data) {
                    $actions = '<button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                                         </button><div class="dropdown-menu" x-placement="bottom-start">';
                    $actions .= '<a class="dropdown-item" href="/statements/detailCustomer?contract_id=' . (int) $data['contract_id'] . '"  title="Información Estado Cuenta - Contrato">Ver Información Contrato</a>';
                    $actions .= '<a class="dropdown-item" href="/statements/export?contract_id=' . $data['contract_id'] . '" title="Descargar Estado de Cuenta">Descargar PDF</a>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->editColumn('amount_pending', function ($data) {
                    return '$. ' . number_format($data['amount_pending'], 2, ',', '.');
                })->editColumn('amount_collection', function ($data) {
                    return '$. ' . number_format($data['amount_collection'] != '' ? $data['amount_collection'] : '0.00', 2, ',', '.');
                })
                ->editColumn('balance', function ($data) {
                    return '$. ' . number_format($data['amount_pending'] - ($data['amount_collection'] != '' ? $data['amount_collection'] : '0.00'), 2, ',', '.');
                })->editColumn('total_collection', function ($data) {
                    return $data['total_collection'] != '' ? $data['total_collection'] : 0;
                })
                ->editColumn('status', function ($data) {
                    return $this->statusBadge($data['status']);
                })->rawColumns(['actions', 'status'])
                ->toJson();
        }
        $customer = $this->contract->model->select('customers.rif', 'customers.business_name', 'customers.address', \DB::raw("CONCAT('+58 ',replace(ltrim(replace(customers.mobile,'0',' ')),' ','0')) AS mobile"), 'mt.description as modelterminal', 't.serial as terminal', 'terms.abrev as term', 'terms.comission_flatrate as rate', \DB::raw("(CASE WHEN (terms.type_invoice='D') THEN 'Diario' WHEN (terms.type_invoice='M') THEN 'Mensual' WHEN (terms.type_invoice='Q') THEN 'Quincenal' ELSE '---' END) AS type_invoice"))->join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 't.modelterminal_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->where('customers.id', (int) $request['customer_id'])
            ->first();

        $pdf = \PDF::loadView('sales::statements.export-customer', ['data' => $data, 'customer' => $customer])
            ->setOptions([
                'enable_remote' => true,
                'chroot' => public_path(),
            ]);

        return $pdf->download('Estado de Cuenta_' . $customer['rif'] . '.pdf');
    }

    /**************************************************************************/
    public function getHistorialManagement($request)
    {
        $data = [];
        $invoice = $this->invoice->model->select(
            \DB::raw("(CASE WHEN (invoices.status='E') THEN 'Exonerado' ELSE CONCAT('----') END) AS collection_id"),
            \DB::raw("LPAD(invoices.id,8,'0') AS id"),
            \DB::raw("(CASE WHEN (invoices.status='E') THEN CONCAT('E') ELSE CONCAT('C') END) AS type_abrev"),
            \DB::raw("DATE_FORMAT(invoices.fechpro, '%d-%m-%Y') as date"),
            \DB::raw("CONCAT('Cobro Servicios Vepagos') AS type"),
            'invoices.refere',
            'invoices.amount',
            \DB::raw("(CASE WHEN(collections.id IS NOT NULL) THEN collections.dicom ELSE '----' END) AS dicom"),
            \DB::raw("(CASE WHEN(collections.id IS NOT NULL) THEN collections.amount_currency ELSE '----' END) AS amount_currency")
        )
            ->leftjoin('collections', 'collections.invoice_id', '=', 'invoices.id')
            ->where('invoices.contract_id', (int) $request['contract_id'])
            ->where('invoices.concept_id', 2)
            ->whereIn('invoices.status', ['G', 'P', 'C', 'R', 'E', 'N'])
            ->whereNull('collections.deleted_at')
            ->get();

        if (isset($invoice)) {
            $data = array_merge($data, $invoice->toArray());
        }

        $collection = $this->collection->model->select('invoices.id as id', \DB::raw("CONCAT('P') AS type_abrev"), \DB::raw("LPAD(collections.id,6,'0') AS collection_id"), \DB::raw("DATE_FORMAT(collections.fechpro, '%d-%m-%Y') as date"), \DB::raw("CONCAT('Pago - Cargo Cuenta Cliente - No. Cobro: ',LPAD(invoices.id,8,'0')) AS type"), 'collections.refere', 'collections.amount', 'collections.dicom', 'collections.amount_currency')
            ->join('invoices', 'invoices.id', '=', 'collections.invoice_id')->where('invoices.contract_id', (int) $request['contract_id'])->where('invoices.concept_id', 2)->whereNull('collections.deleted_at')->get();
        if (isset($invoice)) {
            $data = array_merge($data, $collection->toArray());
        }

        usort($data, function (array $elem1, $elem2) {
            return $elem1['id'] <=> $elem2['id'] ?:
                $elem1['type'] <=> $elem2['type'];
        });

        return $data;
    }

    /**************************************************************************/
    public function getHistorialDomiciliationOperation($request)
    {
        $data = $this->operation->model->select(
            'operations.id',
            \DB::raw("DATE_FORMAT(operations.created_at,'%Y-%m-%d') as created"),
            \DB::raw("(CASE WHEN(operations.type_operation='debito') THEN 'Cobro' WHEN(operations.type_operation='credito') THEN 'Abono' WHEN(operations.type_operation='exoneracion') THEN 'Exonerado' WHEN(operations.type_operation='reverso') THEN 'Reverso Pago' ELSE '----' END) AS type_operation"),
            \DB::raw("LPAD(SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(data,'\"',''),';',4),':',-1),6,'0') AS contract_id,LPAD(SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(data,'\"',''),';',6),':',-1),6,'0') AS invoice_id,SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(data,'\"',''),';',8),':',-1) AS fechpro,SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(data,'\"',''),';',12),':',-1) AS amount"),
            'operations.observations',
            \DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(data,'\"',''),';',16),':',-1) AS observation_response")
        )
            ->where(\DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(data,'\"',''),';',4),':',-1)"), 'LIKE', (int) $request['contract_id'])->whereNotNull('operations.type_operation')->get();

        return $data;
    }

    /**************************************************************************/
    public function statementExportPDF($request)
    {
        $data = [];
        $invoice = $this->invoice->model->select(
            \DB::raw('CONCAT(collections.id) AS collection_id'),
            \DB::raw("LPAD(invoices.id,8,'0') AS id"),
            \DB::raw('invoices.status AS type_abrev'),
            \DB::raw("DATE_FORMAT(invoices.fechpro, '%d-%m-%Y') as date"),
            \DB::raw("DATE_FORMAT(collections.fechpro, '%d-%m-%Y') as payment_date"),
            \DB::raw("CONCAT('Cargo - No. ',LPAD(invoices.id,8,'0')) AS type"),
            \DB::raw("(CASE WHEN (invoices.status='N') THEN CONCAT('Negociación') WHEN (invoices.status='E') THEN CONCAT('Exoneración') WHEN (collections.refere IS NULL AND invoices.refere LIKE '%Manual%') THEN CONCAT('Cargo Manual') WHEN (collections.refere like '%Manual%') THEN CONCAT('Abono Manual') ELSE CONCAT('Domiciliación') END) as refere"),
            'invoices.amount',
            \DB::raw("(CASE WHEN(collections.id IS NOT NULL) THEN collections.dicom ELSE '----' END) AS dicom"),
            \DB::raw("(CASE WHEN(collections.id IS NOT NULL) THEN collections.amount_currency ELSE '----' END) AS amount_currency")
        )
            ->leftjoin('collections', 'collections.invoice_id', '=', 'invoices.id')->where('invoices.contract_id', (int) $request['contract_id'])->where('invoices.concept_id', 2)->whereIn('invoices.status', ['G', 'P', 'C', 'R', 'E', 'N'])->whereNull('collections.deleted_at');

        if ($request->has('date') && $request['date']) {
            $invoice->where('invoices.fechpro', 'LIKE', $request['date'] . '-%');
            $previousmonth = date('Y-m', strtotime($request['date'] . '-01' . '-1 month'));
        } else {
            $previousmonth = substr(date('Y-m', strtotime('-1 month')), 0, 7);
        }
        $invoice = $invoice->orderBy('invoices.fechpro', 'ASC')->get();
        if (isset($invoice)) {
            $data = array_merge($data, $invoice->toArray());
        }
        $previousinvoice = $this->invoice->model->select(
            \DB::raw('sum(invoices.amount) as cargos'),
            \DB::raw("(select sum(invoices.amount) from invoices where invoices.contract_id = '" . (int) $request['contract_id'] . "' and invoices.concept_id = '2' and invoices.status = 'C' and invoices.fechpro LIKE '" . $previousmonth . '-%' . "') as abonos")
        )->where('invoices.contract_id', (int) $request['contract_id'])->where('invoices.concept_id', 2)->whereIn('invoices.status', ['G', 'P', 'C', 'R', 'E', 'N'])->where('invoices.fechpro', 'LIKE', $previousmonth . '-%')->first();

        // $collection = $this->collection->model->select('invoices.id as id', \DB::raw("CONCAT('P') AS type_abrev"), \DB::raw("LPAD(collections.id,6,'0') AS collection_id"), \DB::raw("DATE_FORMAT(collections.fechpro, '%d-%m-%Y') as date"), \DB::raw("CONCAT('Pago - Cargo Cta: ',LPAD(invoices.id,7,'0')) AS type"), 'collections.refere', 'collections.amount', 'collections.dicom', 'collections.amount_currency')
        //     ->join('invoices', 'invoices.id', '=', 'collections.invoice_id')->where('invoices.contract_id', (int)$request['contract_id'])->where('invoices.concept_id', 2)->whereNull('collections.deleted_at');

        // if ($request->has('date') && $request['date']) {
        //     $collection->where('invoices.fechpro', 'LIKE', $request['date'] . '-%');
        // }

        // $collection = $collection->get();
        // if (isset($collection)) {
        //     $data = array_merge($data, $collection->toArray());
        // }

        usort($data, function (array $elem1, $elem2) {
            return $elem1['id'] <=> $elem2['id'] ?:
                $elem1['type'] <=> $elem2['type'];
        });

        $customer = $this->contract->model->select('customers.rif', 'customers.business_name', 'customers.address', \DB::raw("CONCAT('+58 ',replace(ltrim(replace(customers.mobile,'0',' ')),' ','0')) AS mobile"), 'mt.description as modelterminal', 't.serial as terminal', 'terms.abrev as term', 'terms.comission_flatrate as rate', \DB::raw("(CASE WHEN (terms.type_invoice='D') THEN 'Diario' WHEN (terms.type_invoice='M') THEN 'Mensual' WHEN (terms.type_invoice='Q') THEN 'Quincenal' ELSE '---' END) AS type_invoice"))
            ->join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 't.modelterminal_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->where('contracts.id', (int) $request['contract_id'])
            ->first();
        // dd($data);
        $pdf = \PDF::loadView('sales::statements.export', ['data' => $data, 'customer' => $customer, 'previousinvoice' => $previousinvoice, 'previousmonth' => $previousmonth, 'request' => $request->all()])
            ->setOptions([
                'enable_remote' => true,
                'chroot' => public_path(),
            ]);

        return $pdf->download('Estado de Cuenta_' . $customer['rif'] . '_' . (int) $request['contract_id'] . '.pdf');
    }

    /**************************************************************************/
    public function statementExportExcel($request)
    {
        $data = [];
        $invoice = $this->invoice->model->select(
            \DB::raw('CONCAT(collections.id) AS collection_id'),
            \DB::raw("LPAD(invoices.id,8,'0') AS id"),
            \DB::raw('invoices.status AS type_abrev'),
            \DB::raw("DATE_FORMAT(invoices.fechpro, '%d-%m-%Y') as date"),
            \DB::raw("DATE_FORMAT(collections.fechpro, '%d-%m-%Y') as payment_date"),
            //\DB::raw("CONCAT('Cargo - No. ',LPAD(invoices.id,8,'0')) AS type"),
            \DB::raw("CONCAT(LPAD(invoices.id,8,'0')) AS type"),
            \DB::raw("(CASE WHEN (invoices.status='N') THEN CONCAT('Negociación') WHEN (invoices.status='E') THEN CONCAT('Exoneración') WHEN (collections.refere IS NULL AND invoices.refere LIKE '%Manual%') THEN CONCAT('Cargo Manual') WHEN (collections.refere like '%Manual%') THEN CONCAT('Abono Manual') ELSE CONCAT('Domiciliación') END) as refere"),
            'invoices.amount',
            \DB::raw("(CASE WHEN(collections.id IS NOT NULL) THEN collections.dicom ELSE '----' END) AS dicom"),
            \DB::raw("(CASE WHEN(collections.id IS NOT NULL) THEN collections.amount_currency ELSE '----' END) AS amount_currency")
        )
            ->leftjoin('collections', 'collections.invoice_id', '=', 'invoices.id')->where('invoices.contract_id', (int) $request['contract_id'])->where('invoices.concept_id', 2)->whereIn('invoices.status', ['G', 'P', 'C', 'R', 'E', 'N'])->whereNull('collections.deleted_at');

        if ($request->has('date') && $request['date']) {
            $invoice->where('invoices.fechpro', 'LIKE', $request['date'] . '-%');
            $previousmonth = date('Y-m', strtotime($request['date'] . '-01' . '-1 month'));
        } else {
            $previousmonth = substr(date('Y-m', strtotime('-1 month')), 0, 7);
        }
        $invoice = $invoice->orderBy('invoices.fechpro', 'ASC')->get();
        if (isset($invoice)) {
            $data = array_merge($data, $invoice->toArray());
        }
        $previousinvoice = $this->invoice->model->select(
            \DB::raw('sum(invoices.amount) as cargos'),
            \DB::raw("(select sum(invoices.amount) from invoices where invoices.contract_id = '" . (int) $request['contract_id'] . "' and invoices.concept_id = '2' and invoices.status = 'C' and invoices.fechpro LIKE '" . $previousmonth . '-%' . "') as abonos")
        )->where('invoices.contract_id', (int) $request['contract_id'])->where('invoices.concept_id', 2)->whereIn('invoices.status', ['G', 'P', 'C', 'R', 'E', 'N'])->where('invoices.fechpro', 'LIKE', $previousmonth . '-%')->first();
        usort($data, function (array $elem1, $elem2) {
            return $elem1['id'] <=> $elem2['id'] ?:
                $elem1['type'] <=> $elem2['type'];
        });

        $customer = $this->contract->model->select('customers.rif', 'customers.business_name', 'customers.address', \DB::raw("CONCAT('+58 ',replace(ltrim(replace(customers.mobile,'0',' ')),' ','0')) AS mobile"), 'mt.description as modelterminal', 't.serial as terminal', 'terms.abrev as term', 'terms.comission_flatrate as rate', \DB::raw("(CASE WHEN (terms.type_invoice='D') THEN 'Diario' WHEN (terms.type_invoice='M') THEN 'Mensual' WHEN (terms.type_invoice='Q') THEN 'Quincenal' ELSE '---' END) AS type_invoice"))
            ->join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 't.modelterminal_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->where('contracts.id', (int) $request['contract_id'])
            ->first();

        return Excel::download(new StatementExcelReportExport(['data' => $data, 'customer' => $customer, 'previousinvoice' => $previousinvoice, 'previousmonth' => $previousmonth, 'request' => $request->all()]), 'Estado de Cuenta_' . $customer['rif'] . '_' . (int) $request['contract_id'] . '.xlsx');
    }

    /***********************************Total**********************************/
    public function getTotalServiceCustomer($request)
    {
        $model = $this->contract->model->select('bk.id as bank_id', 'bk.id as bank_id', 'bk.description as bank_name', \DB::raw('ROUND(SUM(terms.comission_flatrate),2) as amount'), \DB::raw('count(*) as total'))
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
            })
            ->join('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
            })->where('contracts.status', 'Activo');
        if ($request->has('type_invoice') && $request['type_invoice'] != '') {
            $model->where('terms.type_invoice', 'LIKE', $request['type_invoice']);
        }

        return $model->groupBy('bank_name', 'type_invoice')->get();
    }

    /**************************************************************************/
    public function getTotalServicePending()
    {
        return $this->contract->model->select('bk.description as bank_name', \DB::raw('COUNT(*) as total'), \DB::raw('ROUND(SUM(inv.amount),2) as amount'))
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->join('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
            })
            ->join('invoices as inv', function ($join) {
                $join->on('inv.contract_id', '=', 'contracts.id');
                $join->where('inv.concept_id', 2);
                $join->whereIn('inv.status', ['G', 'P', 'R']);
            })
            ->groupBy('bank_name')
            ->get();
    }

    /**************************************************************************/
    public function getHistorialDomiciliationBank($request)
    { // Esta funcion esta provocando lentitud en el servidor
        $consec = 0;
        $data = [];

        $model = $this->rcollection->model->select(
            \DB::raw("LPAD(rcollections.id,6,'0') AS rcollection_id"),
            'rcollections.fechpro',
            'invoices.id as invoice_id',
            'invoices.fechpro as fechpro_invoice',
            'collections.id as collection_id',
            'collections.fechpro as fechpro_collection',
            'invoices.amount as amount_invoice',
            'collections.amount',
            'collections.amount_currency',
            'collections.dicom as currency',
            'rcollections.data',
            \DB::raw("(CASE WHEN (rcollections.status='X') THEN 'Error Proceso' WHEN (rcollections.status='P') THEN 'Procesado' ELSE '----' END) AS status_rcollection"),
            'rcollections.status'
        );
        if ($this->bankValidConsecutive($request['bank_id'], 'domiciliation')) {
            $model->leftjoin('consecutives', 'consecutives.consecutive', '=', 'rcollections.refere')
                ->join('invoices', 'invoices.id', '=', 'consecutives.invoice_id');
        } else {
            $model->join('invoices', 'invoices.id', '=', 'rcollections.refere');
        }

        $model->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
            ->join('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->join('banks', 'banks.id', '=', 'dc.bank_id')
            ->leftjoin('collections', 'collections.invoice_id', '=', 'invoices.id')->whereNull('collections.deleted_at');

        $array = $model->where('invoices.contract_id', $request['contract_id'])->orderBy('rcollections.refere', 'ASC')->orderBy('rcollections.fechpro', 'ASC')->get();
        if (count($array) > 0) {
            foreach ($array as $key => $value) {
                $data_array = unserialize($value['data']);
                $data[$consec]['rcollection_id'] = $value['rcollection_id'];
                $data[$consec]['fechpro_rcollection'] = $value['fechpro'];
                $data[$consec]['invoice_id'] = $value['invoice_id'];

                $date = date_create($value['fechpro_invoice']);
                $data[$consec]['fechpro'] = date_format($date, 'Y-m-d');
                $data[$consec]['descripcion_cliente'] = $data_array['descripcion_cliente'];
                $data[$consec]['status_bank'] = $data_array['status_bank'];
                $data[$consec]['motivo_del_fallido'] = $data_array['motivo_del_fallido'] != '' || $data_array['motivo_del_fallido'] != null ? $data_array['motivo_del_fallido'] : '-----';
                $data[$consec]['collection_id'] = $value['status'] != 'X' ? $value['collection_id'] : '----';
                $data[$consec]['fechpro_collection'] = $value['status'] != 'X' ? $value['fechpro_collection'] : '----';
                $data[$consec]['amount'] = $value['status'] != 'X' ? $value['amount'] : $value['amount_invoice'];
                $data[$consec]['currency'] = $value['status'] != 'X' ? $value['currency'] : ($data_array['monto'] / $value['amount_invoice']);
                $data[$consec]['amount_currency'] = $value['status'] != 'X' ? $value['amount_currency'] : $data_array['monto'];
                $data[$consec]['status'] = $value['status_rcollection'];

                $consec++;
            }
        }

        return $data;
    }

    /**************************************************************************/
    public function getHistorialOperterminal($request)
    {
        $model = $this->operterminal->model;
        $data = $model->select(
            'operterminals.fechpro',
            \DB::raw("(CASE WHEN (operterminals.type_operation='activacion') THEN 'Activación' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='definitivo') THEN 'Cancelación' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='temporal') THEN 'Suspensión' WHEN (operterminals.type_operation='cambio') THEN 'Cambio Plan' ELSE '----' END) as type"),
            DB::raw("(CASE WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='definitivo') THEN 'Definitivo' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='temporal') THEN 'Temporal' ELSE '----' END) as type_operation"),
            \DB::raw("(CASE WHEN (operterminals.serial_terminal IS NULL) THEN '----'  ELSE operterminals.serial_terminal  END) as serial_terminal"),
            \DB::raw("LPAD(operterminals.id,6,'0') AS operterminal_id"),
            DB::raw("(CASE WHEN (operterminals.type_operation='cambio' AND trm.abrev IS NOT NULL) THEN trm.abrev ELSE '----' END) as term_change"),
            DB::raw("(CASE WHEN (operterminals.type_operation='cambio' AND operterminals.term_name IS NOT NULL) THEN operterminals.term_name  ELSE '----'  END) AS term_name"),
            \DB::raw("(CASE WHEN (operterminals.date_inactive IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.date_inactive, '%d-%m-%Y') END) as inactive"),
            DB::raw("(CASE WHEN (operterminals.date_reactive IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.date_reactive, '%d-%m-%Y') END) as reactive"),
            'operterminals.observations',
            'operterminals.status as status_operterminal'
        )
            ->join('contracts as ct', 'ct.id', '=', 'operterminals.contract_id')
            ->join('terminals as t', 't.id', '=', 'ct.terminal_id')
            ->leftjoin('terms as trm', 'trm.id', '=', 'operterminals.term_id')
            ->where('operterminals.contract_id', $request['contract_id'])->get();

        return $data;
    }
}
