<?php

namespace App\Modules\Operations\Repositories;

use App\Events\Order as OrderEvent;
use App\Modules\Operations\Models\Order;
use App\Modules\Operations\Repositories\Exports\ReportAdminProgrammerExport;
use App\Modules\Operations\Repositories\Exports\ReportCredicardExport;
use App\Modules\Operations\Repositories\Exports\ReportOfficeExport;
use App\Modules\Operations\Repositories\Exports\ReportPlatcoExport;
// use App\Modules\Warehouses\Models\Terminal;

use App\Modules\Operations\Repositories\Exports\ReportProgrammerExport;
use App\Modules\Operations\Repositories\Service\OrderServiceFactory;
use App\Modules\Users\Repositories\Role\RoleInterface as Role;
use Auth;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Http;

use Maatwebsite\Excel\Facades\Excel;

class OrderRepository implements OrderInterface
{
    protected $order;

    protected $role;

    // protected $terminal;
    /**
     * OrderRepository constructor.
     *
     * @param  Order  $order
     */
    public function __construct(Order $order, Role $role)
    {
        $this->model = $order;
        $this->role = $role;
        // $this->terminal = $terminal;
    }

    /******************************Registrar Order***************************/
    public function create($request)
    {
        $result = $this->model->create([
            'contract_id' => $request['contract_id'],
            'invoice_id' => $request['invoice_id'],
            'bank_id' => $request['bank_id'],
            'status' => 'P',
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            $data = $this->totalStatus();
            event(new OrderEvent($data));

            return $result;
        }

        return false;
    }

    /******************************Información Order*************************/
    public function find($id)
    {
        $model = $this->model->query();

        return $model->query()->where('orders.id', '=', $id)->first();
    }

    /******************************Información Order*************************/
    public function findContract($data)
    {
        $model = $this->model->query();

        return $model->query()->where('orders.contract_id', '=', $data)->first();
    }

    /************************************************************************/
    public function findCustomer($data)
    {
        $model = $this->model->query();

        return $model->query()->where('orders.id', '=', $data)->first();
    }

    /******************************Información Order*************************/
    public function getSales($customer_id)
    {
        $model = $this->model->query();

        $model->select(
            'orders.id',
            'orders.contract_id',
            'inv.id as invoice_id',
            'inv.tipnot',
            'inv.conciliation_doc',
            'mt.description as modelterminal',
            't.serial as terminal',
            'op.description as operator',
            's.serial_sim as simcard',
            \DB::raw(" DATE_FORMAT(ct.created_at, '%d/%m/%Y') as created_contract"),
            \DB::raw('FORMAT(inv.amount_currency,2) as amount_currency'),
            \DB::raw('(CASE WHEN (inv.currency_id > 1) THEN FORMAT((((inv.amount*inv.amount_currency) - inv.free)),2) ELSE FORMAT((inv.amount),2) END) as amount'),
            \DB::raw('FORMAT(inv.free,2) as free'),
            \DB::raw('(CASE WHEN (inv.currency_id > 1) THEN FORMAT(((((inv.amount*inv.amount_currency) / 1.16) - inv.free) * 0.16),2) ELSE FORMAT((((inv.amount / 1.16) - inv.free) * 0.16),2) END) as iva'),
            \DB::raw('(CASE WHEN (inv.currency_id > 1) THEN FORMAT(((((inv.amount*inv.amount_currency) / 1.16) - inv.free)),2) ELSE FORMAT((inv.amount / 1.16),2) END) as base'),
            \DB::raw('(SELECT COUNT(*) FROM collections WHERE collections.invoice_id=inv.id) as collection_total')
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('invoices as inv', function ($join) {
                $join->on('inv.contract_id', '=', 'orders.contract_id');
                $join->whereIn('inv.status', ['C', 'P']);
                $join->whereNull('inv.deleted_at');
            })
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'ct.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->leftjoin('operators as op', 'op.id', '=', 'ct.operator_id')
            ->leftjoin('simcards as s', function ($join) {
                $join->on('s.id', '=', 'ct.simcard_id');
                $join->whereNull('s.deleted_at');
            });

        $data = $model->where('ct.customer_id', (int) $customer_id)->billing()->ncreditId((int) $customer_id)->get();

        return $data;
    }

    /******************************Actualizar Order**************************/
    public function update($request, $id)
    {
        $factory = new OrderServiceFactory();
        $orderService = $factory->initialize($request->type_service);
        $data = $orderService->updateField($request);
        // $serialterminal = $this->terminal->findOrfail($request->terminal_id);

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);
        if ($result) {
            $data = $this->totalStatus();
            event(new OrderEvent($data));

            return $model;
        }

        return false;
    }

    /******************************Eliminar Order****************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                $data = $this->totalStatus();
                event(new OrderEvent($data));

                return true;
            }
        }

        return false;
    }

    /******************************Datatable Order***************************/
    public function dataStatus($request)
    {
        ini_set('memory_limit', '1024M');
        $role = $this->role->getRole();
        $model = $this->model->query();

        if ($request['status'] == 'P') {
            $model->whereIn('orders.status', ['P', 'PF']);
        } elseif ($request['status'] == 'D') {
            $model->whereIn('orders.status', ['D']);
        } elseif ($request['status'] == 'C') {
            $model->whereIn('orders.status', ['C']);
        }
        if (Auth::user()->banklist != null) {
            $model->whereIn('dc.bank_id', $this->bankIn(Auth::user()->banklist));
        }
        if (Auth::user()->company_id != null) {
            if ($role->slug != 'programmer') {
                $model->where('ct.company_id', Auth::user()->company_id);
            }
        }

        $data = $model->query()->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                $actions .= '<button class="btn btn-sm btn-dark" href="#" data-toggle="modal" OnClick="OrderShow(this);" data-target="#showOrder" value="' . (int) $data['id'] . '" title="Ver Información Orden de Servicio"><i class="i i-Information"></i></button>';
                if (auth()->user()->can('orders.edit')) {
                    if (($data['status'] == 'P') || ($data['status'] == 'PI')) {
                        if (strlen($data['affiliate_number']) > 7 && strlen($data['affiliate_number']) < 15) {
                            $actions .= '<a class="btn btn-sm btn-warning" href="/orders/' . (int) $data['id'] . '/edit?company_id=&journey_id="  title="Gestión Orden de Servicio"><i class="i i-Gear-2" style="color:white;"></i></a>';
                        }
                    }
                }
                if (auth()->user()->can('offices.edit')) {
                    if ($data['status'] == 'D') {
                        $actions .= '<a class="btn btn-sm btn-success" href="/orders/posted/' . (int) $data->id . '/edit"  title="Gestión Entrega Punto de Venta"><i class="i-Yes"></i></a>';
                        $actions .= '<a class="btn btn-sm btn-danger" href="/orders/pdf/' . (int) $data->contract_id . '"  title="Generar Orden Entrega"><i class="i-Receipt"></i></a>';
                    }
                }
                $actions .= '</center>';

                return $actions;
            })->addColumn('check_credicard', function ($data) {
                if (auth()->user()->can('orders.edit')) {
                    if (!isset($data['valid_credicard'])) {
                        return '<button class="btn btn-sm btn-success" href="#" data-toggle="modal" OnClick="Ordercheck(this);" data-target="#checkOrder" value="' . (int) $data['id'] . '" title="Gestión Credicard"><i class="i i-Yes"></i></button>';
                    } else {
                        return '<button class="btn btn-sm btn-warning" href="#" data-toggle="modal" OnClick="Orderuncheck(this);" data-target="#uncheckOrder" value="' . (int) $data['id'] . '" title="Gestión Credicard" style="color:white;"><i class="i i-Close"></i></button>';
                    }
                }
            })->addColumn('restore', function ($data) {
                $restore = '';
                if (($data['status'] == 'PI') && $data['terminal_id'] != null) {
                    $restore .= '<button class="btn btn-sm btn-warning" href="#" data-toggle="modal" OnClick="managementRestore(this);" data-target="#restoreManagement" value="' . (int) $data['id'] . '|' . (int) $data['contract_id'] . '" title="Restaurar Gestión Equipo" style="color:white;"><i class="i i-Repeat"></i></button>';
                } else {
                    $restore .= '----';
                }

                return $restore;
            })->addColumn('csupport', function ($data) {
                $csupport = '';
                if ($data['status'] == 'D') {
                    if (auth()->user()->can('csupports.index')) {
                        if ($data['csupport_id'] != null) {
                            $csupport .= '<button class="btn btn-sm btn-dark" href="#" data-toggle="modal" OnClick="managementCsupport(this);" data-target="#csupportManagement" value="' . (int) $data['id'] . '|' . (int) $data['contract_id'] . '|' . $data['user_csupport'] . '|' . $data['observation_csupport'] . '" title="Gestión Notificación"><i class="i i-Gear"></i></button>';
                            $csupport .= '<span><i class="i-Yes"></i> <b>Notificado Administración</b></span>';

                            return $csupport;
                        }
                    }
                }

                $csupport .= '----';

                return $csupport;
            })->rawColumns(['csupport', 'management', 'credicard', 'check_credicard', 'status_order', 'actions', 'restore'])->toJson();
    }

    /******************************Datatable Order***************************/
    public function datatable($request)
    {
        ini_set('memory_limit', '1024M');
        $model = $this->model->query();
        $data = $model->query()->whereNotIn('orders.status', ['X'])->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                $actions .= '<button class="btn btn-sm btn-dark" href="#" data-toggle="modal" OnClick="OrderShow(this);" data-target="#showOrder" value="' . (int) $data['id'] . '" title="Ver Información Orden de Servicio"><i class="i i-Information"></i></button>';
                $actions .= '</center>';

                return $actions;
            })->rawColumns(['status_order', 'management', 'actions'])->toJson();
    }

    /******************************Datatable Order***************************/
    public function datatableUser($id)
    {
        ini_set('memory_limit', '1024M');
        $model = $this->model->query();
        $data = $model->query()->where('ct.customer_id', $id)->get();

        return datatables()->of($data)
            ->addColumn('contractprint', function ($data) {
                $actions = '<center>';
                if (auth()->user()->can('contracts.create')) {
                    if ($data->valid_contract == 1) {
                        $actions .= '&nbsp; <a class="btn btn-sm btn-info" href="/contracts/documentContract/' . $data->contract_id . '"  title="Generar Contrato"><i class="fa fa-file-word-o"></i></a>';
                    } else {
                        $actions .= '----';
                    }
                } else {
                    $actions .= '----';
                }
                $actions .= '</center>';

                return $actions;
            })
            ->rawColumns(['contractprint', 'status_order'])
            ->toJson();
    }

    /*******************Reporte Solicitud Programacion***********************/
    public function reportProgrammer()
    {
        return Excel::download(new ReportProgrammerExport, 'Reporte Programacion ' . date('Y-m-d') . '.xlsx');
    }

    /************************************************************************/
    public function reportAdminProgrammer($request)
    {
        return Excel::download(new ReportAdminProgrammerExport($request), 'Reporte Programacion ' . date('Y-m-d') . '.xlsx');
    }

    /*************Reporte Solicitud Paramentros Credicard Order**************/
    public function reportCredicard()
    {
        return Excel::download(new ReportCredicardExport, 'Reporte Carga Parametros Credicard ' . date('Y-m-d') . '.xlsx');
    }

    /*************Reporte Solicitud Paramentros Credicard Order**************/
    public function reportPlatco()
    {
        return Excel::download(new ReportPlatcoExport, 'Reporte Carga Parametros Platco ' . date('Y-m-d') . '.xlsx');
    }

    /******************************Select Order******************************/
    public function selectOrderTransfer()
    {
        $model = $this->model->query();

        $model->select(\DB::raw("CONCAT(cs.business_name,' | ',mt.description,' | ',t.serial) as serial"), 'orders.id')
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->join('invoices as inv', 'inv.contract_id', '=', 'orders.contract_id')
            ->join('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->join('terminals as t', 't.id', '=', 'ct.terminal_id')
            ->join('modelterminal as mt', 'mt.id', '=', 't.modelterminal_id');

        if (Input::get('action') == 'programmer') {
            $model->where('orders.status', '=', 'PF');
        }

        if (Input::get('action') == 'store') {
            $model->whereIn('orders.status', ['F']);
        }

        if (Auth::user()->company_id != null) {
            $model->where('ct.company_id', '=', Auth::user()->company_id);
        }

        if (Input::get('user_id')) {
            $model->where('orders.programmer_user_id', '=', Input::get('user_id'));
        }
        $data = $model->where('inv.type_sale', 'LIKE', Input::get('type_service'))->get();

        return \Response::json($data);
    }

    /******************************Select Order******************************/
    public function bankIn($bank)
    {
        return json_decode($bank, true);
    }

    /************************************************************************/
    public function api()
    {
    }

    /************************************************************************/
    public function totalStatus()
    {
        $data_pending = $this->model->select(\DB::raw("(CASE WHEN (ct.terminal_id IS NULL) THEN 'P' ELSE 'PI' END) as order_status"), \DB::raw('count(*) as total'))
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })->where('orders.status', 'P')
            ->whereNull('orders.deleted_at')
            ->groupBy('order_status')
            ->get();

        $data_order = $this->model->select('orders.status as order_status', \DB::raw('count(*) as total'))
            ->whereIn('orders.status', ['S', 'D', 'C'])
            ->whereNull('orders.deleted_at')
            ->groupBy('orders.status')
            ->get();

        $data = array_merge($data_pending->toArray(), $data_order->toArray());

        return $data;
    }

    /************************************************************************
      public function pdf($id)	{

          $data = $this->model->select(\DB::raw("LPAD(cs.id,7,'0') AS customer_id"),'cs.rif','cs.business_name','cs.address','cs.telephone','cs.mobile','states.description as state','city.description as city',
                                       \DB::raw("LPAD(orders.id,7,'0') as id"),\DB::raw("LPAD(orders.id,7,'0') as receipt_id"),'companies.description as company',\DB::raw("CONCAT(mt.description,'-> SN: ',t.serial) AS terminal"),
                                       \DB::raw("CONCAT(op.description,'-> SN: ',s.serial_sim) AS simcard"),\DB::raw("LPAD(users.id,4,'0') AS user_id"),\DB::raw("CONCAT(users.name,' ',users.last_name) as user_name"),'orders.updated_at')
                                ->leftjoin('contracts as ct', function($join){
                                  $join->on('ct.id','=','orders.contract_id');
                                  $join->whereNull('ct.deleted_at');
                                })
                                   ->leftjoin('customers as cs', function($join){
                                      $join->on('cs.id','=','ct.customer_id');
                                      $join->whereNull('cs.deleted_at');
                                    })
                                      ->leftjoin('terminals as t', function($join){
                                        $join->on('t.id','=','ct.terminal_id');
                                        $join->whereNull('t.deleted_at');
                                      })
                                        ->leftjoin('modelterminal as mt', function($join){
                                          $join->on('mt.id','=','t.modelterminal_id');
                                          $join->whereNull('t.deleted_at');
                                        })
                                          ->leftjoin('simcards as s', function($join){
                                            $join->on('s.id','=','ct.simcard_id');
                                            $join->whereNull('s.deleted_at');
                                          })
                                            ->leftjoin('operators as op', function($join){
                                              $join->on('op.id','=','s.operator_id');
                                              $join->whereNull('op.deleted_at');
                                            })
                                              ->leftjoin('states', function($join){
                                                $join->on('states.id','=','cs.state_id');
                                               })
                                                 ->leftjoin('cities as city', function($join){
                                                   $join->on('city.id','=','cs.city_id');
                                                  })
                                                    ->leftjoin('users','users.id','=','ct.user_created_id')
                                                      ->leftjoin('companies','companies.id','=','ct.company_id')
                                                        ->where('orders.contract_id','=',$id)
                                                          ->first();

          $pdf = \PDF::loadView('operations::orders.delivery-pdf', $data);
          $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
          $pdf->setPaper('P', 'potrait');
        return $pdf->download('Nota de Salida NS-'.$data->receipt_id.'.pdf');
      }*/
    /************************************************************************/
    public function pdf($id)
    {
        $data = $this->model->select('cs.rif', 'cs.business_name', \DB::raw("LPAD(orders.id,7,'0') as order_id"), \DB::raw("CONCAT(mt.description,'-> SN: ',t.serial) AS terminal"))
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'ct.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->leftjoin('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 't.modelterminal_id');
                $join->whereNull('mt.deleted_at');
            })
            ->where('orders.contract_id', '=', $id)
            ->first();

        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        $document = $PHPWord->loadTemplate(storage_path() . '/documents/ns.docx');

        $document->setValue('orden', $data->order_id);
        $document->setValue('rif', $data->rif);
        $document->setValue('business_name', $data->business_name);
        $document->setValue('terminal', $data->terminal);

        $date = Carbon::now();
        $document->setValue('year', $date->isoFormat('YYYY'));
        $document->setValue('year2', $date->isoFormat('YY'));
        $document->setValue('month', ucwords(strtolower($date->monthName)));
        $document->setValue('day', $date->day);

        $document->setValue('user_delivery', Auth::user()->name . ' ' . Auth::user()->last_name);
        $document->setValue('jobtitle_delivery', Auth::user()->jobtitle);
        $document->setValue('email_delivery', Auth::user()->email);

        $document->saveAs(storage_path() . '/temporal/ns.docx');
        header('Content-disposition: attachment;filename=NOTA_SALIDA_ ' . $data->orden . '.docx; charset=iso-8859-1');
        echo file_get_contents(storage_path() . '/temporal/ns.docx');
    }

    /*************************Notificaciones Equipo Listo********************/
    public function notificationSMS($mobile, $contract_id)
    {
    }

    /************************************************************************/
    public function reportOffice($request)
    {
        return Excel::download(new ReportOfficeExport($request), 'Reporte Despacho ' . date('Y-m-d') . '.xlsx');
    }
}
