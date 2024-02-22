<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConceptRequest extends FormRequest
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
            'abrev' => 'required|min:3|unique:concepts',
            'description' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'abrev.unique' => 'Abreviatura ya esta registrada',
            'abrev.min' => 'Abreviatura debe ser minimo de 3 caracteres',
            'abrev.required' => 'Abreviatura es Requerida',
            'description.required' => 'Concepto Servicio es Requerido',
            'description.min' => 'Concepto Servicio debe ser minimo de 3 caracteres',
        ];
    }
}
