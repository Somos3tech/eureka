<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'description' => 'required|min:3',
            'business_id' => 'required',
            'typecompany_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Nombre Almacén es Requerido',
            'description.min' => 'Nombre Almacén debe ser minimo de 3 caracteres',
            'business_id.required' => 'Seleccionar Empresa es requerido',
            'typecompany_id.required' => 'Tipo Almacén es requerido',
        ];
    }
}
