<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultantRequest extends FormRequest
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
            'document_number' => 'required',
            'rif' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'observation' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            'zone' => 'required',
            'user_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'document_number.required' => 'No. Identificación es requerido',
            'document_number.unique' => 'No. Identificación ya se encuentra registrado en el Sistema',
            'rif.required' => 'Rif es requerido',
            'rif.unique' => 'Rif ya se encuentra registrado en el Sistema',
            'first_name.required' => 'Nombre(s) de Asesor es(son) requerido(s)',
            'last_name.required' => 'Apellido(s) de Asesor es(son) requerido(s)',
            'observation.required' => 'Obsevaciones son requeridas',
            'email.required' => 'Email es requerido',
            'email.email' => 'El formato del Email es Inválido',
            'telephone.required' => 'Telefono es requerido',
            'zone.required' => 'Zona(s) de Ventas es requerido',
            'user_id.required' => 'Asesor Asociado es requerido',
        ];
    }
}
