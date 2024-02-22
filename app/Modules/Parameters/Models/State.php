<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    protected $primarykey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id', 'abrev', 'description',
    ];
}
