<?php

namespace App\Modules\Parameters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminalValue extends Model
{
    use SoftDeletes;

    protected $table = 'terminalvalues';

    protected $primarykey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id', 'date_value', 'currency_id', 'modelterminal_id', 'amount_currency', 'amount_local', 'description', 'user_created_id', 'user_updated_id', 'user_deleted_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getDescriptionAttribute($value)
    {
        if ($value != null) {
            return $value;
        }

        return '------';
    }

    public function getAmountLocalAttribute($value)
    {
        $format = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);

        return $format->formatCurrency($value, 'Bs. ');
    }

    public function getAmountCurrencyAttribute($value)
    {
        $format = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);

        return $format->format($value);
    }
}
