<?php

namespace App\Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
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
            'name' => 'required|unique:permissions,name,'.(int) $this->id,
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Permiso es requerido',
            'name.unique' => 'Permiso ya esta registrado',
            'description.required' => 'Nombre Permiso es requerido',
        ];
    }
}
