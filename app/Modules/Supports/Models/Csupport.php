<?php

namespace App\Modules\Supports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Csupport extends Model
{
    use SoftDeletes;

    protected $table = 'csupports';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'contract_id', 'type_support', 'observation', 'observation_response', 'status', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    ////////////////////////////Accesors///////////////////////////////////////////
    public function getIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function getTypeSupportAttribute($value)
    {
        if ($value == 'contract') {
            $data = 'Cambio Información Contrato';
        }

        if ($value == 'invoice') {
            $data = 'Cambio Soporte Pago x Cobro';
        }

        if ($value == 'customer') {
            $data = 'Cambio Información Cliente';
        }

        return $data;
    }

    public function getstatusAttribute($value)
    {
        if ($value == 'G') {
            $data = 'Generado';
        }

        if ($value == 'F') {
            $data = 'Finalizado';
        }

        if ($value == 'X') {
            $data = 'Anulado';
        }

        return $data;
    }

    /*****************************Accesor****************************************/
    public function getContractIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
