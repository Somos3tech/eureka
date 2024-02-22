<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyValueUpdateRequest extends FormRequest
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
            'amount' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Valor Divisa es requerida',
            'description.required' => 'Observación requerida',
        ];
    }
}
