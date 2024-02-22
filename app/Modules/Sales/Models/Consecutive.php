<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;

class Consecutive extends Model
{
    protected $table = 'consecutives';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'fechpro', 'bank_id', 'invoice_id', 'consecutive', 'is_management', 'user_created_id',
    ];
}
