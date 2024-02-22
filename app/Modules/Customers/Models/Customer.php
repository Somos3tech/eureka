<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'foreign_id', 'company_id', 'type_doc', 'ident_number', 'fullname', 'file_document', 'rif', 'business_name', 'type_cont', 'tax', 'cactivity_id', 'state_id', 'city_id', 'municipality', 'address', 'postal_code', 'fiscal', 'state_fiscal_id', 'city_fiscal_id', 'municipality_fiscal',
        'address_fiscal', 'postal_code_fiscal', 'email', 'telephone', 'mobile', 'city_register', 'comercial_register', 'date_register', 'number_register', 'took_register', 'clause_register', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /*****************************Accesor****************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getProfitAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getContractIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getMunicipalityAttribute($value)
    {
        if (! is_null($value)) {
            return $value;
        }

        return '----';
    }

    public function getPostalAttribute($value)
    {
        if (! is_null($value)) {
            return $value;
        }

        return '----';
    }

    public function getTelephoneAttribute($value)
    {
        if (! is_null($value)) {
            return $value;
        }

        return '----';
    }

    public function getTypeDocsAttribute($value)
    {
        switch ($value) {
            case '1':
                return 'Documento Nacional';
                break;

            case '2':
                return 'Pasaporte';
                break;

            case '3':
                return 'RIF';
                break;

            default:
                return 'Documento Nacional';
                break;
        }
    }

    public function getTypeContdAttribute($value)
    {
        switch ($value) {
            case '1':
                return 'Contribuyente Ordinario';
                break;

            case '2':
                return 'Contribuyente Especial';
                break;

            default:
                return 'Contribuyente Ordinario';
                break;
        }
    }

    public function getStatusContractAttribute($value)
    {
        $color = '#FFA500';
        $success = '#0060FF';

        if ($value == 'Pendiente') {
            $title = 'Pendiente';
        }

        if ($value == 'Activo') {
            $title = 'Activo';
            $color = $success;
        }

        return "<a href='#' style='color: ".$color."' data-toggle='popover' data-trigger='focus' title='".$title."' data-content='".$title."'><strong>".$title.'</strong></a>';
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
