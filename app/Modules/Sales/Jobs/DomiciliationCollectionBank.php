<?php

namespace App\Modules\Sales\Jobs;

use App\Modules\Sales\Models\Collection;
use App\Modules\Sales\Models\Domiciliation;
use App\Modules\Sales\Models\Invoice;
use App\Modules\Sales\Models\Rcollection;
use App\Traits\TaskTrait;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DomiciliationCollectionBank implements ShouldQueue
{
    use TaskTrait;
    use Dispatchable, InteractsWithQueue, Batchable, Queueable, SerializesModels;

    protected $content;

    protected $user;

    protected $id;

    /*************************************************************************/
    public function __construct($content, $user, $id)
    {
        $this->content = $content;
        $this->user = $user;
        $this->id = $id;
    }

    /*************************************************************************/
    public function handle()
    {
        $content = $this->content;
        $status = 'X';
        $model_invoice = Invoice::select(\DB::raw('invoices.id, invoices.status, invoices.user_updated_id'));

        if ($this->content['bank_id'] == 7) {
            $model_invoice->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
                ->join('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
                ->where('invoices.concept_id', 2)
                ->where('dc.bank_id', $content['bank_id'])
                ->where('dc.affiliate_number', trim($content['afiliado']))
                ->where('contracts.nropos', (int) $content['nropos']);
        } elseif ($this->content['bank_id'] == 8) {
            $model_invoice->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
                ->join('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
                ->where('invoices.concept_id', 2)
                ->where('dc.bank_id', $content['bank_id'])
                ->where('dc.affiliate_number', trim($content['afiliado']));
        } else {
            $model_invoice->where('invoices.id', (int) $this->content['invoice_id']);
        }
        $invoice = $model_invoice->whereIn('invoices.status', ['G', 'R', 'P'])->first();

        if (isset($invoice)) {
            if ($this->content['status_bank'] == 'P000' || $this->content['status_bank'] == '00' || $this->content['status_bank'] == '0000' || $this->content['status_bank'] == 'C' || $this->content['status_bank'] == 'Cobrado' || $this->content['status_bank'] == 'COBRADO' || $this->content['status_bank'] == 'Aplicado' || $this->content['status_bank'] == 'TRANSACCION EXITOSA' || $this->content['status_bank'] == '000000' || $this->content['status_bank'] == '010' || $this->content['status_bank'] == 'P' || $this->content['status_bank'] == 'T' && $this->content['bank_id'] == 5 || $this->content['status_bank'] == '74') {
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
                    $id = Domiciliation::select(\DB::raw('domiciliation.id, domiciliation.total_amount_processed_real, domiciliation.total_processed_real, domiciliation.user_updated_id'))->where('domiciliation.id', $this->id)->first();
                    $id->total_amount_processed_real = $id->total_amount_processed_real + $this->content['amount'];
                    $id->total_processed_real = $id->total_processed_real + 1;
                    $id->user_updated_id = $this->user->id;
                    $id->save();
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
        // print_r(isset($invoice) ? (int)$invoice['id'] : "null");
        // Log::info(isset($invoice) ? (int)$invoice['id'] : "null");
        $this->content['referencia'] = isset($invoice) ? (int) $invoice['id'] : null;
        $data = serialize([
            'fechpro' => $this->content['fechpro'],
            'afiliado' => $this->content['afiliado'] != '' ? $this->content['afiliado'] : null,
            'nropos' => array_key_exists('nropos', $content) ? $this->content['nropos'] : null,
            'referencia' => $this->content['referencia'] != null ? $this->content['referencia'] : 'Registro No Válido',
            'monto' => $this->content['amount'] / $this->content['amount_currency'],
            'monto_divisa' => $this->content['amount'],
            'dicom' => $this->content['amount_currency'],
            'descripcion_cliente' => $this->content['descripcion_cliente'],
            'motivo_del_fallido' => $this->content['motivo_del_fallido'],
            'status_bank' => $this->content['status_bank'],
        ]);

        $rcollection = Rcollection::create([
            'bank_id' => $this->content['bank_id'],
            'fechpro' => now(),
            'collection_id' => $collection_id,
            'refere' => $this->content['referencia'] != null ? $this->content['referencia'] : 'Registro No Válido',
            'data' => $data,
            'status' => $status,
            'user_created_id' => $this->user->id,
        ]);

        return $rcollection;
    }
}
