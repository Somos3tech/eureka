<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comission extends Model
{
    use SoftDeletes;

    protected $table = 'comissions';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'description', 'observation', 'type_condition',
        'range1', 'value1', 'range2', 'value2',
        'range3', 'value3', 'range4', 'value4',
        'range5', 'value5', 'status',
        'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
