<?php

namespace App\Modules\Supports\Models;

use Illuminate\Database\Eloquent\Model;

class Atcmessage extends Model
{
    protected $table = 'atcmessages';

    protected $primarykey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id', 'atc_id', 'message', 'user_created_id', 'created_at',
    ];
}
