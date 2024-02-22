<?php

namespace App\Modules\Sales\Repositories\Payment;

class DomiciliationPayment implements PayableInterface
{
    public function pay($request)
    {
        return ['contract_id' => $request['contract_id'], 'tipnot' => 'Domiciliacion', 'concept_id' => 1, 'refere' => $request['refere'], 'currency_id' => $request['currency_id'], 'amount' => str_replace(',', '', $request['amount']), 'amount_currency' => str_replace(',', '', $request['dicom']), 'conceptc' => 'Cobro Domiciliación Bancaria', 'status' => 'G'];
    }
}
