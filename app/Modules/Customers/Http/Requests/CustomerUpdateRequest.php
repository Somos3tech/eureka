<?php

namespace App\Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'type_contract' => 'required',
            'company_id' => 'required',
            'rif' => 'required', //|unique:customers,rif,'.(int)$this->id
            'business_name' => 'required',
            'cactivity_id' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'municipality' => 'required',
            'address' => 'required|max:191',
            'postal_code' => 'required',
            'state_fiscal_id' => 'sometimes|required',
            'city_fiscal_id' => 'sometimes|required',
            'municipality_fiscal' => 'sometimes|required',
            'address_fiscal' => 'sometimes|required',
            'postal_code_fiscal' => 'sometimes|required',
            'type_cont' => 'required',
            'tax' => 'sometimes|required_if:type_cont,2',
            'city_register' => 'sometimes|required',
            'comercial_register' => 'sometimes|required',
            'date_register' => 'sometimes|required',
            'number_register' => 'sometimes|required',
            'took_register' => 'sometimes|required',
            'clause_register' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'type_contract.required' => 'Tipo de Ingreso de Venta es Requerido',
            'company_id.required' => 'Zona Venta es requerida',
            'rif.required' => 'RIF es requerido',
            'rif.unique' => 'RIF ya se encuentra registrado en el sistema',
            'business_name.required' => 'Nombre de Comercio es requerido',
            'cactivity_id.required' => 'Actividad Económica es requerida',
            'email.required' => 'Correo es requerido',
            'mobile.required' => 'Mobile es requerido',
            'state_id.required' => 'Estado es requerido',
            'city_id.required' => 'Ciudad es requerida',
            'municipality.required' => 'Municipio es requerido',
            'address.required' => 'Dirección es requerida',
            'postal_code.required' => 'Codigo Postal es requerido',
            'state_fiscal_id.required' => 'Estado es requerido',
            'city_fiscal_id.required' => 'Ciudad es requerida',
            'municipality_fiscal.required' => 'Municipio es requerido',
            'address_fiscal.required' => 'Dirección es requerida',
            'postal_code_fiscal.required' => 'Codigo Postal es requerido',
            'type_cont.required' => 'Tipo Contribuyente es requerido',
            'tax.required' => '% Retención IVA es requerido',
            'city_register.required' => 'Ciudad de Registro Mercantíl es requerido',
            'comercial_register.required' => 'Registro Mercantíl es requerido',
            'date_register.required' => 'Fecha Registro Mercantíl es requerida',
            'number_register.required' => 'Número Registro Mercantíl es requerido',
            'took_register.required' => 'Tomo Registro Mercantíl es requerido',
            'clause_register.required' => 'No. Clausula Mercantíl es requerida',
        ];
    }
}
