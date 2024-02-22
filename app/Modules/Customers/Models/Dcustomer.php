<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dcustomer extends Model
{
    use SoftDeletes;

    protected $table = 'dcustomers';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'customer_id', 'multicommerce', 'rif', 'business_name', 'bank_id', 'affiliate_number', 'type_account', 'account_number', 'valid_bank', 'personal_signature', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
