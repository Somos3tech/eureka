<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'description' => 'required|min:5',
            'rif' => 'required|unique:banks',
            'address' => 'required|min:5',
            'bank_code' => 'required|unique:banks',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Nombre Banco es requerido',
            'description.min' => 'Nombre Banco debe ser minimo de 5 caracteres',
            'rif.required' => 'RIF es Requerido',
            'rif.unique' => 'Ya existe un Banco con este RIF',
            'address.required' => 'Dirección es requerida',
            'address.min' => 'Dirección debe ser minimo de 5 caracteres',
            'bank_code.required' => 'Código Banco es requerido',
            'bank_code.unique' => 'Ya existe un Banco con este Código Bancario',
        ];
    }
}
