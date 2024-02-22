<?php

namespace App\Modules\Warehouses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terminal extends Model
{
    use SoftDeletes;

    protected $table = 'terminals';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'fechpro', 'company_id', 'modelterminal_id', 'serial', 'user_created_id', 'user_updated_id', 'user_assignated_id', 'user_posted_id', 'user_deleted_id', 'assignated_at', 'posted_at', 'status',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
