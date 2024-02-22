<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;

    protected $table = 'banks';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'rif', 'description', 'address', 'bank_code', 'is_register', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
