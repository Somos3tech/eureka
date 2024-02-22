<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $primarykey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id', 'state_id', 'abrev', 'description',
    ];
}
