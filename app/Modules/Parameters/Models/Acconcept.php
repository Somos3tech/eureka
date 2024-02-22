<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acconcept extends Model
{
    use SoftDeletes;

    protected $table = 'acconcepts';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'name', 'parent_id', 'codcta', 'tipmon', 'forma_pago', 'order', 'statusc', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function childs()
    {
        return $this->hasMany('App\Modules\Parameters\Models\Acconcept', 'parent_id', 'id');
    }
    /*********************************Accesor************************************/
}
