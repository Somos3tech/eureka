<?php

namespace App\Modules\Supports\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsupportRequest extends FormRequest
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
            'contract_id' => 'required',
            'type_support' => 'required',
            'observation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contract_id.required' => 'No. Contrato es requerido',
            'type_support.required' => 'Seleccione Tipo Soporte Requerido',
            'observation.required' => 'Observaciónes requerida',
        ];
    }
}
