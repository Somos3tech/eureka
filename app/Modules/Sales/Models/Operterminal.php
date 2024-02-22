<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operterminal extends Model
{
    use SoftDeletes;

    protected $table = 'operterminals';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'contract_id', 'type_operation', 'type_service', 'term_id', 'fechpro', 'date_inactive', 'date_reactive', 'term_name', 'serial_terminal', 'observations', 'status', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getStatusAttribute($value)
    {
        $type = 'dark';
        $title = '';
        $content = '';

        if ($value == 'Finalizado') {
            $title = 'Gestión Finalizada';
            $content = 'Finalizado';
            $type = 'success';
        } elseif ($value == 'Pendiente') {
            $title = 'Servicio en Proceso';
            $content = 'Servicio en Proceso';
            $type = 'warning';
        } elseif ($value == 'Anulado') {
            $title = 'Gestión Anulada';
            $content = 'Anulado';
            $type = 'dark';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-1 m-1" title='.$title.' style="color:white;">'.$content.'</span>';
    }
}
