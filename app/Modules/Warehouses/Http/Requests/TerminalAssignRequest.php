<?php

namespace App\Modules\Warehouses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalAssignRequest extends FormRequest
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
            'company_id' => 'sometimes|required',
            'mterm_id' => 'sometimes|required',
            'file_terminal' => 'required|mimes:xls,xlsx|max:5000',
            'statusc' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => 'Selecciona Zona...',
            'mterm_id.required' => 'Selecciona Modelo Terminal',
            'file_terminal.required' => 'Cargar un Archivo xls, xlsx',
            'file_terminal.max' => 'Archivo no debe ser mayor a 5MB',
            'file_terminal.mimes' => 'El formato del archivo no esta dentro de los admitidos',
            'statusc.required' => 'Seleccionar Status',
        ];
    }
}
