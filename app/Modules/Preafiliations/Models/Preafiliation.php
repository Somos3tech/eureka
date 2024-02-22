<?php

namespace App\Modules\Preafiliations\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preafiliation extends Model
{
    use SoftDeletes;

    protected $table = 'preafiliations';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'company_id', 'rif', 'is_customer', 'data_customer', 'document_rif', 'is_rif',
        'data_rcustomer', 'data_mercantil', 'document_mercantil', 'is_mercantil',
        'data_bank', 'document_bank', 'is_bank', 'autorization_bank', 'is_auth_bank', 'data_contract', 'data_payment',
        'document_payment', 'observation_initial', 'observations', 'observations_sale', 'is_payment', 'status', 'user_created_id', 'consultant_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /****************************************************************************/
    public function getStatusPreafiliationAttribute($value)
    {
        $type = 'dark';
        if ($value == 'Cargado') {
            $type = 'info';
        }
        if ($value == 'Procesado') {
            $type = 'success';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-2 m-1">'.$value.'</span>';
    }
}
