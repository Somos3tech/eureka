<?php

namespace App\Modules\Sales\Jobs;

use App\Modules\Parameters\Models\Payer;
use App\Modules\Sales\Models\Collection;
use App\Modules\Sales\Models\Invoice;
use App\Modules\Sales\Models\Rcollection;
use App\Traits\TaskTrait;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCollectionBank implements ShouldQueue
{
    use TaskTrait;

    /**
     * ! Jorge Thomas
     * * Se agrega Batchable a la clase para integrar funcion de colas por batches
     */
    use Dispatchable, InteractsWithQueue, Queueable, Batchable, SerializesModels;

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
        $model_invoice = Invoice::select('invoices.*');

        if ($this->content['bank_id'] != 7) {
            $payer = Payer::where('payers.bank_id', $this->content['bank_id'])->first();

            if (isset($payer)) {
                $model_invoice->join('consecutives', function ($join) use ($content) {
                    $join->on('consecutives.invoice_id', '=', 'invoices.id');
                    $join->where('consecutives.bank_id', $content['bank_id']);
                })->where('consecutives.consecutive', (int) $content['referencia']);
            } else {
                $model_invoice->where('invoices.id', (int) $this->content['invoice_id']);
            }
        } else {
            $model_invoice->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
                ->join('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
                ->where('invoices.concept_id', 2)
                ->where('dc.bank_id', $content['bank_id'])
                ->where('dc.affiliate_number', trim($content['afiliado']))
                ->where('contracts.nropos', (int) $content['nropos']);
        }

        $invoice = $model_invoice->whereIn('invoices.status', ['G', 'R', 'P'])->first();
        // dd($invoice);
        if (isset($invoice)) {
            $this->content['referencia'] = (int) $invoice['id'];
            /**
             * ! Jorge Thomas
             * * Verificación de registro aprobado en archivo de domiciliación.
             */
            if ($this->content['status_bank'] == 'P000' || $this->content['status_bank'] == '00' || $this->content['status_bank'] == 'C' || $this->content['status_bank'] == 'Cobrado' || $this->content['status_bank'] == 'Aplicado' || $this->content['status_bank'] == 'TRANSACCION EXITOSA') {
                $collection = Collection::create([
                    'invoice_id' => (int) $invoice['id'],
                    'fechpro' => $this->content['fechpro'],
                    'tipnot' => 'DOM',
                    'acconcept_id' => $this->acconceptId($this->content['bank_id']),
                    'refere' => array_key_exists('referencia', $content) ? $this->content['referencia'] : 'Gestión Domiciliación',
                    'description' => 'Domiciliación Bancaría',
                    'currency_id' => 1,
                    'dicom' => $this->content['amount_currency'],
                    'amount_currency' => $this->content['amount'],
                    'amount' => $this->content['amount'] / $this->content['amount_currency'],
                    'status' => '00',
                    'user_created_id' => $this->user->id,
                ]);
                if (isset($collection)) {
                    $invoice->status = 'C';
                    $invoice->user_updated_id = $this->user->id;
                    $invoice->save();

                    $collection_id = $collection->id;
                    $status = 'P';
                } else {
                    $invoice_id = null;
                    $collection_id = null;
                    $status = 'X';
                }
            } else {
                $invoice_id = null;
                $collection_id = null;
                $status = 'X';
            }
        } else {
            $invoice_id = null;
            $collection_id = null;
            $status = 'X';
        }

        $rcollection = Rcollection::create([
            'bank_id' => $this->content['bank_id'],
            'fechpro' => now(),
            'collection_id' => $collection_id,
            'refere' => $this->content['referencia'] != null ? $this->content['referencia'] : 'Registro No Válido',
            'data' => serialize([
                'fechpro' => $this->content['fechpro'],
                'afiliado' => $this->content['afiliado'] != '' ? $this->content['afiliado'] : null,
                'nropos' => array_key_exists('nropos', $content) ? $this->content['nropos'] : null,
                'referencia' => $this->content['referencia'],
                'monto' => $this->content['amount'] / $this->content['amount_currency'],
                'monto_divisa' => $this->content['amount'],
                'dicom' => $this->content['amount_currency'],
                'descripcion_cliente' => $this->content['descripcion_cliente'],
                'motivo_del_fallido' => $this->content['motivo_del_fallido'],
                'status_bank' => $this->content['status_bank'],
            ]),
            'status' => $status,
            'user_created_id' => $this->user->id,
        ]);

        return $rcollection;
    }
}
