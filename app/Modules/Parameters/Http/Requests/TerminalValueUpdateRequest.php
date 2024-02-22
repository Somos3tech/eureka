<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalValueUpdateRequest extends FormRequest
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
            'amount_currency' => 'required',
            'amount_local' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'amount_currency.required' => 'Valor Terminal en Divisa es requerida',
            'amount_local.required' => 'Valor Terminal es requerida',
        ];
    }
}
