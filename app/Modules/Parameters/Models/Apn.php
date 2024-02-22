<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apn extends Model
{
    use SoftDeletes;

    protected $table = 'apn';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'operator_id', 'description', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
