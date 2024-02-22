<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneRole extends Model
{
    protected $table = 'zone_role';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'role_id', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
