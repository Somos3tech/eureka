<?php

namespace App\Modules\Supports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mtypeitem extends Model
{
    use SoftDeletes;

    protected $table = 'mtypeitems';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'managementtype_id', 'description', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
