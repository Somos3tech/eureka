<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcconceptRequest extends FormRequest
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
            'order' => 'required|min:2',
            'name' => 'required|min:5',
        ];
    }

    public function messages()
    {
        return [
            'order.required' => 'Ingrese Código Cuenta',
            'order.min' => 'Código Contable debe ser minimo de 2 caracteres',
            'name.required' => 'Descripción Nombre de Cuenta es requerida',
            'name.min' => 'Nombre de Cuenta debe ser minimo de 5 caracteres',
        ];
    }
}
