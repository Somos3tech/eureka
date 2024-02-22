<?php

namespace App\Modules\Warehouses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimcardAssignRequest extends FormRequest
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
            'operator_id' => 'sometimes|required',
            'file_simcard' => 'required|mimes:xls,xlsx|max:5000',
            'statusc' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'operator_id.required' => 'Seleccionar Operador...',
            'company_id.required' => 'Seleccionar una Zona',
            'file_simcard.required' => 'Cargar un Archivo xls, xlsx',
            'file_simcard.max' => 'Archivo no debe ser mayor a 2MB',
            'file_simcard.mimes' => 'El formato del archivo no esta dentro de los admitidos',
            'statusc.required' => 'Seleccionar Status',
        ];
    }
}
