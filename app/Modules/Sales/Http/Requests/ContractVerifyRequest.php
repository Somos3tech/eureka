<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractVerifyRequest extends FormRequest
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
            'rif' => 'required|exists:customers',
        ];
    }

    public function messages()
    {
        return [
            'rif.exists' => 'Cliente no se encuentra registrado en el Sistema',
            'rif.required' => 'RIF es requerido',
        ];
    }
}
