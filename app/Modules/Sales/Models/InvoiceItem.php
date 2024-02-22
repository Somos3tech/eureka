<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use SoftDeletes;

    protected $table = 'invoiceitems';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'invoice_id', 'fechpro', 'currency_id', 'item', 'concept', 'amount', 'amount_currency', 'date_expire', 'status', 'user_created_id',
        'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getInvoiceIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getFechproAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getItemAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return '---';
    }

    public function getCurrencyAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return '---';
    }

    public function getDateExpireAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return '---';
    }
}
