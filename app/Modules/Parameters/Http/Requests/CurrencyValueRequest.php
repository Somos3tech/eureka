<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyValueRequest extends FormRequest
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
            'date_value' => 'required', //'date_value' => 'required|unique_with:currencyvalues,currency_id,'.$this->currency_id,
            'amount' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'currency_id.required' => 'Denominación Divisa es requerida',
            'date_value.required' => 'Fecha es requerida',
            'amount.required' => 'Valor Divisa es requerida',
            'description.required' => 'Observación requerida',
        ];
    }
}
