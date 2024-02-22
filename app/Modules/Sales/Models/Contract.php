<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $table = 'contracts';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'customer_id', 'type_dcustomer', 'dcustomer_id', 'dcustomer_multiple', 'company_id', 'modelterminal_id', 'terminal_id', 'valid_simcard', 'operator_id', 'simcard_id', 'term_id', 'nropos', 'currency_id', 'amount', 'observation', 'file_document', 'status', 'reactive_date', 'consultant_id', 'is_delivery', 'delivery_date', 'is_affiliate', 'affiliate_date', 'user_created_id', 'user_updated_id', 'user_posted_id', 'user_deleted_id', 'created_at',
    ];

    protected $dates = [
        'posted_at', 'deleted_at',
    ];

    /********************************Scope*****************************************/
    public function scopeQuery($query)
    {
        return $query->select(
            'contracts.id',
            'contracts.created_at',
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN (contracts.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' WHEN (contracts.type_dcustomer = 'multicommerce') THEN 'MultiComercio' ELSE '----' END) type_dcustomer"),
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN dc.affiliate_number WHEN (contracts.type_dcustomer = 'nodom') THEN dc.affiliate_number WHEN (contracts.type_dcustomer = 'multicommerce') THEN contracts.dcustomer_multiple END) AS affiliate_number"),
            'cp.description as company',
            'mt.description  as mterminal',
            't.serial as terminal',
            \DB::raw("(CASE WHEN (contracts.valid_simcard = 1) THEN '----' ELSE op.description END) AS operator"),
            \DB::raw("(CASE WHEN (contracts.valid_simcard = 1) THEN 'No Incluida' ELSE s.serial_sim END) AS simcard"),
            'contracts.nropos',
            'contracts.status as status',
            'contracts.status as status_contract',
            'contracts.is_delivery',
            \DB::raw("(CASE WHEN (contracts.is_delivery = 0) THEN '----' ELSE contracts.delivery_date END) AS delivery_date"),
            'bk.description as bank_name',
            'tr.abrev as term',
            \DB::raw(" (CASE WHEN (tr.type_conditions='Tarifa' AND tr.type_conditions1='Fijo') THEN CONCAT('$ ',tr.comission_flatrate)  WHEN (tr.type_conditions='Porcentaje' AND tr.type_conditions1='Fijo') THEN CONCAT(tr.comission_percentage,' %') WHEN (com.type_conditions='Porcentaje') THEN CONCAT(com.value1,'-',com.value2,'-',com.value3,'-',com.value4,'-',com.value5,' %') WHEN (com.type_conditions='Tarifa') THEN CONCAT('$' , com.value1,'-',com.value2,'-',com.value3,'-',com.value4,'-',com.value5) ELSE '----' END) as rate_term"),
            'tr.description as dterm',
            'tr.observations as tobservations',
            \DB::raw("CONCAT(us.name ,' ', us.last_name) as user"),
            \DB::raw("CONCAT(cn.first_name ,' ', cn.last_name) as consultant"),
            'contracts.file_document',
            \DB::raw("(CASE WHEN (contracts.is_affiliate IS NULL AND bk.is_register=1) THEN 'No' WHEN (contracts.is_affiliate IS NOT NULL AND bk.is_register=1) THEN 'Si' ELSE '---' END) AS is_affiliate"),
            \DB::raw("(CASE WHEN (contracts.is_affiliate IS NULL) THEN '----' ELSE contracts.affiliate_date END) AS affiliate_date")
        )
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
            })
            ->leftjoin('companies as cp', 'cp.id', '=', 'contracts.company_id')
            ->leftjoin('terms as tr', 'tr.id', '=', 'contracts.term_id')
            ->leftjoin('comissions as com', 'com.id', '=', 'tr.comission_id')
            ->leftjoin('operators as op', 'op.id', '=', 'contracts.operator_id')
            ->leftjoin('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 'contracts.modelterminal_id');
            })
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('simcards as s', 's.id', '=', 'contracts.simcard_id')
            ->leftjoin('users as us', 'us.id', '=', 'contracts.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'contracts.consultant_id')
            ->distinct('c.id');
    }

    /****************************************************************************/
    public function scopeDocument($query)
    {
        return $query->select('cs.rif', 'cs.business_name', 'cs.address', 'banks.description as bank', 'dc.account_number', 'cs.email', 'cs.telephone', 'cs.mobile', 'mt.description as modelterminal', 'marks.description as mark', 'terminals.serial as terminal', 'terms.abrev as term', 'rc.first_name', 'rc.document')
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('rcustomers as rc', function ($join) {
                $join->on('rc.id', '=', \DB::raw('(SELECT rcustomers.id FROM rcustomers WHERE rcustomers.customer_id=contracts.customer_id LIMIT 1)'));
                $join->whereNull('rc.deleted_at');
            })
            ->leftjoin('banks', function ($join) {
                $join->on('banks.id', '=', 'dc.bank_id');
            })
            ->leftjoin('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
            })
            ->leftjoin('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 'contracts.modelterminal_id');
            })
            ->leftjoin('marks', function ($join) {
                $join->on('marks.id', '=', 'mt.mark_id');
            })
            ->leftjoin('terminals', function ($join) {
                $join->on('terminals.id', '=', 'contracts.terminal_id');
                $join->whereNull('terminals.deleted_at');
            });
    }

    /**************************************************************************/
    public function scopeContractService($query)
    {
        return $query->select(
            \DB::raw("LPAD(contracts.id,7,'0') as contract_id"),
            'contracts.reactive_date',
            'contracts.status as status_contract',
            \DB::raw("LPAD(cs.id,7,'0') as customer_id"),
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN cs.rif WHEN (contracts.type_dcustomer = 'nodom') THEN cs.rif ELSE dc.rif END) as rif"),
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN cs.business_name WHEN (contracts.type_dcustomer = 'nodom') THEN cs.business_name ELSE dc.business_name END) as business_name"),
            \DB::raw("(CASE WHEN (contracts.type_dcustomer = 'commerce') THEN 'Comercio Básico' WHEN (contracts.type_dcustomer = 'nodom') THEN 'Pago No Domiciliado' ELSE 'Multicomercio' END) as commerce"),
            'bk.description as bank',
            'dc.bank_id',
            'dc.affiliate_number as affiliate',
            \DB::raw("(CASE WHEN (dc.type_account = 'Corriente') THEN 'C' ELSE 'A' END) as type_account"),
            \DB::raw("(REPLACE(dc.account_number,'-','')) as account_number"),
            't.serial as terminal',
            'contracts.nropos',
            'terms.description',
            'terms.abrev as term',
            'terms.type_invoice',
            'terms.comission_percentage',
            'terms.prepaid',
            'terms.currency_id',
            \DB::raw("(CASE WHEN (contracts.type_dcustomer='commerce' OR contracts.type_dcustomer='nodom' AND terms.type_conditions='Tarifa' AND terms.type_conditions1='Fijo') THEN FORMAT(terms.comission_flatrate,2) WHEN (co.range_ini1=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value1 WHEN (co.range_ini2=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value2 WHEN (co.range_ini3=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value3 WHEN (co.range_ini4=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value4 WHEN (co.range_ini5=(SELECT COUNT(*) AS total FROM contracts as ct INNER JOIN dcustomers as dc1 ON dc1.customer_id=ct.customer_id AND dc1.multicommerce=1 WHERE ct.id=contracts.id)) THEN co.value5 ELSE '0' END) as amount"),
            \DB::raw("DATE_FORMAT(or.posted_at, '%Y-%m-%d') as order_posted"),
            'supports.date_ini',
            'supports.date_end'
        )
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
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
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
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
            })
            ->whereNotNull('contracts.dcustomer_id');
    }
    /******************************Accesor*****************************************/

    public function getIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getOrderPostedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function getTerminalAttribute($value)
    {
        if ($value != null) {
            return $value;
        }

        return '---';
    }

    public function getSimcardAttribute($value)
    {
        if ($value != null) {
            return $value;
        }

        return '---';
    }

    public function getNroposAttribute($value)
    {
        if ($value != null) {
            return str_pad($value, 3, '0', STR_PAD_LEFT);
        }

        return '---';
    }

    public function getUserAttribute($value)
    {
        if ($value != null) {
            return $value;
        }

        return '---';
    }

    public function getConsultantAttribute($value)
    {
        if ($value != null) {
            return $value;
        }

        return '---';
    }

    public function getStatusAttribute($value)
    {
        $type = 'dark';
        $title = '';
        $content = '';
        if ($value == 'Activo') {
            $title = 'Servicio Activo';
            $content = 'Activo';
            $type = 'success';
        } elseif ($value == 'Pendiente') {
            $title = 'Servicio en Gestión';
            $content = 'Pendiente';
            $type = 'warning';
        } elseif ($value == 'Cancelado') {
            $title = 'Cancelado';
            $content = 'Servicio Cancelado';
            $type = 'dark';
        } elseif ($value == 'Anulado') {
            $title = 'Servicio Anulado';
            $content = 'Anulado';
            $type = 'dark';
        } elseif ($value == 'Suspendido') {
            $title = 'Servicio Suspendido';
            $content = 'Suspendido';
            $type = 'dark';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-1 m-1" title='.$title.' style="color:white;">'.$content.'</span>';
    }

    public function getStatuscAttribute($value)
    {
        $type = 'dark';
        $title = '';
        $content = '';
        if ($value == 'Activo') {
            $title = 'Servicio Activo';
            $content = 'Activo';
            $type = 'success';
        } elseif ($value == 'Pendiente') {
            $title = 'Servicio en Gestión';
            $content = 'Pendiente';
            $type = 'warning';
        } elseif ($value == 'Cancelado') {
            $title = 'Cancelado';
            $content = 'Servicio Cancelado';
            $type = 'dark';
        } elseif ($value == 'Anulado') {
            $title = 'Servicio Anulado';
            $content = 'Anulado';
            $type = 'dark';
        } elseif ($value == 'Suspendido') {
            $title = 'Servicio Suspendido';
            $content = 'Suspendido';
            $type = 'dark';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-1 m-1" title='.$title.' style="color:white;">'.$content.'</span>';
    }
}
