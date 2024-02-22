<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceReportBankRequest extends FormRequest
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
            'type_invoice' => 'required',
            'type_manager' => 'required',
            'type_format' => 'required',
            'type_date' => 'required_if:type_manager,G',
            'fechpro' => 'required_if:type_date,date',
            'date_range' => 'required_if:type_date,range',
            'amount_currency' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'bank_id.required' => 'Seleccione un Banco',
            'type_invoice.required' => 'Seleccione tipo Cobranza',
            'type_manager.required' => 'Seleccione Tipo Gestión',
            'type_format.required' => 'Seleccione Tipo Formato',
            'type_date.required_if' => 'Seleccione Tipo Fecha',
            'fechpro.required_if' => 'Ingrese Fecha',
            'date_range.required_if' => 'Ingrese Rango Fecha',
            'type_manager.required' => 'Seleccione Tipo Gestión',
            'amount_currency.required' => 'Ingrese Tárifa Cambio',
        ];
    }
}
