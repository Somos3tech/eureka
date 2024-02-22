<?php

namespace App\Modules\Reports\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationResponseRequest extends FormRequest
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
            'date' => 'required_if:type_date,month',
            'date_range' => 'required_if:type_date,range',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'date.required_if' => 'Ingrese Mes',
            'date_range.required_if' => 'Ingrese Rango de Fecha',
        ];
    }
}
