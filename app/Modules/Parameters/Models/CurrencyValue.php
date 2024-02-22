<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyValue extends Model
{
    use SoftDeletes;

    protected $table = 'currencyvalues';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'date_value', 'currency_id', 'amount', 'description', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getAmountAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getDicomAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getDescriptionAttribute($value)
    {
        if ($value != null) {
            return $value;
        }

        return '------';
    }
}
