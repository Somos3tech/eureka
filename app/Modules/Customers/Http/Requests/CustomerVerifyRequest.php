<?php

namespace App\Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerVerifyRequest extends FormRequest
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
            'rif' => 'required|unique:customers',
        ];
    }

    public function messages()
    {
        return [
            'rif.unique' => 'Cliente ya se encuentra registrado en el Sistema',
            'rif.required' => 'Rif es requerido',
        ];
    }
}
