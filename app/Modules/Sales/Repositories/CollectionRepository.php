<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Exports\CollectionReportExport;
use App\Modules\Sales\Exports\ProcessedReportExport;
use App\Modules\Sales\Exports\CollectionServiceReportExport;
use App\Modules\Sales\Models\Collection;
use Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CollectionRepository implements CollectionInterface
{
    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->model = $collection;
    }

    /******************************Registrar Pagos*******************************/
    public function create($request)
    {
        $sum = 0;
        $modalitys = [
            'acconcept_id' => $request['acconcept'],
            'currency_id' => $request['currency'],
            'fechpro' => $request['date_fechpro'],
            'refere' => $request['refer'],
            'dicom' => $request['dicom'] != '' ? str_replace(',', '', $request['dicom']) : '0.00',
            'amount_currency' => $request['amount_currency'] != '' ? str_replace(',', '', $request['amount_currency']) : '0.00',
            'amount' => str_replace(',', '', $request['amount']),
        ];

        $array_data = [
            'invoice_id' => (int) $request['invoice_id'],
            'invoiceitem_id' => $request->has('invoiceitem_id') != '' ? $request['invoiceitem_id'] : null,
            'tipnot' => 'EFE',
            'description' => 'Conciliación Administración',
            'status' => '00',
            'user_created_id' => Auth::user()->id,
        ];

        for ($i = 0; $i < count($modalitys['acconcept_id']); $i++) {
            $array = [
                'acconcept_id' => $modalitys['acconcept_id'][$i],
                'currency_id' => $modalitys['currency_id'][$i],
                'fechpro' => $modalitys['fechpro'][$i],
                'refere' => $modalitys['refere'][$i],
                'dicom' => $modalitys['dicom'] != '' ? $modalitys['dicom'] : '1.00',
                'amount_currency' => $modalitys['amount_currency'][$i] > 0 ? $modalitys['amount_currency'][$i] : '0.00',
                'amount' => $modalitys['amount'][$i],
            ];

            $data = array_merge($array_data, $array);

            if ($result = $this->model->create($data)) {
                $sum++;
            }
        }

        if ($sum > 0) {
            return true;
        }

        return false;
    }

    /************************Actualizar Información Pagos************************/
    public function update($request, $id)
    {
        //
    }

    /****************************************************************************/
    public function delete($id)
    {
    }

    /************************Eliminar Información Pagos**************************/
    public function deleteCollect($request)
    {
        $cont = 0;
        $data = [];
        $date = Carbon::now();
        $collections = $request['collection_id'];

        if (count($collections) > 0) {
            foreach ($collections as $collect_id) {
                $collection = $this->model->where('collections.id', $collect_id)->first();
                //  ->where('collections.created_at','LIKE',$date->format('Y-m').'-%')

                if (isset($collection)) {
                    $data[$cont]['collection_id'] = $collect_id;
                    $data[$cont]['invoiceitem_id'] = $collection->invoiceitem_id;

                    $collection->user_deleted_id = Auth::user()->id;

                    if ($collection->update()) {
                        if ($collection->delete()) {
                            $cont++;
                        }
                    }
                }
            }
        }

        if ($cont > 0) {
            return $data;
        }

        return false;
    }

    /****************************Estado de Cuenta********************************/
    public function statements($request)
    {
        $count = count($request['field']);

        if ($request['start'] != '' && $request['end'] != '') {
            $raw = \DB::raw("ROUND(((SELECT ROUND(SUM(collections.amount),1) FROM collections INNER JOIN invoices as inv1 ON inv1.id=collections.invoice_id AND inv1.deleted_at IS NULL INNER JOIN contracts as ct1 ON ct1.id=inv1.contract_id AND ct1.deleted_at IS NULL INNER JOIN customers as cs1 ON cs1.id=ct1.customer_id WHERE collections.fechpro BETWEEN '" . $request['start'] . "' AND '" . $request['end'] . "' AND  cs1.rif LIKE cs.rif) - (SELECT ROUND(SUM(ncc1.amount),1) FROM ncredits as nc1 INNER JOIN customers as cus ON cus.id=nc1.customer_id INNER JOIN ncredititems as ncc1 ON ncc1.ncredit_id=nc1.id AND nc1.deleted_at IS NULL WHERE nc1.fechpro BETWEEN '" . $request['start'] . " %' AND '" . $request['end'] . "  %' AND  cus.rif LIKE cs.rif) - (SELECT ROUND(SUM((bi1.amount/1.16) + (((bi1.amount/1.16)-bi1.free)*0.16) - bi1.free),1) FROM billingitems as bi1 INNER JOIN billings as b1 ON b1.id=bi1.billing_id AND b1.deleted_at IS NULL INNER JOIN invoices as inv2 ON inv2.id=bi1.invoice_id AND inv2.deleted_at IS NULL INNER JOIN contracts as ct2 ON ct2.id=inv2.contract_id AND ct2.deleted_at IS NULL INNER JOIN customers as cs2 ON cs2.id=ct2.customer_id WHERE b1.fechpro BETWEEN '" . $request['start'] . " %' AND '" . $request['end'] . " %' AND cs2.rif LIKE cs.rif)),1)");
        } else {
            $raw = \DB::raw('ROUND(((SELECT ROUND(SUM(collections.amount),1) FROM collections INNER JOIN invoices as inv1 ON inv1.id=collections.invoice_id AND inv1.deleted_at IS NULL INNER JOIN contracts as ct1 ON ct1.id=inv1.contract_id AND ct1.deleted_at IS NULL INNER JOIN customers as cs1 ON cs1.id=ct1.customer_id WHERE cs1.rif LIKE cs.rif) - (SELECT ROUND(SUM(ncc1.amount),1) FROM ncredits  as nc1 INNER JOIN customers as cus ON cus.id=nc1.customer_id INNER JOIN ncredititems as ncc1 ON ncc1.ncredit_id=nc1.id AND nc1.deleted_at IS NULL WHERE cus.rif LIKE cs.rif) - (SELECT ROUND(SUM((bi1.amount/1.16) + (((bi1.amount/1.16)-bi1.free)*0.16) - bi1.free),1) FROM billingitems as bi1 INNER JOIN billings as b1 ON b1.id=bi1.billing_id AND b1.deleted_at IS NULL INNER JOIN invoices as inv2 ON inv2.id=bi1.invoice_id AND inv2.deleted_at IS NULL INNER JOIN contracts as ct2 ON ct2.id=inv2.contract_id AND ct2.deleted_at IS NULL INNER JOIN customers as cs2 ON cs2.id=ct2.customer_id WHERE cs2.rif LIKE cs.rif)),1)');
        }

        $model = $this->model->query();

        $model->select(\DB::raw("DATE_FORMAT(collections.fechpro, '%Y-%m-%d') as date_created"), \DB::raw("(CASE WHEN (collections.invoice_id IS NULL) THEN NULL ELSE 'Cobro' END) as type_register"), 'collections.id', 'cs.rif as rif', 'cs.business_name', 'mt.description as modelterminal', 'ac.name as concept', 'collections.refere', \DB::raw("'' as amount_debit"), \DB::raw('ROUND(collections.amount,1) as amount_credit'), \DB::raw('ROUND(collections.amount,1) AS amount'), $raw)
            ->join('invoices as inv', function ($join) {
                $join->on('inv.id', '=', 'collections.invoice_id');
                $join->whereNull('inv.deleted_at');
            })
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'inv.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('acconcepts as ac', function ($join) {
                $join->on('ac.id', '=', 'collections.acconcept_id');
                $join->whereNull('ac.deleted_at');
            })
            ->join('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id');

        if ($request['start'] != '' && $request['end'] != '') {
            $model->whereBetween('collections.fechpro', [$request['start'] . ' %', $request['end'] . ' %']);
        }

        if ($request['payment_method'] != '') {
            $model->where('collections.acconcept_id', '=', $request['payment_method']);
        }

        for ($i = 0; $i < $count; $i++) {
            if ($request['field'][$i] != null && $request['query'][$i] != null) {
                if ($request['operator'][$i] != null) {
                    $operator = $request['operator'][$i];
                } else {
                    $operator = '=';
                }

                if ($i == 0) {
                    $model->where('cs.' . $request['field'][$i], $operator, $request['query'][$i]);
                    $cond = $request['conditional'][$i];
                } else {
                    if ($cond == 'AND' || $cond == '') {
                        $model->where('cs.' . $request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    } else {
                        $model->OrWhere('cs.' . $request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    }
                }
            }
        }
        if ($request['balance'] != null) {
            if ($request['balance'] == 1) {
                $model->where($raw, '=', 0);
            }

            if ($request['balance'] == 0) {
                $model->where($raw, '!=', 0);
            }
        }

        $data = $model->orderBy('collections.fechpro', 'DESC')->get();

        return $data;
    }

    /****************************************************************************/
    public function find($id)
    {
    }

    /************************Actualizar Información Pagos************************/
    public function findId($request, $id)
    {
        $model = $this->model->query();
        $model->select(
            'collections.id',
            'collections.invoice_id',
            'collections.invoiceitem_id',
            'collections.invoiceitem_id',
            'collections.fechpro',
            'ac.name as accounting',
            'collections.refere',
            'collections.currency_id',
            'cu.abrev as currency',
            \DB::raw("(CASE WHEN (collections.currency_id > 1 AND inv.concept_id='1') THEN FORMAT((collections.amount/collections.amount_currency) ,2) WHEN (collections.currency_id > '1' AND inv.concept_id > 1) THEN FORMAT((collections.dicom) ,2) ELSE '----' END) as dicom"),
            \DB::raw("(CASE WHEN (collections.currency_id > '1' AND inv.concept_id > 1) THEN FORMAT(collections.amount,2) WHEN (collections.currency_id > 1 AND inv.concept_id='1') THEN FORMAT(collections.amount_currency ,2) ELSE FORMAT(collections.amount ,2) END) as amount"),
            \DB::raw("(CASE WHEN (collections.currency_id > '1' AND inv.concept_id > 1) THEN FORMAT(collections.amount*collections.dicom,2) WHEN (collections.currency_id > 1 AND inv.concept_id='1') THEN FORMAT(collections.amount ,2) ELSE FORMAT(collections.amount ,2) END) as total_amount"),
            \DB::raw("CONCAT(us.name,' ',us.last_name) as user")
        )
            ->join('invoices as inv', function ($join) {
                $join->on('inv.id', '=', 'collections.invoice_id');
                $join->whereNull('inv.deleted_at');
            })
            ->leftjoin('acconcepts as ac', 'ac.id', '=', 'collections.acconcept_id')
            ->leftjoin('currencies as cu', 'cu.id', '=', 'collections.currency_id')
            ->leftjoin('users as us', 'us.id', '=', 'collections.user_created_id');

        if ($request['invoiceitem_id'] != null) {
            $model->where('collections.invoiceitem_id', (int) $request['invoiceitem_id']);
        } else {
            $model->where('inv.id', (int) $id);
        }

        return $model->get()->toArray();
    }

    /**************************************************************************/
    public function report($request)
    {
        //$export = new CollectionReportExport($request);
        $export = new ProcessedReportExport($request);

        return Excel::download($export, 'Reporte Pagos' . date('Y-m-d') . '.xlsx');
    }

    /**************************************************************************/
    public function reportService($request)
    {
        $export = new CollectionServiceReportExport($request);

        return Excel::download($export, 'Reporte Pagos Diarios  ' . date('Y-m-d') . '.xlsx');
    }
}
