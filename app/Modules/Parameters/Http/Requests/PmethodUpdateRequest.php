<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PmethodUpdateRequest extends FormRequest
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
            'slug' => 'required|min:3|unique:pmethods,slug,'.(int) $this->id,
            'description' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => 'Slug ya se enceuntra registrado',
            'slug.required' => 'Slug es Requerido',
            'slug.min' => 'Slug debe ser minimo de 3 caracteres',
            'description.required' => 'Descripción Método Pago es Requerido',
            'description.min' => 'Descripción Método Pago debe ser minimo de 3 caracteres',
        ];
    }
}
