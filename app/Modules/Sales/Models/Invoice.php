<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'invoices';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'receipt_journey', 'customer_id', 'contract_id', 'bank_id', 'refere', 'fechpro', 'tipcta', 'concept_id', 'rif', 'business_name',
        'nrocta', 'nropos', 'tipnot', 'payment_date', 'type_sale', 'currency_id', 'amount', 'free', 'amount_currency', 'frec_invoice', 'quota',
        'lote', 'conceptc', 'conciliation_doc', 'status', 'user_created_id',    'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /********************************Scope*****************************************/
    public function scopeQuery($query)
    {
        return $query->select(
            'invoices.id',
            'cs.id as customer_id',
            'ct.id as contract_id',
            'invoices.receipt_journey as receipt_id',
            \DB::raw('(CASE WHEN (invoices.free IS NULL) THEN FORMAT(0,2)  ELSE FORMAT(invoices.free,2)  END) as invoice_free'),
            \DB::raw('FORMAT(invoices.amount_currency,2)  as amount_currency'),
            'ct.created_at as created_contract',
            'cs.rif',
            \DB::raw("(CASE WHEN(ct.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN(ct.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' ELSE 'MultiComercio' END) AS type_dcustomer"),
            \DB::raw("(CASE WHEN(ct.type_dcustomer = 'commerce') THEN dc.affiliate_number WHEN(ct.type_dcustomer = 'nodom') THEN dc.affiliate_number ELSE ct.dcustomer_multiple END) AS affiliate_number"),
            'cs.business_name',
            'cs.email',
            'states.description as state',
            'cities.description as city',
            'cs.address',
            'cs.postal_code',
            'cs.telephone',
            'cs.mobile',
            'companies.description as company',
            'terms.description as term',
            \DB::raw("(CASE WHEN (bk.description IS NULL) THEN '---' ELSE bk.description END) as bank"),
            \DB::raw("CONCAT(mt.description ,' | ', marks.description) as modelterminal"),
            'op.description as operator',
            'cu.abrev as currency_contract',
            \DB::raw(' FORMAT(ct.amount,2) as amount_contract'),
            'ct.status as status_contract',
            'invoices.fechpro',
            'invoices.tipnot',
            \DB::raw("(CASE WHEN (ct.observation IS NULL) THEN '---' ELSE ct.observation END) as obs"),
            'invoices.type_sale',
            'invoices.refere',
            'invoices.currency_id',
            'currencies.abrev as currency_invoice',
            \DB::raw('FORMAT(invoices.amount_currency,2) AS dicom'),
            \DB::raw(' (CASE WHEN (invoices.currency_id = 1) THEN FORMAT(invoices.amount,2) ELSE FORMAT((invoices.amount * invoices.amount_currency),2) END) as amount_total'),
            \DB::raw(' FORMAT(invoices.amount,2) as amount_invoice'),
            'invoices.conciliation_doc',
            \DB::raw("(SELECT count(*) FROM csupports WHERE csupports.contract_id = ct.id AND csupports.status LIKE 'G' AND csupports.deleted_at IS NULL) as total_support"),
            'invoices.status',
            'invoices.status as status_invoice',
            \DB::raw("CONCAT(users.name ,' ', users.last_name) as user_name"),
            \DB::raw("CONCAT(cn.first_name ,' ', cn.last_name) as consultant_name"),
            'invoices.created_at',
            'invoices.updated_at',
            'invoices.payment_date',
            'concepts.description as concept'
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'invoices.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'ct.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('companies', 'companies.id', '=', 'ct.company_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('terms', 'terms.id', '=', 'ct.term_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('marks', 'marks.id', '=', 'mt.mark_id')
            ->leftjoin('operators as op', 'op.id', '=', 'ct.operator_id')
            ->leftjoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->leftjoin('currencies as cu', 'cu.id', '=', 'ct.currency_id')
            ->leftjoin('users', 'users.id', '=', 'ct.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'ct.consultant_id')
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'cs.city_id')
            ->leftjoin('concepts', 'concepts.id', '=', 'invoices.concept_id');
    }

    public function scopeCollection($query)
    {
        return $query->whereNotExists(function ($q) {
            $q->select(\DB::raw(1))
                ->from('collections as cl')
                ->whereRaw('cl.invoice_id = invoices.id')
                ->whereNull('cl.deleted_at');
        });
    }

    public function scopeCollect($query)
    {
        return $query->whereExists(function ($q) {
            $q->select(\DB::raw(1))
                ->from('collections as cl')
                ->whereRaw('cl.invoice_id = invoices.id')
                ->whereNull('cl.deleted_at');
        });
    }

    public function scopeCollectionExist($query)
    {
        return $query->leftjoin('collections as cl', function ($join) {
            $join->on('cl.invoice_id', '=', 'invoices.id');
            $join->whereNull('cl.deleted_at');
        })->addSelect('cl.id as collection_id');
    }

    public function scopeTotalquery($query)
    {
        return  $query->select(
            'invoices.id',
            'cs.id as customer_id',
            'ct.id as contract_id',
            'invoices.receipt_journey as receipt_id',
            'ct.created_at as created_contract',
            'cs.rif',
            \DB::raw("(CASE WHEN(ct.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN(ct.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' ELSE 'MultiComercio' END) AS type_dcustomer"),
            'dc.affiliate_number',
            'cs.business_name',
            'cs.email',
            'states.description as state',
            'cities.description as city',
            'cs.address',
            'cs.postal_code',
            'cs.telephone',
            'cs.mobile',
            'companies.description as company',
            'terms.description as term',
            \DB::raw("(CASE WHEN (bk.description IS NULL) THEN '---' ELSE bk.description END) as bank"),
            \DB::raw("CONCAT(mt.description ,' | ', marks.description) as modelterminal"),
            \DB::raw("(CASE WHEN (op.description IS NULL) THEN '---' ELSE op.description END) as operator"),
            \DB::raw(' FORMAT(ct.amount,2) as amount_contract'),
            'ct.status as status_contract',
            'invoices.fechpro',
            'invoices.tipnot',
            'ct.observation as obs',
            'invoices.type_sale',
            'invoices.refere',
            'currencies.abrev as currency_invoice',
            \DB::raw('FORMAT(invoices.amount_currency,2) AS dicom'),
            \DB::raw(' (CASE WHEN (invoices.currency_id = 1) THEN FORMAT(invoices.amount,2) ELSE FORMAT((invoices.amount * invoices.amount_currency),2) END) as amount_total'),
            \DB::raw('FORMAT(invoices.free,2) AS invoice_free'),
            \DB::raw(' FORMAT(invoices.amount,2) as amount_invoice'),
            'invoices.conciliation_doc',
            \DB::raw("(SELECT count(*) FROM csupports WHERE csupports.contract_id = ct.id AND csupports.status LIKE 'G' AND csupports.deleted_at IS NULL) as total_support"),
            'invoices.status',
            'invoices.status as status_invoice',
            \DB::raw("CONCAT(users.name ,' ', users.last_name) as user_name"),
            \DB::raw("CONCAT(cn.first_name ,' ', cn.last_name) as consultant_name"),
            'invoices.created_at',
            'invoices.updated_at',
            'col.id as collection_id',
            'concepts.description as name_concept'
        )
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'invoices.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'ct.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('collections as col', function ($join) {
                $join->on('col.invoice_id', '=', 'invoices.id');
                $join->whereNull('col.deleted_at');
                $join->distinct('col.invoice_id');
            })/*
                                                                                ->leftjoin('billingitems as bli', function($join) {
                                                                                        $join->on('bli.contract_id','=','ct.id');
                                                                                        $join->whereNull('bli.deleted_at');
                                                                                        $join->distinct('bli.contract_id');
                                                                                })
                                                                                    ->leftjoin('billings as bl', function($join) {
                                                                                            $join->on('bl.customer_id','=','ct.customer_id');
                                                                                            $join->whereNull('bl.deleted_at');
                                                                                            $join->distinct('bl.customer_id');
                                                                                        })*/
            ->leftjoin('concepts', function ($join) {
                $join->on('concepts.id', '=', 'invoices.concept_id');
            })
            ->leftjoin('companies', 'companies.id', '=', 'ct.company_id')
            ->leftjoin('terms', 'terms.id', '=', 'ct.term_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('marks', 'marks.id', '=', 'mt.mark_id')
            ->leftjoin('operators as op', 'op.id', '=', 'ct.operator_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->leftjoin('currencies as cu', 'cu.id', '=', 'ct.currency_id')
            ->leftjoin('users', 'users.id', '=', 'ct.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'ct.consultant_id')
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'cs.city_id');
    }

    public function scopeSalepos($query)
    {
        return $query->where('invoices.concept_id', 1);
    }

    public function scopeSalecustomer($query)
    {
        return $query->whereIn('invoices.concept_id', [1, 2]);
    }

    public function scopeInvoiceitemt($query)
    {
        return $query->leftjoin('invoiceitems as invit', function ($join) {
            $join->on('invit.invoice_id', '=', 'invoices.id');
            $join->whereNull('invit.deleted_at');
        })->addSelect(\DB::raw('COUNT(invit.id) as total_invoiceitem'));
    }

    public function scopeCollectiont($query)
    {
        return $query->leftjoin('collections as col', function ($join) {
            $join->on('col.invoice_id', '=', 'invoices.id');
            $join->whereNull('col.deleted_at');
        })->addSelect('col.id as collection_id');
    }

    /******************************Assesor*****************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getBillingIdAttribute($value)
    {
        if ($value != null) {
            return str_pad($value, 7, '0', STR_PAD_LEFT);
        }

        return $value;
    }

    public function getReceiptIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getInvoiceIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getPaymentDateAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function getOrderPostedAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function getFechproAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function getTipnotAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return '----';
    }

    public function getStatusAttribute($value)
    {
        $type = 'dark';
        $title = '';
        $content = '';
        if ($value == 'G') {
            $title = 'Pendiente de Cobro';
            $content = 'Generado';
            $type = 'info';
        } elseif ($value == 'R') {
            $title = 'Pendiente de Cobro';
            $content = 'Rechazado';
            $type = 'warning';
        } elseif ($value == 'C') {
            $title = 'Conciliado x Administración';
            $content = 'Conciliado';
            $type = 'success';
        } elseif ($value == 'P') {
            $title = 'Pendiente de Cobro';
            $content = 'Pendiente';
            $type = 'warning';
        } elseif ($value == 'X') {
            $title = 'Cancelado';
            $content = 'Cancelado';
            $type = 'dark';
        } elseif ($value == 'E') {
            $title = 'Exonerado';
            $content = 'Exonerado';
            $type = 'dark';
        } elseif ($value == 'N') {
            $title = 'en Negociación';
            $content = 'En Negociación';
            $type = 'warning';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-1 m-1" title='.$title.' style="color:white;">'.$content.'</span>';
    }

    public function getInvoiceFreeAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return  0.00;
    }

    public function getRefereAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return  '----';
    }

    public function getConsultantNameAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return  '----';
    }

    public function getTypeSaleAttribute($value)
    {
        if ($value == 'journey') {
            return 'Jornada';
        }
        if ($value == 'basic') {
            return 'Básica';
        }
        if ($value == 'discount') {
            return 'Básica - Descuento';
        }

        return '----';
    }
}
