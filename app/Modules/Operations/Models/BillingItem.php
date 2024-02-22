<?php

namespace App\Modules\Operations\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingItem extends Model
{
    use SoftDeletes;

    protected $table = 'billingitems';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'billing_id', 'contract_id', 'invoice_id', 'order_id', 'amount', 'amount_old', 'iva', 'iva_old', 'free', 'free_old', 'amount_sim', 'amount_currency', 'amount_currency_old', 'terminal_id', 'simcard_id', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
