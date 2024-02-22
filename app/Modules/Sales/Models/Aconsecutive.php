<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;

class Aconsecutive extends Model
{
    protected $table = 'aconsecutives';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'fechpro', 'bank_id', 'contract_id', 'refere', 'is_management', 'user_created_id',
    ];
}
