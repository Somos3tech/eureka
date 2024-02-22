<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adomiciliation extends Model
{
    use SoftDeletes;

    protected $table = 'adomiciliations';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'bank_id', 'type_management', 'date_ini', 'date_end',
        'file_bank', 'file_response_bank', 'send_email', 'data_email', 'observation', 'data', 'status',
        'user_created_id', 'user_updated_id', 'user_deleted_id', 'user_upload_id', 'upload_at', 'user_send_id', 'send_at',
        'user_process_id', 'process_at',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getStatusButtonAttribute($value)
    {
        $type = 'warning';
        $title = 'No Asignado';

        if ($value == 'Generado') {
            $title = 'Generado';
            $type = 'info';
        } elseif ($value == 'Enviado') {
            $title = 'Enviado';
            $type = 'warning';
        } elseif ($value == 'Cargado') {
            $title = 'Cargado';
            $type = 'dark';
        } elseif ($value == 'Anulado') {
            $title = 'Anulado';
            $type = 'danger';
        } elseif ($value == 'Procesado') {
            $title = 'Procesado';
            $type = 'success';
        }

        return '<span style="color: white;" class="badge badge-pill badge-'.$type.' p-1 m-1">'.$title.'</span>';
    }
}
