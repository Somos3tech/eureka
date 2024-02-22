<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'companies';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'business_id', 'description', 'typecompany_id', 'is_wholesaler', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getDescriptionAttribute($value)
    {
        if (! is_null($value)) {
            return $value;
        }

        return '----';
    }
}
