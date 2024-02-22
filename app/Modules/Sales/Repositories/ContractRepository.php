<?php

namespace App\Modules\Sales\Repositories;

use App\Events\Contract as ContractEvent;
use App\Modules\Customers\Models\Customer;
use App\Modules\Sales\Exports\ContractPendingAffiliateReportExport;
use App\Modules\Sales\Models\Contract;
use App\Modules\Sales\Repositories\Contract\ContractFactory;
use App\Modules\Sales\Repositories\ContractService\ContractServiceFactory;
use App\Modules\Sales\Repositories\Traits\GenericClass;
use Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use NumberFormatter;

class ContractRepository implements ContractInterface
{
    use GenericClass;

    protected $contract;

    /**
     * ContractRepository constructor.
     *
     * @param  Contract  $contract
     */
    public function __construct(Contract $contract)
    {
        $this->model = $contract;
    }

    /**************************Registrar Contrato****************************/
    public function create($request)
    {
        $contractFactory = new ContractFactory();
        $contract = $contractFactory->initialize($request->type_contract);
        $data = $contract->create($request);

        $result = $this->model->create($data);
        if ($result) {
            $data = $this->totalContract();
            event(new ContractEvent($data));

            return $result;
        }

        return false;
    }

    /**********************Ver Información Contrato**************************/
    public function show($id)
    {
        $model = $this->model->query();

        return $model->select('contracts.id', \DB::raw("LPAD(contracts.id,6,'0') as contract_id"), \DB::raw("LPAD(cs.id,6,'0') as customer_id"), 'contracts.dcustomer_id', 'contracts.dcustomer_multiple', 'contracts.company_id', 'contracts.type_dcustomer', 'cs.rif', 'cs.business_name', 'contracts.term_id', 'contracts.modelterminal_id', 'contracts.valid_simcard', 'contracts.operator_id', 'contracts.observation', 'contracts.user_created_id as user_id', 'contracts.consultant_id')
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })->where('contracts.id', $id)
            ->first();
    }

    /***********************Buscar Información Contrato************************/
    public function find($id)
    {
        $model = $this->findQuery($id);

        return $model->where('contracts.id', $id)->first();
    }

    /***********************Buscar Información Contrato************************/
    public function findContract($request)
    {
        $model = $this->model->query();
        $model->select(
            \DB::raw("LPAD(cs.id,6,'0') as customer_id"),
            'cs.rif',
            'cs.business_name',
            \DB::raw("LPAD(contracts.id,6,'0') as contract_id"),
            't.serial as terminal',
            'contracts.nropos',
            'contracts.status',
            'contracts.status as statusc',
            \DB::raw("(CASE WHEN (type_dcustomer='commerce') THEN dc.affiliate_number WHEN (type_dcustomer='nodom') THEN dc.affiliate_number ELSE 'Multicomercio' END) AS affiliate_number"),
            'terms.description as term',
            \DB::raw('(terms.comission_flatrate+(terms.comission_flatrate*0.19)) as term_amount'),
            'mt.description as modelterminal',
            \DB::raw("DATE_FORMAT(contracts.created_at,'%Y-%m-%d') as created"),
            \DB::raw("(CASE WHEN (type_dcustomer='commerce') THEN bk.description WHEN (type_dcustomer='nodom') THEN bk.description ELSE 'Multicomercio' END) AS bank"),
            \DB::raw("(CASE WHEN (orders.posted_at IS NULL) THEN '----' ELSE DATE_FORMAT(orders.posted_at,'%Y-%m-%d') END) AS posted")
        )
            ->join('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'contracts.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->leftjoin('orders', function ($join) {
                $join->on('orders.contract_id', '=', 'contracts.id');
                $join->whereNull('orders.deleted_at');
            });

        if ($request['type_find'] == 'contract') {
            $model->where('contracts.id', (int) $request['find']);
        }

        if ($request['type_find'] == 'customer') {
            $model->where('cs.id', (int) $request['find']);
        }

        if ($request['type_find'] == 'rif') {
            $model->where('cs.rif', $request['find']);
        }

        if ($request['type_find'] == 'terminal') {
            $model->where('t.serial', 'LIKE', $request['find']);
        }

        if ($request['type_find'] == 'business_name') {
            $model->where('cs.business_name', 'LIKE', '%'.$request['find'].'%');
        }

        if ($request['find'] != '') {
            if (! $request->has('type') && $request['type'] != 'operation') {
                return $model->whereNotIn('contracts.status', ['Anulado', 'Cancelado', 'Pendiente'])->get();
            } else {
                return $model->whereNotIn('contracts.status', ['Anulado', 'Pendiente'])->get();
            }
        }

        return '[]';
    }

    /************************Buscar Información Invoice************************/
    public function getContractActive($request)
    {
        $model = $this->model->query();
        $model->select(
            'terms.id',
            \DB::raw("CONCAT(terms.abrev,' - ',terms.description) as term_name"),
            'terms.type_conditions',
            'terms.type_conditions1',
            \DB::raw("(CASE WHEN (terms.type_invoice='M') THEN 'Cobro Mensual' WHEN (terms.type_invoice='S') THEN 'Cobro Semanal' WHEN (terms.type_invoice='Q') THEN 'Cobro Quincenal' ELSE 'Cobro Diario' END) as type_invoice"),
            \DB::raw("(CASE WHEN (terms.type_conditions='Tarifa' AND terms.type_conditions1='Fijo' AND terms.comission_flatrate IS NOT NULL) THEN CONCAT(terms.comission_flatrate,' ',cu.abrev)  WHEN (terms.type_conditions='Porcentaje' AND terms.type_conditions1='Fijo' AND terms.comission_flatrate IS NULL) THEN CONCAT(terms.comission_percentage,'%') WHEN (co.type_conditions='Porcentaje' AND terms.comission_flatrate IS NOT NULL) THEN CONCAT(terms.comission_flatrate,' %') WHEN (co.type_conditions='Tarifa' AND terms.comission_id IS NOT NULL) THEN CONCAT('(',co.value1,cu.abrev,'-',co.value2,cu.abrev,'-',co.value3,cu.abrev,'-',co.value4,cu.abrev,'-',co.value5,cu.abrev,')') WHEN (co.type_conditions='Porcentaje' AND terms.comission_id IS NOT NULL) THEN CONCAT('(',co.value1,'%-',co.value2,'%-',co.value3,'%-',co.value4,'%-', co.value5,'%',')') ELSE '0' END) AS rate"),
            'terms.comission_flatrate as amount',
            \DB::raw('COUNT(*) as total')
        )
            ->join('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
            })
            ->leftjoin('comissions as co', function ($join) {
                $join->on('co.id', '=', 'terms.comission_id');
            })
            ->leftjoin('currencies as cu', function ($join) {
                $join->on('cu.id', '=', 'terms.currency_id');
            });

        if ($request->has('type_service')) {
            $model->where('terms.type_invoice', '=', $request['type_service']);
        }

        return $model->where('contracts.status', 'Activo')->groupBy(['terms.id'])->orderBy('type_invoice', 'ASC')->get();
    }

    /***********************Buscar Información Contrato************************/
    public function contractSupport($id, $status)
    {
        $model = $this->findQuery($id);
        if ($status == 'Activo') {
            $model->whereNotExists(function ($query) use ($id) {
                $query->select(\DB::raw(1))
                    ->from('supports')
                    ->where('supports.contract_id', '=', $id)
                    ->whereNotIn('supports.status', ['C', 'X'])
                    ->whereNull('supports.deleted_at');
            })
                ->where('contracts.status', '=', $status);
        } else {
            $model->where('contracts.status', '!=', 'Anulado');
        }

        return  $model->where('contracts.id', $id)->orWhere('t.serial', 'LIKE', $id)->first();
    }

    /**************************************************************************/
    private function findQuery($id)
    {
        $model = $this->model->query();

        return $model->select(\DB::raw("LPAD(cs.id,6,'0') as customer_id"), 'cs.rif', 'cs.business_name', 'cs.mobile', \DB::raw("LPAD(contracts.id,6,'0') as contract_id"), 'contracts.company_id', 'contracts.type_dcustomer as dcustomer_type', 'contracts.dcustomer_id', 'contracts.dcustomer_multiple', 'contracts.modelterminal_id', 'contracts.terminal_id', 't.serial as terminal', 'contracts.nropos', 'contracts.valid_simcard', 'contracts.operator_id', 's.serial_sim as simcard', 'contracts.simcard_id', 'contracts.term_id', 'contracts.user_created_id', 'contracts.status as status_contract', 'contracts.consultant_id', 'contracts.delivery_date', \DB::raw("(CASE WHEN (type_dcustomer='commerce') THEN dc.affiliate_number WHEN (type_dcustomer='nodom') THEN dc.affiliate_number ELSE 'Multicomercio' END) AS affiliate_number"), 'cp.description as company', 'terms.description as term', \DB::raw('(terms.comission_flatrate+(terms.comission_flatrate*0.19)) as term_amount'), 'mt.description as modelterminal', 'op.description as operator', \DB::raw("CONCAT(users.name ,' ', users.last_name) as user"), \DB::raw("CONCAT(cn.first_name ,' ', cn.last_name) as consultant"), \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN (contracts.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' WHEN (contracts.type_dcustomer = 'multicommerce') THEN 'MultiComercio' ELSE '----' END) type_dcustomer"), 'contracts.observation', 'contracts.status', 'contracts.created_at', \DB::raw("DATE_FORMAT(contracts.created_at,'%Y-%m-%d') as created"), 'users.id as user_id', \DB::raw("(CASE WHEN (type_dcustomer='commerce') THEN bk.description WHEN (type_dcustomer='nodom') THEN bk.description ELSE 'Multicomercio' END) AS bank"), 'inv.id', \DB::raw("(CASE WHEN (orders.posted_at IS NULL) THEN '----' ELSE DATE_FORMAT(orders.posted_at,'%Y-%m-%d') END) AS posted"))
            ->leftjoin('invoices as inv', 'inv.contract_id', '=', 'contracts.id')
            ->join('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('companies as cp', 'cp.id', 'contracts.company_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('operators as op', 'op.id', '=', 'contracts.operator_id')
            ->leftjoin('simcards as s', 's.id', '=', 'contracts.simcard_id')
            ->leftjoin('users', 'users.id', '=', 'contracts.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'contracts.consultant_id')
            ->leftjoin('orders', 'orders.contract_id', '=', 'contracts.id');
    }

    /************************************************************************/
    public function findChange($id)
    {
        $model = $this->model->query();

        return $model->select('contracts.id')->join('orders as or', function ($join) {
            $join->on('or.contract_id', '=', 'contracts.id');
            $join->whereIn('or.status', ['P', 'PF']);
            $join->whereNull('or.deleted_at');
        })
            ->where('contracts.customer_id', $id)
            ->where('contracts.status', '=', 'Pendiente')
            ->get();
    }

    /************************************************************************/
    public function findTerminal($terminal_id)
    {
        return $this->model->where('contracts.terminal_id', '=', $terminal_id)->first();
    }

    /************************************************************************/
    public function search($id)
    {
        return $this->model->findOrfail($id);
    }

    /************************************************************************/
    public function restoreManagement($request, $id)
    {
        $model = $this->model->findOrfail($id);
        if ($model) {
            if ($request['type_support'] == 'terminal' || $request['type_support'] == 'restore') {
                $model->terminal_id = null;
            }

            if ($request['type_support'] == 'simcard' || $request['type_support'] == 'restore') {
                $model->simcard_id = null;
            }
            $model->user_updated_id = Auth::user()->id;
            $result = $model->update();

            if ($result) {
                return true;
            }
        }

        return false;
    }

    /************************Actualizar Información Contrato*******************/
    public function update($request, $id)
    {
        $factory = new ContractServiceFactory();
        $contractService = $factory->initialize($request->type_service);
        $data = $contractService->updateField($request);

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            $data = $this->totalContract();
            event(new ContractEvent($data));

            return $model;
        }

        return false;
    }

    /*****************************Eliminar Contrato****************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        if ($model->update()) {
            if ($model->delete()) {
                $data = $this->totalContract();
                event(new ContractEvent($data));

                return true;
            }
        }

        return false;
    }

    /******************************Validar Rif*********************************/
    public function validRif($rif)
    {
        return Customer::select('customers.id', 'customers.rif', 'customers.business_name')->where('customers.rif', 'LIKE', $rif)->first();
    }

    /*************************Buscar Información Contrato**********************/
    public function select($request)
    {
        $model = $this->model->query();

        if ($request['action'] == 'invoice') {
            $model->select('contracts.id', \DB::raw('CONCAT("Cliente -> ",cs.rif," ",cs.business_name,"  No.Contrato -> ",LPAD(contracts.id,6,"0"),"  No.Cobro ->",LPAD(inv.id,6,"0")) as description'))
                ->join('customers as cs', function ($join) {
                    $join->on('cs.id', '=', 'contracts.customer_id');
                    $join->whereNull('cs.deleted_at');
                })
                ->join('invoices as inv', function ($join) {
                    $join->on('inv.contract_id', '=', 'contracts.id');
                    $join->where('inv.concept_id', '=', 1);
                    $join->whereNull('inv.deleted_at');
                });
        } else {
            $model->select('contracts.id', \DB::raw('CONCAT("No. Contrato: ",LPAD(contracts.id,7,"0")," | Serial:  ",t.serial) as description'))
                ->join('dcustomers as dc', 'dc.customer_id', '=', 'contracts.customer_id')
                ->join('terminals as t', function ($join) {
                    $join->on('t.id', '=', 'contracts.terminal_id');
                    $join->whereNull('t.deleted_at');
                });
            /*$model->whereNotExists(function($query) {
            $query->select(\DB::raw(1))
                    ->from('invoices as inv')
                      ->whereRaw('inv.contract_id = contracts.id')
                        ->where('inv.concept_id', '=', 1);
          });*/
        }

        if ($request['customer_id']) {
            $model->where('contracts.customer_id', '=', (int) $request['customer_id']);
        }

        if ($request['contract_id']) {
            $model->where('contracts.id', '=', (int) $request['contract_id']);
        }

        return $model->orderBy('contracts.id', 'ASC')->get();
    }

    /*****************Api Datatable - Consulta General Contrato****************/
    public function datatable()
    {
        $model = $this->model->query();
        $data = $model->query()->where('contracts.customer_id', '=', $id)->query()->get();

        return datatables()->of($data)
            ->rawColumns(['status'])
            ->toJson();
    }

    /*****************Api Datatable - Consulta General Contrato****************/
    public function datatableUser($id)
    {
        $model = $this->model->query();
        $data = $model->query()->where('contracts.customer_id', '=', $id)->get();

        return datatables()->of($data)
            ->editColumn('affiliate_number', function ($data) {
                return '<center>'.$data->affiliate_number.'</center>';
            })
            ->addColumn('document', function ($data) {
                $actions = '<center>';
                if ($data->status_contract != 'Anulado' && $data->status_contract != 'Cancelado') {
                    $actions .= '<a class="btn btn-sm btn-danger" href="/contracts/documentContract/'.(int) $data->id.'" title="Descargar Contrato"><i class="i i-Cloud"></i></a>';
                } else {
                    $actions .= '----';
                }
                $actions .= '</center>';

                return $actions;
            })
            ->editColumn('file_document', function ($data) {
                $actions = '';
                if ($data->status_contract != 'Anulado' && $data->status_contract != 'Cancelado') {
                    $actions .= '<button href="#" class="btn btn-sm btn-warning" data-toggle="modal" OnClick="uploadContract(this);" value="'.(int) $data->id.'" data-target="#uploadContract" style="color:white;" title="Cargar o Actualizar Documento Contrato Formalizado"><i class="i-Data-Upload"></i></button>';
                    if ($data->file_document != null) {
                        $actions .= '&nbsp;<button href="#" class="btn btn-sm btn-danger" data-toggle="modal" OnClick="documentFile(this);" value="'.$data->file_document.'" data-target="#viewDocumentContract"  title="Ver Documento Contrato Formalizado"><i class="i-Cloud"></i></button>';
                    }
                } else {
                    $actions .= '----';
                }

                return $actions;
            })->rawColumns(['affiliate_number', 'document', 'file_document', 'status'])
            ->toJson();
    }

    /**************************************************************************/
    public function documentContract($id)
    {
        $model = $this->model->query();
        $model->document();

        $data = $model->where('contracts.id', '=', $id)->first();

        return $this->generateDocument($data);
    }

    /**************************************************************************/
    private function generateDocument($data)
    {
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        $document = $PHPWord->loadTemplate(storage_path().'/documents/contract_format.docx');

        $document->setValue('rif', $data->rif);
        $document->setValue('business_name', $data->business_name);
        $document->setValue('email', $data->email);
        $document->setValue('address', $data->address);
        $document->setValue('document', $data->document);
        $document->setValue('first_name', $data->first_name);
        $document->setValue('mark', $data->mark);
        $document->setValue('bank', $data->bank);
        $document->setValue('account_number', $data->account_number);
        $document->setValue('modelterminal', $data->modelterminal);
        $document->setValue('term', $data->term);
        $document->setValue('terminal', $data->terminal);
        $document->setValue('telephone', $data->telephone);
        $document->setValue('mobile', $data->mobile);

        $date = Carbon::now();
        $formatterES = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        $day_text = $formatterES->format($date->day);

        $document->setValue('year', $date->isoFormat('YYYY'));
        $document->setValue('month_text', ucwords(strtolower($date->monthName)));
        $document->setValue('day', $date->day);
        $document->setValue('day_text', ucwords(strtolower($day_text)));

        $document->saveAs(storage_path().'/temporal/Contrato.docx');
        header('Content-disposition: attachment;filename=Contrato Servicios - Plan '.$data->term.'_'.$data->rif.'.docx; charset=iso-8859-1');
        echo file_get_contents(storage_path().'/temporal/Contrato.docx');
    }

    /**************************************************************************/
    public function totalContract()
    {
        $data = $this->model->select(\DB::raw("(CASE WHEN (contracts.status = 'Pendiente') THEN 'CP' WHEN (contracts.status = 'Activo') THEN 'CA' WHEN (contracts.status = 'Anulado') THEN 'CX' WHEN (contracts.status = 'Cancelado') THEN 'CC' END) as dashboard_status"), \DB::raw('count(*) as total'))->whereIn('contracts.status', ['Pendiente', 'Activo'])->whereNull('deleted_at')->groupBy('dashboard_status')->get();

        return $data->toArray();
    }

    /**************************************************************************/
    public function totalSale()
    {
        $model = $this->model->query();
        $model->select('ct.company_id', 'cp.description as company', 'ct.modelterminal_id', 'mt.description as modelterminal', \DB::raw("'sale' as status"), \DB::raw('count(*) as total'))
            ->join('contracts as ct', function ($join) {
                $join->on('ct.company_id', '=', 'cp.id');
                $join->whereNull('ct.terminal_id');
                $join->where('ct.status', 'Pendiente');
                $join->whereNull('ct.deleted_at');
            })
            ->join('companies as cp', 'cp.id', 'ct.company_id')
            ->join('modelterminal as mt', 'mt.id', 'ct.modelterminal_id');

        return  $model->groupBy('modelterminal_id', 'company_id')->get();
    }

    /******************************Cobranza************************************/
    public function reportInvoice($request, $type)
    {
        $model = $this->model->query();

        $model->select(
            \DB::raw("LPAD(cs.id,7,'0') as customer_id"),
            'cs.rif',
            'cs.business_name',
            't.serial as terminal',
            'contracts.nropos',
            \DB::raw("LPAD(contracts.id,7,'0') as contract_id"),
            'contracts.created_at',
            'dc.affiliate_number as affiliate',
            'dc.account_number',
            'bk.description as bank',
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN cs.rif WHEN (contracts.type_dcustomer = 'nodom') THEN cs.rif ELSE dc.rif END) as rif"),
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN cs.business_name WHEN (contracts.type_dcustomer = 'nodom') THEN cs.business_name ELSE dc.business_name END) as business_name"),
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN (contracts.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' ELSE 'Multicomercio' END) as commerce"),
            'terms.description',
            'terms.abrev as term',
            \DB::raw("(CASE WHEN (contracts.type_dcustomer='commerce' OR contracts.type_dcustomer='nodom' AND terms.type_conditions='Tarifa' AND terms.type_conditions1='Fijo') THEN FORMAT(terms.comission_flatrate,2) WHEN (co.range1=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value1 WHEN (co.range2=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value2 WHEN (co.range3=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value3 WHEN (co.range4=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value4 WHEN (co.range5=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value5 ELSE '0' END) as amount"),
            \DB::raw("(CASE WHEN (contracts.observation IS NULL) THEN 'Sin Observación' ELSE contracts.observation END) as observation"),
            \DB::raw("DATE_FORMAT(or.posted_at, '%d/%m/%Y') as posted"),
            'contracts.status as status_contract',
            'inv.status as invoice_status'
        )
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            });

        $model->leftjoin('dcustomers as dc', function ($join) {
            $join->on('dc.id', '=', 'contracts.dcustomer_id');
        });

        $model->leftjoin('invoices as inv', function ($join) {
            $join->on('inv.contract_id', '=', 'contracts.id');
            $join->whereNull('inv.deleted_at');
        })
            ->leftjoin('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'contracts.id');
                $join->whereNull('or.deleted_at');
            })
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'contracts.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->leftjoin('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
            })
            ->leftjoin('comissions as co', function ($join) {
                $join->on('co.id', '=', 'terms.comission_id');
            })
            ->leftjoin('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
            })
            ->leftjoin('currencies as cu', function ($join) {
                $join->on('cu.id', '=', 'terms.currency_id');
            })
            ->leftjoin('supports', function ($join) {
                $join->on('supports.contract_id', '=', 'contracts.id');
                $join->where('supports.status', 'F');
                $join->whereNull('supports.deleted_at');
            });

        $model->whereNotNull('contracts.dcustomer_id');

        if ($request->has('type_service')) {
            $model->where('terms.type_invoice', $request['type_service'])
                ->addSelect('terms.abrev as currency_abrev', 'terms.comission_percentage', \DB::raw("(CASE WHEN (dc.type_account = 'Corriente') THEN 'C' ELSE 'A' END) as type_account"), 'terms.currency_id', 'terms.type_invoice', 'dc.bank_id', 'contracts.reactive_date', 'or.posted_at as order_posted', 'supports.date_ini', 'supports.date_end', 'terms.prepaid');
        }
        $data = $model->where('contracts.status', 'Activo')->orderBy('contracts.id', 'ASC')->get()->toArray();

        return $data;
    }

    /************************************************************************/
    public function getAffiliateActive($request)
    {
        $model = $this->model->select(
            'cs.rif',
            'cs.business_name',
            \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"),
            'dc.affiliate_number',
            'dc.account_number',
            'bk.description as bank_name',
            \DB::raw("(CASE WHEN (bk.is_register=1 AND contracts.is_affiliate=0) THEN 'No' WHEN (bk.is_register=1 AND contracts.is_affiliate=1) THEN contracts.affiliate_date ELSE '----' END) AS affiliate_date"),
            \DB::raw("(CASE WHEN (bk.is_register=1 AND contracts.is_affiliate IS NULL) THEN 'Sin Validar' WHEN (bk.is_register=1 AND contracts.is_affiliate=0) THEN 'Sin Validar' WHEN (bk.is_register=1 AND contracts.is_affiliate=1) THEN 'Confirmado' ELSE '----' END) AS validation"),
            'contracts.status'
        )
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->join('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
                $join->where('bk.is_register', 1);
                $join->whereNull('bk.deleted_at');
            });

        if ($request->has('is_affiliate') && $request['is_affiliate'] == 1) {
            $model->where('contracts.is_affiliate', '1');
        } elseif ($request->has('is_affiliate') && ($request['is_affiliate'] == 0 || $request['is_affiliate'] == '')) {
            $model->whereNull('contracts.is_affiliate')->orWhere('contracts.is_affiliate', '0');
        }

        $data = $model->where('contracts.status', 'Activo')->orderBy('contracts.dcustomer_id', 'ASC')->get();

        return datatables()->of($data)->rawColumns(['status'])->toJson();
    }

    /************************************************************************/
    public function getAffiliatePending($request)
    {
        $model = $this->model->select(
            'cs.rif',
            'cs.business_name',
            \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"),
            'bk.description as bank_name',
            'dc.affiliate_number',
            'dc.account_number',
            \DB::raw("(CASE WHEN (bk.is_register=1 AND contracts.is_affiliate IS NULL) THEN 'Sin Afiliación' WHEN (bk.is_register=1 AND contracts.is_affiliate=0) THEN 'Sin Afiliación' WHEN (bk.is_register=1 AND contracts.is_affiliate=1) THEN 'Afiliado' ELSE '----' END) AS validation")
        )
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) use ($request) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->where('dc.bank_id', '=', $request['bank_id']);
                $join->whereNull('dc.deleted_at');
            })
            ->join('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
                $join->where('bk.is_register', 1);
                $join->whereNull('bk.deleted_at');
            });

        $data = $model->where('contracts.status', 'Activo')->whereNull('contracts.is_affiliate')->get();

        return Excel::download(new ContractPendingAffiliateReportExport($data), 'Reporte Contracto Cliente Sin Afiliar '.date('Y-m-d').'.xlsx');
    }
}
