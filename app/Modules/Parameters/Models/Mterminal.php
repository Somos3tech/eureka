<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mterminal extends Model
{
    use SoftDeletes;

    protected $table = 'modelterminal';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'mark_id', 'description', 'active', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
