<?php

namespace App\Modules\Supports\Repositories;

use App\Modules\Sales\Repositories\ContractInterface;
use App\Modules\Sales\Repositories\InvoiceInterface;
use App\Modules\Sales\Repositories\InvoiceItemInterface;
use App\Modules\Supports\Exports\ReportSupportExport;
use App\Modules\Supports\Models\Support;
use App\Modules\Warehouses\Repositories\AssignmentInterface;
use App\Modules\Warehouses\Repositories\SimcardInterface;
use App\Modules\Warehouses\Repositories\TerminalInterface;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class SupportRepository implements SupportInterface
{
    protected $support;

    protected $invoice;

    protected $invoiceitem;

    protected $contract;

    protected $assignment;

    protected $terminal;

    protected $simcard;

    public function __construct(Support $support, InvoiceInterface $invoice, InvoiceItemInterface $invoiceitem, ContractInterface $contract, TerminalInterface $terminal, SimcardInterface $imcard, AssignmentInterface $assignment)
    {
        $this->model = $support;
        $this->invoice = $invoice;
        $this->invoiceitem = $invoiceitem;
        $this->contract = $contract;
        $this->terminal = $terminal;
        $this->simcard = $simcard;
        $this->assignment = $assignment;
    }

    /***************************Registrar Soporte******************************/
    public function create($request)
    {
    }

    /***********************Buscar Información Soporte*************************/
    public function find($id)
    {
    }

    /**************************************************************************/
    public function update($data, $id)
    {
    }

    /*********************Eliminar Información Soporte*************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->status = 'X';
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /***********************Api Datatable - Soporte****************************/
    public function datatable()
    {
        $model = $this->model->query();
        $data = $model->select('cs.rif', 'cs.business_name', 'supports.*', \DB::raw("CONCAT(users.name,' ',users.last_name) AS user_created"), 'supports.status as status_support')
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'supports.contract_id');
                $join->where('ct.status', '=', 'Activo');
                $join->whereNull('ct.deleted_at');
            })
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'supports.user_created_id');
            })->get();

        return $data;
    }

    /**************************Reporte de Soporte******************************/
    public function report($request)
    {
        return Excel::download(new ReportSupportExport, 'Reporte Soporte '.date('Y-m-d').'.xlsx');
    }
}
