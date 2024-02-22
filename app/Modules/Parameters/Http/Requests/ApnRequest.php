<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApnRequest extends FormRequest
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
            'operator_id' => 'required',
            'description' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'operator_id.required' => 'Selecciona Operador Movíl',
            'description.required' => 'Nombre APN es Requerido',
            'description.min' => 'Nombre APN debe ser minimo de 3 caracteres',

        ];
    }
}
