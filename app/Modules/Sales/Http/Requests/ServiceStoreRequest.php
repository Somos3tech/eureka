<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            'type_service' => 'required',
            'type_date' => 'required_if:type_service,D',
            'type_biweekly' => 'required_if:type_service,Q',
            'date_invoice' => 'required_if:type_service,Q,M',
            'fechpro' => 'required_if:type_date,date',
            'date_range' => 'required_if:type_date,range',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'bank_id.required' => 'Seleccione Banco',
            'type_invoice.required' => 'Seleccione Tipo Cobranza',
            'type_service.required' => 'Seleccione Servicio Cobranza',
            'type_date.required_if' => 'Seleccione Tipo Fecha',
            'type_biweekly.required_if' => 'Ingrese Ciclo de Cobro',
            'fechpro.required_if' => 'Ingrese Fecha Cobro',
            'date_invoice.required_if' => 'Ingrese Mes de Cobro',
            'date_range.required_if' => 'Ingrese Rango de Cobro',
        ];
    }
}
