<?php

namespace App\Modules\Supports\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagementtypeUpdateRequest extends FormRequest
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
            'slug' => 'required|unique:managementtypes,slug,'.(int) $this->id,
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => 'Abreviatura ya registrada',
            'slug.required' => 'Abreviatura requerida',
            'description.required' => 'Descripción requerida',
        ];
    }
}
