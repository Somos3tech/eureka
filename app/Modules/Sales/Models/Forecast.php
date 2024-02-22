<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forecast extends Model
{
    use SoftDeletes;

    protected $table = 'forecasts';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'receipt_journey', 'customer_id', 'contract_id', 'bank_id', 'refere', 'fechpro', 'tipcta', 'concept_id', 'rif', 'business_name', 'nrocta', 'nropos', 'tipnot',
        'payment_date', 'type_sale', 'currency_id', 'amount', 'free', 'amount_currency', 'frec_invoice', 'quota', 'lote', 'conceptc', 'conciliation_doc', 'status', 'user_created_id',
        'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
