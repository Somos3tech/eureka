<?php

namespace App\Modules\Sales\Repositories\Payment;

use App\Modules\Sales\Models\Contract;

class DebitPayment implements PayableInterface
{
    public function pay($request)
    {
        $refere = $request['refere'].' | '.$request['date_value'];
        $contract = Contract::select('contracts.nropos', \DB::raw("(REPLACE(dcustomers.account_number,'-','')) as account_number"), 'dcustomers.affiliate_number', 'banks.description as bank_name', 'terms.abrev as term_abrev', 'terms.description as term_description', 'terminals.serial as terminal')
            ->leftjoin('customers', 'customers.id', '=', 'contracts.customer_id')
            ->leftjoin('dcustomers', 'dcustomers.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('banks', 'banks.id', '=', 'dcustomers.bank_id')
            ->leftjoin('terminals', 'terminals.id', '=', 'contracts.terminal_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->where('contracts.id', (int) $request['contract_id'])->first();

        if (isset($contract)) {
            $array = [
                'bank_name' => $contract->bank_name,
                'affiliate_number' => $contract->affiliate_number,
                'term_abrev' => $contract->term_abrev,
                'term_name' => $contract->term_description,
                'terminal' => $contract->terminal,
                'concept' => 'Servicio Transaccional - Masivo',
            ];

            $nropos = $contract->nropos;
            $nrocta = $contract->account_number;
        } else {
            $array = [
                'bank_name' => '----',
                'affiliate_number' => '----',
                'term_abrev' => '----',
                'term_name' => '----',
                'terminal' => '----',
                'concept' => 'Servicio Transaccional - Masivo',
            ];
            $nropos = null;
            $nrocta = null;
        }

        return ['contract_id' => $request['contract_id'], 'tipcta' => $request['tipcta'], 'bank_id' => $request['bank_id'], 'free' => $request['free'], 'tipnot' => $request['tipnot'], 'concept_id' => 2, 'nrocta' => $nrocta, 'nropos' => $nropos, 'refere' => $refere, 'currency_id' => 2, 'amount' => str_replace(',', '', $request['amount']), 'amount_currency' => '1.00', 'conceptc' => serialize($array), 'status' => 'G'];
    }
}
