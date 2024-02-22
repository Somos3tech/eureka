<?php

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportAffiliateRequest extends FormRequest
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
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'bank_id.required' => 'Seleccione Banco',
        ];
    }
}
