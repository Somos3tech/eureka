<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultant extends Model
{
    use SoftDeletes;

    protected $table = 'consultants';

    protected $primarykey = 'id';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'document_number', 'rif', 'first_name', 'last_name', 'email', 'observation', 'zone', 'telephone',
        'status', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
