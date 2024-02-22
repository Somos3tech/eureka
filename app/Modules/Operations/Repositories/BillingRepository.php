<?php

namespace App\Modules\Operations\Repositories;

use App\Modules\Operations\Models\Billing;
use App\Modules\Sales\Repositories\Traits\GenericClass;
use Auth;
use Carbon\Carbon;

class BillingRepository implements BillingInterface
{
    use GenericClass;

    protected $billing;

    public function __construct(Billing $billing)
    {
        $this->model = $billing;
    }

    /**************************************************************************/
    public function create($request)
    {
        $date = $request['date'];
        $new_date = strtotime('+1 day', strtotime($date));
        $date = date('Y-m-d h:m:s', $new_date);

        $result = $this->model->create([
            'fechpro' => $request['date'],
            'fechven' => $date,
            'customer_id' => $request['customer_id'],
            'rif' => $request['rif'],
            'business_name' => $request['business_name'],
            'address' => $request['address'],
            'mobile' => $request['mobile'],
            'observation' => $request['observation'],
            'template' => 'pdf',
            'dicom' => $request['dicom'] != '' ? str_replace(',', '', $request['dicom']) : null,
            'user_created_id' => Auth::user()->id,
        ]);

        if ($result) {
            return $result;
        }

        return false;
    }

    /**************************************************************************/
    public function find($id)
    {
        $model = $this->model->query();
        $data = $model->query()->where('billings.id', $id)->first();

        return \Response::json($data);
    }

