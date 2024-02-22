<?php

namespace App\Modules\Parameters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TermRequest extends FormRequest
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
            'abrev' => 'required|unique:terms|min:3',
            'description' => 'required|min:3',
            'type_invoice' => 'required',
            'observations' => 'required|min:3',
            'type_conditions' => 'required',
            'type_conditions1' => 'required',
            'currency_id' => 'required',
        ];

        if ($this->request->get('type_conditions') == 1 && $this->request->get('type_conditions1') == 1) {
            $rules['comission_flatrate'] = 'required';
        }

        if (($this->request->get('type_conditions') == 1 || $this->request->get('type_conditions') == 2) && $this->request->get('type_conditions1') == 2) {
            $rules['comission_id'] = 'required';
        }

        if ($this->request->get('type_conditions') == 2 && $this->request->get('type_conditions1') == 1) {
            $rules['comission_percentage'] = 'required';
        }

        if ($this->request->get('type_conditions') == 3 && $this->request->get('type_conditions1') == 1) {
            $rules['comission_percentage'] = 'required';
            $rules['comission_min'] = 'required';
            $rules['amount_max'] = 'required';
        }

        if ($this->request->get('type_conditions') == 3 && $this->request->get('type_conditions1') == 2) {
            $rules['comission_id'] = 'required';
            $rules['comission_min'] = 'required';
            $rules['amount_max'] = 'required';
        }

        if ($this->request->get('type_conditions') == 3 && $this->request->get('check') == 1) {
            if ($this->request->get('amount_min') == null) {
                $rules['amount_min'] = 'required';
            }
        }

        return $rules;
    }

    public function messages()
    {
        $message = [
            'abrev.required' => 'Abreviatura es requerida',
            'abrev.unique' => 'Abreviatura ya se encuentra registrada',
            'abrev.min' => 'Abreviatura debe ser minimo de :min caracteres',
            'description.required' => 'Descripción Condición Comercial es requerida',
            'description.min' => 'Descripción Condición Comercial debe ser minimo de :min caracteres',
            'observations.required' => 'Observaciones Condición Comercial es Requerida',
            'observations.min' => 'Observaciones Condición Comercial debe ser minimo de :min caracteres',
            'type_invoice.required' => 'Tipo Cobranza es requerida',
            'type_conditions.required' => 'Tipo Comisión es requerida',
            'type_conditions1.required' => 'Tipo Tarifa es requerida',
            'currency_id.required' => 'Divisa es requerida',
        ];

        if ($this->request->get('type_conditions') == 1 && $this->request->get('type_conditions1') == 1) {
            $message['comission_flatrate.required'] = 'Tarifa Fija es requerida';
        }

        if (($this->request->get('type_conditions') == 1 || $this->request->get('type_conditions') == 2) && $this->request->get('type_conditions1') == 2) {
            $message['comission_id.required'] = 'Comisión x Rango es requerido';
        }

        if ($this->request->get('type_conditions') == 2 && $this->request->get('type_conditions1') == 1) {
            $message['comission_percentage.required'] = 'Comisión x Porcentaje es requerido';
        }

        if ($this->request->get('type_conditions') == 3 && $this->request->get('type_conditions1') == 1) {
            $message['comission_percentage.required'] = 'Comisión x Porcentaje es requerido';
            $message['comission_min.required'] = 'Comisión Mínima es requerida';
            $message['amount_max.required'] = 'Monto Máximo de transacciones es requerido';
        }

        if ($this->request->get('type_conditions') == 3 && $this->request->get('type_conditions1') == 2) {
            $message['comission_id.required'] = 'Comision x Rango es requerido';
            $message['comission_min.required'] = 'Comisión Mínima es requerida';
            $message['amount_max.required'] = 'Monto Máximo de transacciones es requerido';
        }

        if ($this->request->get('type_conditions') == 3 && $this->request->get('check') == 1) {
            if ($this->request->get('amount_min') == null) {
                $message['amount_min.required'] = 'Monto Mínimo de transacciones es requerido';
            }
        }

        return $message;
    }
}
