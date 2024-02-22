<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
            'rif' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'rif.required' => 'RIF es Requerido',
            'name.required' => 'Nombre es requerido',
            'address.required' => 'Dirección es Requerida',
            'phone.required' => 'Teléfono es requerido',
        ];
    }
}
