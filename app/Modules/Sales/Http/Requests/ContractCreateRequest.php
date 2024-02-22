<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractCreateRequest extends FormRequest
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
            'customer_id' => 'required',
            'company_id' => 'required',
            'user_id' => 'required',
            'negotiation_id' = 'required',
            'dcustomer_id' => 'sometimes|required',
            'dcustomer_multiple' => 'sometimes|required',
            'term_id' => 'required',
            'modelterminal_id' => 'required',
            'operator_id' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Ingrese ID Cliente',
            'company_id.required'  =>  'Seleccione Empresa',
            'user_id.required' => 'Asesor Venta / Asistente de Ventas',
            'dcustomer_id.required' => 'Seleccione No. Afiliación',
            'negotiation_id.required' => 'Seleccione Modo Negocio',
            'dcustomer_multiple.required' => 'Seleccione No. Afiliación(es)',
            'term_id.required' => 'Seleccione Condiciones Comerciales',
            'modelterminal.required' => 'Seleccione Modelo Terminal',
            'operator_id.required' => 'Seleccione Operador',
        ];
    }
}
