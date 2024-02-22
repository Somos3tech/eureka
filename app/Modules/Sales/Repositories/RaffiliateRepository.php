<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Models\Raffiliate;

class RaffiliateRepository implements RaffiliateInterface
{
    protected $raffiliate;

    public function __construct(Raffiliate $raffiliate)
    {
        $this->model = $raffiliate;
    }

    /************************************************************************/
    public function datatable($request)
    {
        $model = $this->model->select(
            'cs.rif',
            'cs.business_name',
            \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"),
            'dc.affiliate_number',
            'dc.account_number',
            'bk.description as bank_name',
            \DB::raw("(CASE WHEN (bk.is_register=1 AND contracts.is_affiliate=0) THEN 'No' WHEN (bk.is_register=1 AND contracts.is_affiliate=1) THEN DATE_FORMAT(contracts.affiliate_date,'%Y-%m-%d') ELSE '----' END) AS affiliate_date"),
            'raffiliates.status AS validation',
            'contracts.status'
        )
            ->join('contracts', function ($join) {
                $join->on('contracts.id', '=', 'raffiliates.contract_id');
                $join->whereNull('contracts.deleted_at');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->join('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dc.bank_id');
                $join->where('bk.is_register', 1);
                $join->whereNull('bk.deleted_at');
            });

        if ($request->has('is_register') && $request['is_register'] == 1) {
            $model->where('raffiliates.status', 'LIKE', 'Afiliado');
        } elseif ($request->has('is_register') && ($request['is_register'] == 0 || $request['is_register'] == '')) {
            $model->where('raffiliates.status', 'LIKE', 'Generado');
        }

        $data = $model->where('contracts.status', 'Activo')->distinct()->orderBy('contracts.dcustomer_id', 'ASC')->get();

        return datatables()->of($data)->rawColumns(['status'])->toJson();
    }
    /**************************************************************************/
}
