<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayerCreateRequest extends FormRequest
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
            'bank_id' => 'required|unique:payers,bank_id,'.$this->get('bank_id').',id,type_file,'.$this->get('type_file').',is_active,1',
            'type_file' => 'required',
            'consecutive' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type_file.required' => 'Tipo Archivo Consecutivo requerido',
            'consecutive.required' => 'No.Consecutivo requerido',
            'bank_id.required' => 'Seleccione Banco',
            'bank_id.unique' => 'No. Consecutivo Banco ya registrado',
        ];
    }
}
