<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CactivityRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Nombre Actividad Comercial es Requerida',
            'description.min' => 'Nombre Actividad Comercial debe ser minimo de 3 caracteres',
        ];
    }
}
