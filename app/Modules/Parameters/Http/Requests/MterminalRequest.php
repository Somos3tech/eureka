<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MterminalRequest extends FormRequest
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
            'mark_id' => 'required',
            'description' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'mark_id.required' => 'Selecciona una Marca',
            'description.required' => 'Modelo Terminal es Requerido',
            'description.min' => 'Modelo Terminal debe ser minimo de 3 caracteres',
        ];
    }
}
