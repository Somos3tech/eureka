<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;

class Rcollection extends Model
{
    protected $table = 'rcollections';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'fechpro', 'bankdocument_id', 'bank_id', 'refere', 'data', 'status', 'user_created_id',
    ];

    /******************************************************************************/
    public function getIdAttribute($value)
    {
        return str_pad($value, 7, '0', STR_PAD_LEFT);
    }

    public function getFechproAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
