<?php

namespace App\Modules\Operations\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'contract_id', 'invoice_id', 'observ_credicard', 'observ_programmer', 'type_posted', 'number_control', 'date_send', 'observ_posted', 'credicard', 'status', 'canceledOrder_id', 'user_created_id', 'user_updated_id', 'programmer_user_id', 'receive_store_id', 'billing_user_id', 'assign_office_id', 'posted_user_id', 'user_deleted_id', 'programmer_at', 'programmer_finish_at', 'receive_store_at', 'billing_at', 'assign_office_at', 'posted_at',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /***********************************Scope************************************/
    public function scopeQuery($query)
    {
        return $query->select(
            'orders.id',
            'orders.id as order_id',
            'ct.dcustomer_id',
            'inv.id as invoice_id',
            'inv.type_sale',
            'inv.tipnot',
            'cs.id as customer_id',
            'cs.rif as rif',
            'cs.business_name',
            'states.description as state',
            'cities.description as city',
            'cs.address',
            'cs.postal_code',
            'cs.telephone',
            'cs.mobile',
            'cs.email',
            'ct.id as contract_id',
            'ct.type_dcustomer',
            'ct.dcustomer_multiple',
            'ct.created_at as created_contract',
            'ct.valid_simcard',
            /**
             * ! Alcides Da Silva
             * ! - Fecha: 18/11/2021
             */
            'ct.terminal_id',
            'ster.serial as sterminal',
            'cp.description as company',
            'bk.description as bank',
            'dc.affiliate_number',
            'tr.description as term',
            'ct.modelterminal_id as mterminal_id',
            'mt.description as modelterminal',
            'ct.company_id as company_id',
            \DB::raw(" (CASE WHEN (t.serial  IS NULL) THEN '----' ELSE t.serial END) as terminal"),
            't.id as terminal_id',
            'ct.operator_id as operator_id',
            'op.is_simcard',
            \DB::raw(" (CASE WHEN (ct.valid_simcard = 1) THEN 'No Incluida' ELSE op.description END) as operator"),
            \DB::raw(" (CASE WHEN (s.serial_sim  IS NULL) THEN '----' ELSE s.serial_sim END) as simcard"),
            's.id as simcard_id',
            \DB::raw(" (CASE WHEN (ct.nropos IS NULL) THEN '----' ELSE LPAD(ct.nropos, 3, '0') END) as nropos"),
            \DB::raw(' FORMAT(ct.amount ,2) as amount_contract'),
            \DB::raw(" (CASE WHEN (ct.observation IS NULL) THEN '----' ELSE ct.observation END) as observation_contract"),
            'ct.status as status_contract',
            \DB::raw(" (CASE WHEN (CONCAT(us.name,' ', us.last_name) IS NULL) THEN '----' ELSE CONCAT(us.name,' ', us.last_name) END) as user_name"),
            \DB::raw(" (CASE WHEN (CONCAT(cn.first_name,' ', cn.last_name) IS NULL) THEN 'Ningún Aliado Comercial' ELSE CONCAT(cn.first_name,' ', cn.last_name) END) as consultant_name"),
            'orders.observ_credicard as management',
            \DB::raw(" (CASE WHEN (orders.observ_credicard IS NULL) THEN '----' ELSE orders.observ_credicard END) as observ_credicard"),
            \DB::raw(" (CASE WHEN (orders.observ_programmer IS NULL) THEN '----' ELSE orders.observ_programmer END) as observ_programmer"),
            \DB::raw(" (CASE WHEN (orders.observ_posted IS NULL) THEN '----' ELSE orders.observ_posted END) as observ_posted"),
            'orders.credicard',
            'orders.credicard as valid_credicard',
            'orders.canceledOrder_id',
            'orders.created_at as created_order',
            \DB::raw(" (CASE WHEN (CONCAT(usor.name,' ', usor.last_name)  IS NULL) THEN '----' ELSE CONCAT(usor.name,' ', usor.last_name)  END) as user_created_order"),
            \DB::raw(" (CASE WHEN (orders.updated_at IS NULL) THEN '----' ELSE orders.updated_at END) as updated_order"),
            \DB::raw("(CASE WHEN (orders.status='P' && ct.terminal_id IS NULL) THEN 'P' WHEN (orders.status='P' && ct.terminal_id IS NOT NULL) THEN 'PI' ELSE orders.status END) AS status"),
            \DB::raw("(CASE WHEN (orders.status='P' && ct.terminal_id IS NULL) THEN 'P' WHEN (orders.status='P' && ct.terminal_id IS NOT NULL) THEN 'PI' ELSE orders.status END) AS status_order"),
            \DB::raw(" (CASE WHEN (orders.programmer_at IS NULL) THEN '----' ELSE orders.programmer_at END) as programmer"),
            \DB::raw(" (CASE WHEN (orders.programmer_finish_at IS NULL) THEN '----' ELSE orders.programmer_finish_at END) as programmer_finish"),
            \DB::raw(' (CASE WHEN (inv.currency_id = 1) THEN inv.amount ELSE (inv.amount * inv.amount_currency) END) as amount_invoice'),
            \DB::raw(" (CASE WHEN (CONCAT(usp.name,' ', usp.last_name) IS NULL) THEN '----' ELSE CONCAT(usp.name,' ', usp.last_name) END) as user_programmer"),
            'orders.posted_at as posted',
            \DB::raw(" (CASE WHEN (CONCAT(uspo.name,' ', uspo.last_name)  IS NULL) THEN '----' ELSE CONCAT(uspo.name,' ', uspo.last_name)  END) as user_posted"),
            \DB::raw("(CASE WHEN (cs.city_register IS NOT NULL AND cs.comercial_register IS NOT NULL AND cs.date_register IS NOT NULL AND cs.number_register IS NOT NULL AND cs.took_register IS NOT NULL) THEN '1' ELSE '0' END) AS valid_contract"),
            'csupports.id as csupport_id',
            \DB::raw(" (CASE WHEN (CONCAT(usc.name,' ', usc.last_name) IS NULL) THEN '----' ELSE CONCAT(usc.name,' ', usc.last_name) END) as user_csupport"),
            'csupports.observation as observation_csupport',
            \DB::raw(" (CASE WHEN (orders.date_send IS NULL) THEN '----' ELSE orders.date_send END) as date_send"),
            \DB::raw(" (CASE WHEN (orders.number_control IS NULL) THEN '----' ELSE orders.number_control END) as number_control"),
            \DB::raw(" (CASE WHEN (orders.type_posted IS NULL) THEN '----' ELSE orders.type_posted END) as type_posted")
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            /**
             * ! Alcides Da Silva
             * * Busqueda de serial de terminal
             */
            ->leftjoin('terminals as ster', function ($join) {
                $join->on('ct.terminal_id', '=', 'ster.id');
            })
            ->leftjoin('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->leftjoin('invoices as inv', function ($join) {
                $join->on('inv.contract_id', '=', 'orders.contract_id');
                $join->whereIn('inv.status', ['C', 'P']);
                $join->where('inv.concept_id', 1);
                $join->whereNull('inv.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'ct.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('companies as cp', 'cp.id', '=', 'ct.company_id')
            ->leftjoin('terms as tr', 'tr.id', '=', 'ct.term_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'ct.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->leftjoin('operators as op', 'op.id', '=', 'ct.operator_id')
            ->leftjoin('simcards as s', function ($join) {
                $join->on('s.id', '=', 'ct.simcard_id');
                $join->whereNull('s.deleted_at');
            })
            ->leftjoin('csupports', function ($join) {
                $join->on('csupports.contract_id', '=', 'orders.contract_id');
                $join->where('csupports.status', 'LIKE', 'G');
                $join->whereNull('csupports.deleted_at');
            })
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'cs.city_id')
            ->leftjoin('users as usor', 'usor.id', '=', 'orders.user_created_id')
            ->leftjoin('users as usp', 'usp.id', '=', 'orders.programmer_user_id')
            ->leftjoin('users as uspo', 'uspo.id', '=', 'orders.posted_user_id')
            ->leftjoin('users as us', 'us.id', '=', 'ct.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'ct.consultant_id')
            ->leftjoin('users as usc', 'usc.id', '=', 'csupports.user_created_id');
    }

    /********************************Accesor*************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    /****************************************************************************/
    public function getCustomerIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    /****************************************************************************/
    public function getContractIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    /****************************************************************************/
    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /****************************************************************************/
    public function getUpdatedAtAttribute($value)
    {
        if ($value != '') {
            return date('d/m/Y', strtotime($value));
        }

        return '----';
    }

    /****************************************************************************/
    public function getPostedAttribute($value)
    {
        if ($value != null) {
            return date('Y-m-d', strtotime($value));
        }

        return '----';
    }

    /****************************************************************************/
    public function getManagementAttribute($value)
    {
        if ($value != null) {
            return '<span><i class="i-Yes"></i> <b><br>Gestión Equipo</b></span>';
        }

        return  '---';
    }

    /****************************************************************************/
    public function getCredicardAttribute($value)
    {
        if ($value != null) {
            return '<span><i class="i-Yes"></i> <b>Notificado</b></span>';
        }

        return  '---';
    }
    /****************************************************************************/

    /****************************************************************************/
    public function getStatusOrderAttribute($value)
    {
        $type = 'dark';
        $title = '';
        $content = '';

        if ($value == 'P') {
            $type = 'dark';
            $title = 'Programación Sin Gestión';
        } elseif ($value == 'PI') {
            $type = 'warning';
            $title = 'Programación Inicial';
        } elseif ($value == 'PF') {
            $type = 'success';
            $title = 'Programación Finalizada';
        } elseif ($value == 'D') {
            $type = 'info';
            $title = 'Despacho';
        } elseif ($value == 'C') {
            $type = 'success';
            $title = 'Entregado';
        } elseif ($value == 'S') {
            $type = 'dark';
            $title = 'Soporte';
        } elseif ($value == 'X') {
            $type = 'danger';
            $title = 'Anulado';
        }

        return '<span class="badge badge-pill badge-' . $type . ' p-1 m-1" title=' . $title . ' style="color:white;">' . $title . '</span>';
    }
}
