<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency_id' => 'required',
            'modelterminal_id' => 'required',
            'date_value' => 'required',
            'amount_currency' => 'required',
            'amount_local' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'currency_id.required' => 'Denominación Divisa es requerida',
            'modelterminal_id.required' => 'Modelo Terminal es requerido',
            'date_value.required' => 'Fecha es requerida',
            'amount_currency.required' => 'Valor Terminal en Divisa es requerida',
            'amount_local.required' => 'Valor Terminal es requerida',
            'description.required' => 'Observación requerida',
        ];
    }
}
