<?php

namespace App\Modules\Warehouses\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'company_id', 'user_assign_id', 'terminal_id', 'simcard_id', 'observations', 'status', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
