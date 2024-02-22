<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleCreateRequest extends FormRequest
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
            'rif' => 'required',
            'business_name' => 'required',
            'customer_id' => 'required',
            'company_id' => 'required',
            'modelterminal_id' => 'required',
            'operator_id' => 'sometimes|required',
            'observation' => 'required',
            'dcustomer_id' => 'sometimes|required',
            'term_id' => 'required',
            'user_id' => 'required',
            'refere' => 'sometimes|required',
            'currency_id' => 'required',
            'pmethod_id' => 'sometimes|required',
            'amount' => 'sometimes|required',
            'amountm' => 'sometimes|required',
            'dicom' => 'required',
            'payment_path' => 'sometimes|required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'rif.required' => 'Ingrese RIF del Comercio',
            'business_name' => 'Ingrese Nombre de Comercio',
            'customer_id.required' => 'Ingrese ID Cliente',
            'company_id.required' => 'Seleccione Empresa',
            'dcustomer_id.required' => 'Seleccione No. Afiliación',
            'modelterminal.required' => 'Seleccione Modelo Terminal',
            'operator_id.required' => 'Seleccione Operador',
            'oservation.required' => 'Observación es requerida',
            'term_id.required' => 'Seleccione Condiciones Comerciales',
            'user_id.required' => 'Seleccionar Asesor Venta',
            'refere.required' => 'Ingrese referencias de Cobro',
            'currency_id.required' => 'Seleccione Tipo Divisa',
            'pmethod_id.required' => 'Seleccione Método Pago',
            'amount.required' => 'Ingrese Monto',
            'amountm.required' => 'Ingrese Monto',
            'dicom.required' => 'Ingrese Tarifa de Cambio',
            'payment_path.required' => 'Seleccione Archivo PDF x Cargar como Soporte de Pago',

        ];
    }
}
