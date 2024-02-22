<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
    use SoftDeletes;

    protected $table = 'terms';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'abrev', 'description', 'observations', 'type_conditions',
        'type_conditions1', 'currency_id', 'comission_flatrate',
        'comission_percentage', 'comission_min', 'comission_id',
        'amount_min', 'amount_max', 'type_invoice', 'prepaid', 'status', 'user_created_id',
        'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /****************************************************************************/
    public function getStatusAttribute($value)
    {
        $type = 'primary';
        if ($value == 'Inactivo') {
            $type = 'dark';
        }
        if ($value == 'Activo') {
            $type = 'success';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-2 m-1">'.$value.'</span>';
    }
}
