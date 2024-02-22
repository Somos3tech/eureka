<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceBankRequest extends FormRequest
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
        $rules = [
            'bank_id' => 'required',
            'fechpro' => 'required_if:type_date,date',
            'date_range' => 'required_if:type_date,range',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'bank_id.required' => 'Seleccione un Banco',
            'fechpro.required_if' => 'Ingrese Fecha',
            'date_range.required_if' => 'Ingrese Rango Fecha',
        ];
    }
}
