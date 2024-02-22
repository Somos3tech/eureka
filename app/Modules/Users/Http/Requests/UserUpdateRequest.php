<?php

namespace App\Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|max:191',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'jobtitle' => 'required|max:191',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nombre es requerido',
            'name.max' => 'Nombre es demasiado grande',
            'email.required' => 'Email es requerido',
            'email.unique' => 'Email ya esta registrado a otro Usuario',
            'email.max' => 'Nombre es demasiado grande',
            'jobtitle.required' => 'Cargo es requerido',
            'jobtitle.max' => 'Cargo es demasiado grande',
        ];
    }
}
