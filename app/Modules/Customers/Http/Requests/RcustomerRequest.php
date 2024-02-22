<?php

namespace App\Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RcustomerRequest extends FormRequest
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
            'ident_number' => 'required',
            'first_name' => 'required',
            'jobtitle' => 'required',
            'email' => 'required',
            'telephone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ident_number.required' => 'No. Identificación es requerido',
            'first_name.required' => 'Nombres son requeridos',
            'jobtitle.required' => 'Cargo es requerido',
            'email.required' => 'Email es requerido',
            'telephone.required' => 'Teléfono es requerido',
        ];
    }
}
