<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;

class Raffiliate extends Model
{
    protected $table = 'raffiliates';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'fechpro', 'contract_id', 'dcustomer_id', 'bank_id', 'data', 'observation_response', 'status', 'user_created_id',
    ];

    /******************************************************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }
}
