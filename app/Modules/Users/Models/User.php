<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zone_id', 'document', 'name', 'last_name', 'email', 'password', 'jobtitle', 'company_id', 'banklist', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /****************************************************************************/
    public function getStatusAttribute($value)
    {
        $type = 'primary';
        if ($value == 'Inactivo') {
            $type = 'dark';
        }
        if ($value == 'Activo') {
            $type = 'success';
        }

        return '<span class="badge badge-pill badge-'.$type.' p-2 m-1">'.$value.'</span>';
    }
}
