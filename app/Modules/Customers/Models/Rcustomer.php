<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rcustomer extends Model
{
    use SoftDeletes;

    protected $table = 'rcustomers';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'customer_id', 'document', 'first_name', 'jobtitle', 'email', 'telephone', 'file_document', 'user_created_id', 'user_updated_id', 'user_deleted_id',
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
