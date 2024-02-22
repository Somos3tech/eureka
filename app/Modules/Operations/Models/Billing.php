<?php

namespace App\Modules\Operations\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use SoftDeletes;

    protected $table = 'billings';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'fechpro', 'fechven', 'customer_id', 'rif', 'business_name', 'address', 'telephone', 'observation', 'template', 'dicom', 'dicom_old', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /***********************************Scope**************************************/

    public function scopeQuery($query)
    {
        return $query->select(
            'billings.id',
            'bli.order_id',
            'billings.fechpro',
            \DB::raw("DATE_FORMAT(billings.fechpro, '%Y-%m') AS billing_created"),
            'billings.rif',
            'billings.business_name',
            'companies.description as company',
            'banks.description as bank',
            'dc.affiliate_number',
            'mt.description as modelterminal',
            'billings.dicom',
            'billings.template',
            'op.description as operator',
            'or.status',
            \DB::raw('(CASE WHEN (bli.amount_currency IS NULL) THEN FORMAT(SUM(ROUND(bli.amount/1.16,2)),2) ELSE FORMAT(SUM(ROUND((ROUND((bli.amount_currency/1.16),2)*billings.dicom),2)),2) END) as base'),
            \DB::raw('(CASE WHEN (bli.amount_currency IS NULL) THEN FORMAT(SUM(ROUND(bli.free,2)),2) ELSE FORMAT(SUM(ROUND((ROUND(bli.free,2)*billings.dicom),2)),2) END) as free'),
            \DB::raw('(CASE WHEN (bli.amount_currency IS NULL) THEN FORMAT(SUM(ROUND((bli.amount/1.16)-bli.free,2)),2) ELSE FORMAT(SUM(ROUND((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom,2)),2) END) as base_free'),
            \DB::raw('FORMAT(bli.amount_currency,2) as amount_currency'),
            \DB::raw('(CASE WHEN (bli.amount_currency IS NULL) THEN FORMAT(SUM(ROUND(((bli.amount/1.16)-bli.free)*0.16,2)),2) ELSE FORMAT(SUM(ROUND(((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom)*0.16,2)),2) END) as iva'),
            \DB::raw('(CASE WHEN (bli.amount_currency IS NULL) THEN FORMAT(SUM(ROUND((bli.amount/1.16)-bli.free,2) + ROUND(((bli.amount/1.16)-bli.free)*0.16,2) ),2) ELSE FORMAT( SUM(ROUND((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom,2) + ROUND(((ROUND((bli.amount_currency/1.16),2)-bli.free)*billings.dicom)*0.16,2) ),2) END) as total'),
            'or.status as order_status',
            \DB::raw("(CASE WHEN (cs.city_register IS NOT NULL AND cs.comercial_register IS NOT NULL AND cs.date_register IS NOT NULL AND cs.number_register IS NOT NULL AND cs.took_register IS NOT NULL) THEN '1' ELSE '0' END) AS valid_contract"),
            \DB::raw("CONCAT(us.name,' ',us.last_name) as user_created")
        )
            ->leftjoin('billingitems as bli', function ($join) {
                $join->on('bli.billing_id', '=', 'billings.id');
                $join->whereNull('bli.deleted_at');
            })
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'bli.contract_id');
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
            ->leftjoin('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'ct.id');
                $join->whereNull('or.deleted_at');
            })
            ->leftjoin('companies', function ($join) {
                $join->on('companies.id', '=', 'ct.company_id');
                $join->whereNull('companies.deleted_at');
            })
            ->leftjoin('banks', function ($join) {
                $join->on('banks.id', '=', 'dc.bank_id');
                $join->whereNull('banks.deleted_at');
            })
            ->leftjoin('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 'ct.modelterminal_id');
                $join->whereNull('mt.deleted_at');
            })
            ->leftjoin('operators as op', function ($join) {
                $join->on('op.id', '=', 'ct.operator_id');
                $join->whereNull('op.deleted_at');
            })
            ->leftjoin('users as us', function ($join) {
                $join->on('us.id', '=', 'billings.user_created_id');
                $join->whereNull('us.deleted_at');
            });
    }

    /********************************Accesor***************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function getFechproAttribute($value)
    {
        if ($value != '') {
            return date('d/m/Y', strtotime($value));
        }

        return '----';
    }

    public function getFechAttribute($value)
    {
        if ($value != '') {
            return date('d/m/Y', strtotime($value));
        }

        return '----';
    }
}
