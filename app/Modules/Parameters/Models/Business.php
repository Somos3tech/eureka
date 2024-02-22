<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $table = 'business';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'rif', 'name', 'phone', 'address', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