    /**************************************************************************/
    public function findCustomer($id)
    {
        return $this->model->select('billings.id', \DB::raw("'----' as refere"), 'billings.fechpro', \DB::raw("(CASE WHEN (billings.id IS NULL) THEN NULL ELSE 'FACT' END) as type_register"), \DB::raw("CONCAT('FACTURA COMPRA - ',cp.description) as concept"), \DB::raw("'----' as amount_inv"), \DB::raw('FORMAT(((bi.amount/1.16)+(((bi.amount/1.16)-bi.free)*0.16)-bi.free),2) as total'))
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'billings.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('billingitems as bi', function ($join) {
                $join->on('bi.billing_id', '=', 'billings.id');
                $join->whereNull('bi.deleted_at');
            })
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'bi.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('invoices as inv', function ($join) {
                $join->on('inv.id', '=', 'bi.invoice_id');
                $join->whereNull('inv.deleted_at');
            })
            ->join('concepts as cp', 'cp.id', '=', 'inv.concept_id')
            ->where('cs.id', '=', $id)
            ->get();
    }

    /**************************************************************************/
    public function statements($request)
    {
        $count = count($request['field']);

        if ($request['start'] != '' && $request['end'] != '') {
            $raw = \DB::raw("ROUND(((SELECT ROUND(SUM(collections.amount),1) FROM collections INNER JOIN invoices as inv1 ON inv1.id=collections.invoice_id AND inv1.deleted_at IS NULL INNER JOIN contracts as ct1 ON ct1.id=inv1.contract_id AND ct1.deleted_at IS NULL INNER JOIN customers as cs1 ON cs1.id=ct1.customer_id WHERE collections.fechpro BETWEEN '".$request['start']."' AND '".$request['end']."' AND  cs1.rif LIKE cs.rif) - (SELECT ROUND(SUM(ncc1.amount),1) FROM ncredits as nc1 INNER JOIN customers as cus ON cus.id=nc1.customer_id INNER JOIN ncredititems as ncc1 ON ncc1.ncredit_id=nc1.id AND nc1.deleted_at IS NULL WHERE nc1.fechpro BETWEEN '".$request['start']." %' AND '".$request['end']."  %' AND  cus.rif LIKE cs.rif) - (SELECT ROUND(SUM((bi1.amount/1.16) + (((bi1.amount/1.16)-bi1.free)*0.16) - bi1.free),1) FROM billingitems as bi1 INNER JOIN billings as b1 ON b1.id=bi1.billing_id AND b1.deleted_at IS NULL INNER JOIN invoices as inv2 ON inv2.id=bi1.invoice_id AND inv2.deleted_at IS NULL INNER JOIN contracts as ct2 ON ct2.id=inv2.contract_id AND ct2.deleted_at IS NULL INNER JOIN customers as cs2 ON cs2.id=ct2.customer_id WHERE b1.fechpro BETWEEN '".$request['start']." %' AND '".$request['end']." %' AND cs2.rif LIKE cs.rif)),1)");
        } else {
            $raw = \DB::raw('ROUND(((SELECT ROUND(SUM(collections.amount),1) FROM collections INNER JOIN invoices as inv1 ON inv1.id=collections.invoice_id AND inv1.deleted_at IS NULL INNER JOIN contracts as ct1 ON ct1.id=inv1.contract_id AND ct1.deleted_at IS NULL INNER JOIN customers as cs1 ON cs1.id=ct1.customer_id WHERE cs1.rif LIKE cs.rif) - (SELECT ROUND(SUM(ncc1.amount),1) FROM ncredits  as nc1 INNER JOIN customers as cus ON cus.id=nc1.customer_id INNER JOIN ncredititems as ncc1 ON ncc1.ncredit_id=nc1.id AND nc1.deleted_at IS NULL WHERE cus.rif LIKE cs.rif) - (SELECT ROUND(SUM((bi1.amount/1.16) + (((bi1.amount/1.16)-bi1.free)*0.16) - bi1.free),1) FROM billingitems as bi1 INNER JOIN billings as b1 ON b1.id=bi1.billing_id AND b1.deleted_at IS NULL INNER JOIN invoices as inv2 ON inv2.id=bi1.invoice_id AND inv2.deleted_at IS NULL INNER JOIN contracts as ct2 ON ct2.id=inv2.contract_id AND ct2.deleted_at IS NULL INNER JOIN customers as cs2 ON cs2.id=ct2.customer_id WHERE cs2.rif LIKE cs.rif)),1)');
        }

        $model = $this->model->query();

        $model->select(
            \DB::raw("DATE_FORMAT(billings.fechpro, '%Y-%m-%d') as date_created"),
            \DB::raw("(CASE WHEN (billings.id IS NULL) THEN NULL ELSE 'Factura' END) as type_register"),
            'billings.id',
            'cs.rif',
            'cs.business_name',
            'mt.description as modelterminal',
            \DB::raw("'---' as concept"),
            \DB::raw("'---' as refere"),
            \DB::raw('ROUND(((bi.amount/1.16)+(((bi.amount/1.16)-bi.free)*0.16)-bi.free),1) as amount_debit'),
            \DB::raw("'' as amount_credit"),
            \DB::raw('(ROUND(((bi.amount/1.16)+(((bi.amount/1.16)-bi.free)*0.16)-bi.free),1)) as amount'),
            $raw
        )
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'billings.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('billingitems as bi', function ($join) {
                $join->on('bi.billing_id', '=', 'billings.id');
                $join->whereNull('bi.deleted_at');
            })
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'bi.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('invoices as inv', function ($join) {
                $join->on('inv.id', '=', 'bi.invoice_id');
                $join->whereNull('inv.deleted_at');
            })
            ->join('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id');

        if ($request['start'] != '' && $request['end'] != '') {
            $model->whereBetween('billings.fechpro', [$request['start'].' %', $request['end'].' %']);
        }

        for ($i = 0; $i < $count; $i++) {
            if ($request['field'][$i] != null && $request['query'][$i] != null) {
                if ($request['operator'][$i] != null) {
                    $operator = $request['operator'][$i];
                } else {
                    $operator = '=';
                }

                if ($i == 0) {
                    $model->where('cs.'.$request['field'][$i], $operator, $request['query'][$i]);
                    $cond = $request['conditional'][$i];
                } else {
                    if ($cond == 'AND' || $cond == '') {
                        $model->where('cs.'.$request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    } else {
                        $model->OrWhere('cs.'.$request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    }
                }
            }
        }

        if ($request['balance'] != null) {
            if ($request['balance'] == 1) {
                $model->where($raw, '=', 0);
            }

            if ($request['balance'] == 0) {
                $model->where($raw, '!=', 0);
            }
        }
        $data = $model->orderBy('billings.fechpro', 'DESC')->get();

        return $data;
    }

    /**************************************************************************/
    public function update($request, $id)
    {
    }

    /**************************************************************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        if ($result = $model->update()) {
            if ($result = $model->delete()) {
                return $model;
            }
        }

        return false;
    }

    /**************************************************************************/
    public function datatable()
    {
        $model = $this->model->query();
        $model->query();
        $data = $model->groupBy('billings.id')->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>';

                $date_now = Carbon::now()->format('Y-m');
                if ($data->billing_created == $date_now) {
                    if (\Shinobi::can('billings.destroy')) {
                        $actions .= '<button class="btn btn-sm btn-danger waves-effect waves-light" href="#" data-toggle="modal" OnClick="BillingDelete(this);" data-target="#deleteBilling" value="'.$data->id.'" title="Anular Factura"><i class="fa fa-trash"></i></button>';
                    }
                }
                $actions .= '&nbsp; <button class="btn btn-sm btn-info waves-effect waves-light" href="#" data-toggle="modal" OnClick="OrderShow(this);" data-target="#showOrder" value="'.$data->order_id.'" title="Gestión Orden de Servicio"><i class="ion-information-circled"></i></button>';
                $actions .= '&nbsp; <button class="btn btn-sm btn-secondary waves-effect waves-light" data-toggle="modal" value="'.$data->id.'" OnClick="showBilling(this);" data-target=".billing" title="Ver Factura""><i class="fa fa-file-pdf-o"></i></button>';
                $actions .= '&nbsp; <button class="btn btn-sm btn-secondary waves-effect waves-light" data-toggle="modal" value="'.$data->id.'" OnClick="showBillingN(this);" data-target=".billing" title="Imprimir Factura"><i class="fa fa-print"></i></button>';
                $actions .= '</center>';

                return $actions;
            })->rawColumns(['management', 'actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function report($request)
    {
        $model = $this->model->query();
        $table = 'cs.';

        if ($request['currency_id'] != '') {
            $model->select(
                'billings.fechpro as fech',
                'billings.id',
                \DB::raw("'----' as control"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' ANULADA' ELSE cs.rif END) as rif"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' ANULADA' ELSE cs.business_name END) as business_name"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' ANULADA' ELSE GROUP_CONCAT(CONCAT('{',bk.description,'}'),'') END) as bank"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' ANULADA' ELSE GROUP_CONCAT(CONCAT('{',mt.description,' -> ',t.serial,'}'),'') END) as terminal"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN '0' ELSE (SUM(inv.amount -inv.free)) END) as total_invoice"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' 0' ELSE ((SUM(bli.amount)/1.16) + (((SUM(bli.amount)/1.16) - SUM(bli.free))*0.16)-SUM(bli.free)) END) as total"),
                \DB::raw("(GROUP_CONCAT('[',acconcepts.name,']')) as acconcept"),
                \DB::raw("(GROUP_CONCAT('[',collections.refere,']')) as refere"),
                'cp.description as company',
                'cs.com_activity',
                \DB::raw("(CASE WHEN (cs.type_cont=1) THEN 'Contribuyente Ordinario' WHEN (cs.type_cont=2) THEN 'Contribuyente Especial' ELSE '----' END) contribuyente"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN 'ANULADA' ELSE CONCAT(us.name,' ', us.last_name)  END) as user_created")
            );
        } else {
            $model->select(
                'billings.fechpro as fech',
                'billings.id',
                \DB::raw("'----' as control"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' ANULADA' ELSE cs.rif END) as rif"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' ANULADA' ELSE cs.business_name END) as business_name"),
                \DB::raw("GROUP_CONCAT(CONCAT('{',bk.description,'}'),'') as bank"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN ' ANULADA' ELSE GROUP_CONCAT(CONCAT('{',mt.description,' -> ',t.serial,'}'),'') END) as terminal"),
                \DB::raw("(CASE WHEN (bli.amount_currency IS NULL) THEN SUM(ROUND(bli.amount/1.16,2)/1000000) WHEN (billings.template='pdf4') THEN SUM(ROUND(((bli.amount_currency/1.16)*billings.dicom),2)) ELSE SUM(ROUND((ROUND((bli.amount_currency/1.16),2)*billings.dicom)/1000000,2)) END) as baser"),
                \DB::raw("(CASE WHEN (bli.amount_currency IS NULL) THEN SUM(ROUND(bli.free,2)/1000000) WHEN (billings.template='pdf4') THEN SUM(ROUND(bli.free*billings.dicom,2)) ELSE SUM(ROUND((ROUND(bli.free,2)*billings.dicom)/1000000,2)) END) as freer"),
                \DB::raw("(CASE WHEN (bli.amount_currency IS NULL) THEN SUM(ROUND((bli.amount/1.16)-bli.free,2)/1000000) WHEN (billings.template='pdf4') THEN SUM(ROUND(((bli.amount_currency/1.16)*billings.dicom)-(bli.free*billings.dicom),2)) ELSE SUM(ROUND(((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom)/1000000,2)) END) as base_freer"),
                \DB::raw("(CASE WHEN (bli.amount_currency IS NULL) THEN SUM(ROUND(((bli.amount/1.16)-bli.free)*0.16,2)/1000000) WHEN (billings.template='pdf4') THEN SUM(ROUND((((bli.amount_currency/1.16)*billings.dicom)-(bli.free*billings.dicom))*0.16,2)) ELSE SUM( ROUND((((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom)*0.16)/1000000,2)) END) as ivar"),
                \DB::raw("(CASE WHEN (bli.amount_currency IS NULL) THEN SUM((ROUND((bli.amount/1.16)-bli.free,2) + ROUND(((bli.amount/1.16)-bli.free)*0.16,2))/1000000) WHEN (billings.template='pdf4') THEN SUM(ROUND((((bli.amount_currency/1.16)-bli.free)*billings.dicom) + (((bli.amount_currency/1.16)-bli.free)*billings.dicom)*0.16,2)) ELSE SUM((ROUND((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom,2) + ROUND(((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom)*0.16,2))/1000000) END) as totalr"),
                \DB::raw("(GROUP_CONCAT('[',acconcepts.name,']')) as acconcept"),
                \DB::raw("(GROUP_CONCAT('[',collections.refere,']')) as refere"),
                'cp.description as company',
                'cs.com_activity',
                \DB::raw("(CASE WHEN (cs.type_cont=1) THEN 'Contribuyente Ordinario' WHEN (cs.type_cont=2) THEN 'Contribuyente Especial' ELSE '----' END) contribuyente"),
                \DB::raw("(CASE WHEN (billings.deleted_at IS NOT NULL) THEN 'ANULADA' ELSE CONCAT(us.name,' ', us.last_name)  END) as user_created")
            );
        }

        $model->leftjoin('customers as cs', 'cs.id', '=', 'billings.customer_id')
            ->leftjoin('billingitems as bli', function ($join) {
                $join->on('bli.billing_id', '=', 'billings.id');
                $join->whereNull('bli.deleted_at');
            })
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'bli.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('invoices as inv', function ($join) {
                $join->on('inv.id', '=', 'bli.invoice_id');
                $join->whereNull('inv.deleted_at');
            })
            ->leftjoin('collections', function ($join) {
                $join->on('collections.invoice_id', '=', 'inv.id');
                $join->whereNull('collections.deleted_at');
            })
            ->leftjoin('acconcepts', function ($join) {
                $join->on('acconcepts.id', '=', 'collections.acconcept_id');
                $join->whereNull('acconcepts.deleted_at');
            })
            ->leftjoin('terminals as t', 't.id', '=', 'ct.terminal_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 't.modelterminal_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'ct.dcustomer_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'ct.company_id')
            ->leftjoin('users as us', 'us.id', '=', 'billings.user_created_id');

        if ($request['start'] != '' && $request['end'] != '') {
            $model->whereBetween('billings.fechpro', [$request['start'].' %', $request['end'].' %']);
        }

        if ($request['currency_id'] != '') {
            $model->where('inv.currency_id', '=', $request['currency_id']);
        }

        if ($request['statusc'] == 'destroy') {
            $model->withTrashed();
        }

        if ($request['field'] != null) {
            $count = count($request['field']);

            for ($i = 0; $i < $count; $i++) {
                if ($request['field'][$i] != null && $request['query'][$i] != null) {
                    if ($request['operator'][$i] != null) {
                        $operator = $request['operator'][$i];
                    } else {
                        $operator = '=';
                    }

                    if ($i == 0) {
                        $model->where($table.$request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    } else {
                        if ($cond == 'AND' || $cond == '') {
                            $model->where($table.$request['field'][$i], $operator, $request['query'][$i]);
                            $cond = $request['conditional'][$i];
                        } else {
                            $model->OrWhere($table.$request['field'][$i], $operator, $request['query'][$i]);
                            $cond = $request['conditional'][$i];
                        }
                    }
                }
            }
        }
        $data = $model->orderBy('billings.id', 'ASC')->groupBy('billings.id')->get();

        return $data;
    }

    /**************************************************************************/
    public function api()
    {
        $data = $this->model->select(\DB::raw("CONCAT('No. Factura: ',billings.id) as description"), 'billings.id')->where('billings.customer_id', Input::get('customer_id'))->get();

        if ($data) {
            return $data;
        }

        return false;
    }

    /**************************************************************************/
    public function pdf($id)
    {
        $data = [];
        $query = $this->model->select(
            \DB::raw('LPAD(billings.id, 7, "0") as billing_id'),
            'billings.observation',
            'billings.template as view_template',
            \DB::raw('LPAD(billings.customer_id, 6, "0") as customer_id'),
            'cs.business_name',
            'cs.rif',
            'cs.address',
            'states.description as state',
            'cities.description as city',
            'cs.telephone',
            'cs.mobile',
            \DB::raw('((((bli.amount / 1.16) - bli.free) + (((bli.amount / 1.16) - bli.free) * 0.16))) as total_base'),
            'bli.free as free',
            \DB::raw(" (CASE WHEN (cn.id IS NOT NULL) THEN LPAD(cn.id, 3, '0') ELSE LPAD(us.id, 3, '0') END) as user_id"),
            \DB::raw(" (CASE WHEN (CONCAT(cn.first_name,' ', cn.last_name) IS NOT NULL) THEN  CONCAT(cn.first_name,' ', cn.last_name) ELSE CONCAT(us.name,' ', us.last_name) END) as user_name"),
            'billings.dicom',
            'bli.iva',
            'bli.amount',
            'bli.amount_sim',
            'bli.amount_currency',
            \DB::raw("(CASE WHEN (bli.amount IS NULL) THEN '0.00' ELSE ((bli.amount / 1.16)) END) as base"),
            'op.description as operator',
            's.serial_sim as simcard_serial',
            'cp.description as company',
            'mt.description as modelterminal',
            't.serial as terminal_serial',
            \DB::raw('DATE_FORMAT(billings.fechpro, "%d/%m/%Y")as fecpro'),
            \DB::raw('DATE_FORMAT(billings.fechven, "%d/%m/%Y")as fechven'),
            'contracts.created_at as created_contract'
        )
            ->join('customers as cs', 'cs.id', '=', 'billings.customer_id')
            ->join('billingitems as bli', function ($join) {
                $join->on('bli.billing_id', '=', 'billings.id');
                $join->whereNull('bli.deleted_at');
            })
            ->leftjoin('contracts', 'contracts.id', '=', 'bli.contract_id')
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'cs.city_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'contracts.company_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('terminals as t', 't.id', '=', 'bli.terminal_id')
            ->leftjoin('operators as op', 'op.id', '=', 'contracts.operator_id')
            ->leftjoin('simcards as s', 's.id', '=', 'bli.simcard_id')
            ->leftjoin('users as us', 'us.id', '=', 'contracts.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'contracts.consultant_id')
            ->where('billings.id', '=', $id)
            ->get();
        foreach ($query as $row) {
            $billing_id = $row->id;
            $view_template = $row->view_template;
            $data[] = $row;
            $data[0]['template'] = Input::get('template');
        }

        $pdf = \PDF::loadView('operations::billings.'.$view_template, compact('data'));

        return $pdf->stream('FACT-'.$billing_id.'.pdf');
    }

    /**************************************************************************/
    public function documentContract($id)
    {
        $model = $this->model->query();

        $model->select(
            'customers.business_name',
            'customers.rif',
            \DB::raw('UPPER(customers.city_register) as city_register'),
            \DB::raw('UPPER(customers.comercial_register) as comercial_register'),
            \DB::raw("DATE_FORMAT(customers.date_register,'%d/%m/%Y') as date_register"),
            'customers.number_register',
            'customers.took_register',
            'customers.clause_register',
            'rc.document',
            'rc.first_name',
            'rc.last_name',
            \DB::raw('UPPER(rc.jobtitle) as jobtitle'),
            'rc.telephone',
            'bk.description as bank',
            'mt.description as modelterminal',
            't.serial as terminal',
            \DB::raw("CONCAT(us.name,' ',us.last_name) AS user_created")
        )
            ->join('billingitems as bi', function ($join) {
                $join->on('bi.billing_id', '=', 'billings.id');
                $join->whereNull('bi.deleted_at');
            })
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'bi.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('customers', function ($join) {
                $join->on('customers.id', '=', 'ct.customer_id');
                $join->whereNull('customers.deleted_at');
            })
            ->join('rcustomers as rc', function ($join) {
                $join->on('rc.id', '=', \DB::raw('(SELECT rcustomers.id FROM rcustomers WHERE rcustomers.customer_id=ct.customer_id LIMIT 1)'));
                $join->whereNull('rc.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'ct.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->join('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
                $join->whereNull('bk.deleted_at');
            })
            ->join('terminals as t', function ($join) {
                $join->on('t.id', '=', 'bi.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->join('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 't.modelterminal_id');
                $join->whereNull('mt.deleted_at');
            })
            ->leftjoin('users as us', function ($join) {
                $join->on('us.id', '=', 'ct.user_created_id');
                $join->whereNull('us.deleted_at');
            });

        $data = $model->where('billings.id', '=', $id)->distinct('t.serial')->get();

        return $this->generateDocument($data);
    }
}
