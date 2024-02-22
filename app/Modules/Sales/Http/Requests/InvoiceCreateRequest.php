<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceCreateRequest extends FormRequest
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
            'customer_id' => 'required',
            'contract_id' => 'required',
            'rif' => 'required',
            'business_name' => 'required',
            'payment_method' => 'required',
            'payment_date' => 'required',
            'type_sale' => 'required_if:payment_method,Efectivo|required_if:payment_method,Deposito|required_if:payment_method,Transferencia|required_if:payment_method,DTE',
            'collect_partial' => 'sometimes|required',
            'inv_pending' => 'sometimes|required',
            'refere' => 'sometimes|required',
            'amount' => 'sometimes|required',
            'amountm' => 'sometimes|required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Ingrese ID Cliente',
        ];
    }
}
