<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    use SoftDeletes;

    protected $table = 'operators';

    protected $primarykey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id', 'description', 'is_simcard', 'observations', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
