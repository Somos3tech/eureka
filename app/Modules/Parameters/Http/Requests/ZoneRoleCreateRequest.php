<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoneRoleCreateRequest extends FormRequest
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
            'role_id' => 'required|unique:zone_role',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'Perfil es Requerido',
            'role_id.unique' => 'Perfil ya esta registrado',
        ];
    }
}
