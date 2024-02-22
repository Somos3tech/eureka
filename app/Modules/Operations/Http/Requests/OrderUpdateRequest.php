<?php

namespace App\Modules\Operations\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
        if ($this->get('terminal_id') != null) {
            return [
                'terminal_id' => 'required',
                'observ_credicard' => 'required',
            ];
        }

        if ($this->get('simcard_id') != null && $this->get('valid_simcard') != 1) {
            $valid_update = $this->get('dcustomer_id') > 0 ? $this->get('dcustomer_id') : 'NULL';

            return [
                'simcard_id' => 'sometimes|required',
                /*  'dcustomer_id' => 'required|unique:contracts,dcustomer_id,' . $valid_update . ',id,nropos,' . $this->get('nropos'),*/
            ];
        } else {
            return [
                'nropos' => 'required',
                'observ_programmer' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'customer_id.unique' => 'Nro. Terminal Existente, realizar cambio de Nro. Terminal',
            'terminal_id.required' => 'Serial Terminal requerido',
            'observ_credicard.required' => 'Observación Inicial requerida',
            'simcard_id.required' => 'Serial Simcard requerido',
            'nropos.required' => 'No. Terminal requerido',
            'observ_programmer.required' => 'Observación Final requerida',
        ];
    }
}
