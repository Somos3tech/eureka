<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use SoftDeletes;

    protected $table = 'collections';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'invoice_id', 'invoiceitem_id', 'fechpro', 'tipnot', 'acconcept_id', 'refere', 'currency_id', 'dicom', 'amount_currency', 'amount', 'description', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /******************************************************************************/
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
}
