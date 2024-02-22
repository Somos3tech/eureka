<?php

namespace App\Modules\Warehouses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Simcard extends Model
{
    use SoftDeletes;

    protected $table = 'simcards';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'company_id', 'operator_id', 'number_mobile', 'apn_id', 'serial_sim', 'status', 'user_created_id', 'user_updated_id', 'user_assignated_id', 'user_posted_id', 'assignated_at', 'posted_at', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
