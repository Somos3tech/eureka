<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bankdocument extends Model
{
    use SoftDeletes;

    protected $table = 'bankdocuments';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'fechpro', 'amount_currency', 'bank_id', 'data', 'name_file', 'observation', 'status', 'user_created_id',
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
