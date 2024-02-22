<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultantUpdateRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'observation' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            'zone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Nombre(s) de Asesor es(son) requerido(s)',
            'last_name.required' => 'Apellido(s) de Asesor es(son) requerido(s)',
            'observation.required' => 'Obsevaciones son requeridas',
            'email.required' => 'Email es requerido',
            'email.email' => 'El formato del Email es Inválido',
            'telephone.required' => 'Telefono es requerido',
            'zone.required' => 'Zona(s) de Ventas es requerido',
        ];
    }
}
