<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use SoftDeletes;

    protected $table = 'operations';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'type_operation', 'type_service', 'data', 'observations', 'file_operation', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
