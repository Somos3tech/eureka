<?php

namespace App\Modules\Supports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atc extends Model
{
    use SoftDeletes;

    protected $table = 'atcs';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'channel_id', 'customer_id', 'rif', 'first_name', 'last_name', 'telephone', 'mobile', 'email', 'managementtype_id', 'mtypeitem_id', 'contract_id', 'observation', 'observation_manager', 'status', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /****************************************************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    /****************************************************************************/
    public function getStatusAttribute($value)
    {
        $type = 'dark';
        $title = '';
        if ($value == 'G') {
            $type = 'info';
            $title = 'Generado';
        }

        if ($value == 'P') {
            $type = 'warning';
            $title = 'En Proceso';
        }

        if ($value == 'F') {
            $type = 'success';
            $title = 'Procesado';
        }

        if ($value == 'X') {
            $type = 'dark';
            $title = 'Anulado';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-1 m-1" title='.$title.' style="color:white;">'.$title.'</span>';
    }

    /****************************************************************************/
    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /****************************************************************************/
    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
