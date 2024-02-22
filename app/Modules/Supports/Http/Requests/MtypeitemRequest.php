<?php

namespace App\Modules\Supports\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MtypeitemRequest extends FormRequest
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
            'managementtype_id' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'managementtype_id.required' => 'Tipo Gestión ATC  es requerido',
            'description.required' => 'Descripción requerida',
        ];
    }
}
