<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use SoftDeletes;

    protected $table = 'comissions';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'contract_id', 'invoice_id', 'amount_cancelled',
        'amount_pending', 'user_created_id', 'user_updated_id',
        'created_at', 'updated_at', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
