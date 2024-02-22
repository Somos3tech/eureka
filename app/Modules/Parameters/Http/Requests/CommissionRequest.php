<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//Repository Comission dentro de Modulo

class CommissionRequest extends FormRequest
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
        $rules = [
            'description' => 'required|unique:comissions|min:3',
            'observations' => 'required|min:3',
            'type_condition' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $message = [
            'description.unique' => 'Nombre Comisión ya existe',
            'description.required' => 'Nombre Comisión es requerido',
            'description.min' => 'Nombre Comisión debe ser minimo de 3 caracteres',
            'observations.required' => 'Observación es requerida',
            'observations.min' => 'Observación debe ser minimo de 3 caracteres',
            'type_condition.required' => 'Tipo Comisión es Requerido',
        ];

        return $message;
    }
}
