<?php

namespace App\Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DcustomerUpdateRequest extends FormRequest
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
            'checkbox' => 'sometimes',
            'rif' => 'required_with:checkbox',
            'business_name' => 'required_with:checkbox',
            'affiliate_number' => 'required|unique:dcustomers,affiliate_number,'.$this->get('id').',id,deleted_at,null',
            'bank_id' => 'required',
            'account_number' => 'required|min:23',
        ];
    }

    public function messages()
    {
        return [
            'rif.required_with' => 'Ingrese RIF',
            'business_name.required_with' => 'Ingrese Nombre Comercio',
            'affiliate_number.required' => 'No. Afiliación es requerida',
            'affiliate_number.unique' => 'Este No.Afiliación ya esta asignado a un Cliente',
            'bank_id.required' => 'Seleccione un Banco',
            'account_number.required' => 'Ingrese un No. Cuenta Bancaria',
            'account_number.min' => 'No. Cuenta Bancaria Incompleto',
            'account_number.unique' => 'Este No. Cuenta Bancaria ya esta asignado a un No. Afiliación',
        ];
    }
}
