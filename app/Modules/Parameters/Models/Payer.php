<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payer extends Model
{
    use SoftDeletes;

    protected $table = 'payers';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'bank_id', 'type_file', 'consecutive', 'is_active', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
