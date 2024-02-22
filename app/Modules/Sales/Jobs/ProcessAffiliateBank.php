<?php

namespace App\Modules\Sales\Jobs;

use App\Modules\Sales\Models\Contract;
use App\Modules\Sales\Models\Raffiliate;
use App\Traits\TaskTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAffiliateBank implements ShouldQueue
{
    use TaskTrait;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;

    protected $user;

    /*************************************************************************/
    public function __construct($content, $user)
    {
        $this->content = $content;
        $this->user = $user;
    }

    /*************************************************************************/
    public function handle()
    {
        $content = $this->content;
        $status = 'X';

        $contract = Contract::select('contracts.*', 'customers.rif', 'customers.business_name', \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"))
            ->join('aconsecutives', 'aconsecutives.contract_id', '=', 'contracts.id')
            ->join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->where('aconsecutives.refere', (int) $this->content['refere'])
            ->where('aconsecutives.bank_id', (int) $this->content['bank_id'])
            ->first();

        if (isset($contract)) {
            if ($this->content['response'] == '000') {
                $contract->is_affiliate = 1;
                $contract->affiliate_date = date_format(now(), 'Y-m-d');

                $result = $contract->save();
            }
            $contract_id = $contract->id;
            $dcustomer_id = $contract->dcustomer_id;
            $data = [
                'fecha_procesado' => date_format(now(), 'Y-m-d'),
                'rif' => $contract->rif,
                'comercio' => $contract->business_name,
                'contrato' => $contract->contract_id,
                'respuesta' => $this->content['response'],
                'mensaje' => $this->content['message'],
            ];
        } else {
            $contract_id = '----';
            $dcustomer_id = '----';
            $data = [
                'fecha_procesado' => date_format(now(), 'Y-m-d'),
                'rif' => $this->content['refere'],
                'comercio' => 'Comercio no Reconocido',
                'contrato' => '----',
                'respuesta' => $this->content['response'],
                'mensaje' => $this->content['message'],
            ];
        }

        $raffiliate = Raffiliate::create([
            'fechpro' => date_format(now(), 'Y-m-d'),
            'contract_id' => (int) $contract_id,
            'dcustomer_id' => (int) $dcustomer_id,
            'bank_id' => $this->content['bank_id'],
            'data' => serialize($data),
            'observation_response' => $this->content['response'] = '000' ? $this->content['response'].'-'.$this->content['message'] : 'Servicio Terminal Activo x Cobranza',
            'status' => $this->content['response'] = '000' ? 'Afiliado' : 'Procesado',
            'user_created_id' => $this->user->id,
        ]);
    }
}
