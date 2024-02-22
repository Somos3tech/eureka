<?php

namespace App\Modules\Supports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    use SoftDeletes;

    protected $table = 'supports';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'contract_id', 'type_invoice', 'type_support', 'date_ini', 'date_end', 'observation', 'tipification_id', 'observation_technical', 'observation_manager', 'procedure_support', 'observation_response', 'observation_delivery', 'data_invoice',
        'terminal_id', 'terminal_new_id', 'delivery', 'status', 'user_created_id', 'user_updated_id', 'user_manager_id', 'user_technical_id', 'user_finalized_id', 'user_delivery_id', 'user_deleted_id', 'technical_at', 'manager_at', 'finalized_at', 'delivery_at',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /********************************Mutator***************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function getTypeSupportAttribute($value)
    {
        if ($value != '') {
            return $value;
        }

        return '----';
    }

    public function getDateIniAttribute($value)
    {
        if ($value != '') {
            return date('d/m/Y', strtotime($value));
        }

        return '----';
    }

    public function getStatusAttribute($value)
    {
        $color = '#FFA500';
        $success = '#0060FF';

        if ($value == 'G') {
            $title = 'Generado';
            $color = '#020202';
        } elseif ($value == 'T') {
            $title = 'Gestión Técnica';
        } elseif ($value == 'M') {
            $title = 'Gestión Cliente';
        } elseif ($value == 'F') {
            $title = 'Gestión Finalizada';
            $color = $success;
        } elseif ($value == 'C') {
            $title = 'Entregado Cliente';
            $color = $success;
        } elseif ($value == 'X') {
            $title = 'Cancelado';
            $color = '#695351';
        }

        return "<a href='#' style='color: ".$color."' data-toggle='popover' data-trigger='focus' title='".$title."' data-content='".$title."'><strong>".$title.'</strong></a>';
    }

    public function getDateTechnicalAttribute($value)
    {
        if ($value != '') {
            return date('Y-m-d', strtotime($value));
        }

        return '----';
    }

    public function getDateManagerAttribute($value)
    {
        if ($value != '') {
            return date('Y-m-d', strtotime($value));
        }

        return '----';
    }

    public function getDateFinalizedAttribute($value)
    {
        if ($value != '') {
            return date('Y-m-d', strtotime($value));
        }

        return '----';
    }

    public function getDateDeliveryAttribute($value)
    {
        if ($value != '') {
            return date('Y-m-d', strtotime($value));
        }

        return '----';
    }
}
