<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Operations\Repositories\OrderInterface;
use App\Modules\Parameters\Repositories\BankInterface;
use App\Modules\Parameters\Repositories\PayerInterface;
use App\Modules\Sales\Exports\ActivoReportExport;
use App\Modules\Sales\Exports\DemographicReportExport;
use App\Modules\Sales\Exports\InvoiceActiveReportExport;
use App\Modules\Sales\Exports\RaffiliateReportExport;
use App\Modules\Sales\Exports\ServiceActiveReportExport;
use App\Modules\Sales\Exports\ServiceBankMovementReportExport;
use App\Modules\Sales\Exports\ServiceDetailReportExport;
use App\Modules\Sales\Exports\ServiceFinancialReportExport;
use App\Modules\Sales\Models\Domiciliation;
use App\Modules\Sales\Models\Forecast;
use App\Modules\Sales\Repositories\Affiliate\AffiliateFactory;
use App\Modules\Sales\Repositories\Affiliate\downloadAffiliateFactory;
use App\Modules\Sales\Repositories\Affiliate\Response\AffiliateResponseFactory;
use App\Modules\Sales\Repositories\InvoiceMasive\InvoiceMasiveServiceFactory;
use Auth;
use Carbon\Carbon;
use Datatable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceMasiveRepository implements InvoiceMasiveInterface
{
    protected $invoice;

    protected $contract;

    protected $rcollection;

    protected $forecast;

    protected $bank;

    protected $raffiliate;

    protected $consecutive;

    protected $payer;

    protected $domiciliation;

    protected $adomiciliation;

    protected $tdomiciliation;

    protected $order;

    ////////////////////////////////////////////////////////////////////////////
    public function __construct(
        InvoiceInterface $invoice,
        Forecast $forecast,
        ContractInterface $contract,
        RcollectionInterface $rcollection,
        BankInterface $bank,
        RaffiliateInterface $raffiliate,
        ConsecutiveInterface $consecutive,
        PayerInterface $payer,
        DomiciliationInterface $domiciliation,
        AdomiciliationInterface $adomiciliation,
        OrderInterface $order,
        Domiciliation $tdomiciliation
    ) {
        $this->consecutive = $consecutive;
        $this->raffiliate = $raffiliate;
        $this->contract = $contract;
        $this->rcollection = $rcollection;
        $this->forecast = $forecast;
        $this->invoice = $invoice;
        $this->payer = $payer;
        $this->bank = $bank;
        $this->domiciliation = $domiciliation;
        $this->tdomiciliation = $tdomiciliation;
        $this->adomiciliation = $adomiciliation;
        $this->order = $order;
    }

    //* Afiliacion Bancaria

    public function affiliateStore($request)
    {
        $array = [];
        $adomiciliation = $this->adomiciliation->model->where('adomiciliations.bank_id', $request['bank_id'])->whereNotIn('adomiciliations.status', ['Anulado', 'Enviado', 'Cargado', 'Procesado'])->first();

        if (!isset($adomiciliation)) {
            $model = $this->contract->model->select('cs.rif', \DB::raw("RPAD(TRIM(cs.business_name),35,' ') as business_name"), \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"), \DB::raw("LPAD(dc.id,6,'0') AS dcustomer_id"), \DB::raw("LPAD(dc.bank_id,6,'0') AS bank_id"), 'dc.affiliate_number', 'dc.account_number', 'bk.bank_code', 'bk.description as bank_name', 'dc.personal_signature', 'contracts.status as status_contract', 'terms.serial as serial', 'cs.email as email')
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
                })
                ->join('terminals as terms', function ($join) {
                    $join->on('terms.id', '=', 'contracts.terminal_id');
                    $join->where('terms.status', 'Entregado');
                    $join->whereNull('terms.deleted_at');
                });

            $array = $model->where('dc.bank_id', (int) $request['bank_id'])->whereIn('contracts.status', ['Activo'])->whereNull('contracts.is_affiliate')->orderBy('contracts.id', 'ASC')->get();

            if (isset($array)) {
                $affiliateFactory = new AffiliateFactory();
                $affiliate = $affiliateFactory->initialize($array, $request);
                $result_file = $affiliate->register($array, $request);

                $data_adomiciliation = serialize([
                    'total_register' => $result_file['total_register'],
                ]);

                $result = $this->adomiciliation->create([
                    'bank_id' => $request['bank_id'],
                    'file_bank' => $result_file['filename'],
                    'data' => $data_adomiciliation,
                    'status' => 'Generado',
                ]);

                if (isset($result)) {
                    return ['success' => true, 'message' => 'Gestión Afiliación Bancaría Generada Correctamente', 'result' => $result_file];
                }

                return ['success' => false, 'message' => 'Error al registrar la Gestión Afiliación Bancaría, intente de nuevo o comuniquese con el Area Soporte'];
            }

            return ['success' => true, 'message' => 'No se encontro ningún Contrato para Generar Archivo de Afiliación Bancaría'];
        }

        return ['success' => false, 'message' => 'Existe una Gestión Afiliación Bancaría en Proceso'];
    }
    //? Reporte de Afiliaciones Bancarias

    public function reportAffiliateStore($request)
    {
        $affiliateFactory = new downloadAffiliateFactory();
        $affiliate = $affiliateFactory->fileDownload($data);

        return $affiliate->download($data);
    }
    //? Reporte de Afiliaciones Bancarias

    public function downloadReportAffiliate($request)
    {
        return Excel::download(new RaffiliateReportExport($request), 'Reporte Afiliación Bancaria ' . date('Y-m-d') . '.xlsx');
    }
    //? Subida de archivo Respuesta Afiliaciones Bancarias

    public function affiliateResponse($request)
    {
        $array = file($request['file']);
        $affiliateResponseFactory = new AffiliateResponseFactory();
        $affiliateResponse = $affiliateResponseFactory->initialize($array, $request);

        return $affiliateResponse->response($array);
    }

    //* serviceStore (Proceso por el cual se calculan y generan cobros/invoices masivos)
    //Se encarga de iniciar el proceso de generación, calculo e inserción de los cobros/invoices

    public function serviceStore($request)
    {
        $action = '';
        $message = '';
        if ($request['type_invoice'] == 'P') {
            $this->forecast->query()->truncate();
        }

        $data = $this->generateInvoice($request, $this->queryContract($request, 'commerce'));

        if (count($data) > 0) {
            $cont = $this->insertServiceInvoice($request, $data);
            if ($cont > 0) {
                $action = 'info';
                $message = 'Se ha Generado Correctamente el ' . $this->typeInvoice($request) . ' x un Total de: ' . $cont . ' Contratos Activos';
            } else {
                $action = 'warning';
                $message = 'No hay registros para Generar ' . $this->typeInvoice($request);
            }
        }

        return ['action' => $action, 'message' => $message];
    }
    //* queryContract (Busqueda de Registros a Crear)
    //Recibe la request por parte de la generación de cobros, para calcular que cobros debe generar segun fecha o de manera masiva

    protected function queryContract($request, $type)
    {
        $date_invoice = $this->typeService($request);

        $model = $this->contract->model->query();
        $model->contractService();

        if ($request['type_invoice'] == 'I') {
            $model->whereNotExists(function ($query) use ($date_invoice, $request) {
                $query->select(\DB::raw(1))
                    ->from('invoices')
                    ->where('invoices.contract_id', '=', 'contracts.id')
                    ->where('invoices.concept_id', '=', 2)
                    ->where('invoices.frec_invoice', '=', $request['type_service']);

                if (is_array($date_invoice)) {
                    $query->where('invoices.fechpro', '>=', $date_invoice[0] . '%')
                        ->where('invoices.fechpro', '<=', $date_invoice[1] . '%')
                        ->whereDate('or.posted_at', '<', $date_invoice[0]);
                } else {
                    $query->where('invoices.fechpro', 'LIKE', $date_invoice . '%')
                        ->whereDate('or.posted_at', '<', $date_invoice);
                }

                $query->whereIn('invoices.status', ['G', 'R', 'P'])
                    ->whereNull('invoices.deleted_at');
            });
        }

        if ($request->has('bank_id')) {
            $model->where('dc.bank_id', '=', $request['bank_id']);

            $valid_bank = $this->bank->model->where('banks.id', (int) $request['bank_id'])->where('banks.is_register', 1)->first();

            if (isset($valid_bank)) {
                $model->where('contracts.is_affiliate', 1);
            }
        }

        return $model->where('terms.type_invoice', $request['type_service'])->where('contracts.status', 'LIKE', 'Activo')->where('contracts.type_dcustomer', 'LIKE', $type)->orderBy('contracts.id', 'ASC')->get()->toArray();
    }

    /**
     * * generateInvoice (Generación de cobros/invoices masivos)
     *  Genera los cobros segun el tipo de servicio:
     *  - D: Diario
     *  - Q: Bisemanal ¿?
     *  - M: Mensual
     */
    protected function generateInvoice($request, $contract)
    {
        $cont = 0;
        $data = [];
        foreach ($contract as $row) {
            if ($row['amount'] > 0) {
                $row['fechpro'] = $this->typeService($request);

                //! Validación de Tipo de Servicio
                $invoiceMasive = new InvoiceMasiveServiceFactory();
                $invoice_masive = $invoiceMasive->initialize($request, $row);
                $array = $invoice_masive->fields($request, $row);

                $data[$cont] = $array;
                $cont++;
            }
        }

        return $data;
    }
    //* insertServiceInvoice
    //Calculo de prepagos realizados a los contratos, prorateo de cobro, con el fin de insertar el cobro y su monto

    protected function insertServiceInvoice($request, $data)
    {
        $cont = 0;

        foreach ($data as $array) {
            // ¿El servicio esta Prepagado?
            if ($this->prepaidService($array['detail'], $request)) {
                if ($request['type_service'] == 'M' | $request['type_service'] == 'S') {
                    if ($day_proration = $this->prorationPosted($array['detail'], $request)) {
                        $proration_posted = $day_proration;
                        $proration_reconnection = 0;
                        $proration_warranty = 0;
                    } else {
                        $proration_posted = 0;
                        if ($proration_reconnection = $this->prorationReconnection($array['detail'], $request)) {
                            $proration_warranty = 0;
                        } else {
                            $proration_reconnection = 0;
                            $proration_warranty = 0; // $this->prorationWarranty($array['detail'], $request);
                        }
                    }
                    if ($proration_posted != 0) {
                        if ($request['type_service'] == 'M') {
                            if ($proration_posted < 30) {
                                $array['amount'] = ($array['amount'] / 30) * ($proration_posted);
                            } else {
                                $array['amount'] = $array['amount'];
                            }
                        } else {
                            if ($proration_posted < 7) {
                                $array['amount'] = round(($array['amount'] / 7) * ($proration_posted), 2);
                            } else {
                                $array['amount'] = $array['amount'];
                            }
                        }
                    } elseif ($proration_reconnection != 0) {
                        $array['amount'] = ($array['amount'] / 30) * (30 - $proration_reconnection);
                    } elseif ($proration_warranty != 0) {
                        $array['amount'] = ($array['amount'] / 30) * (30 - $proration_warranty);
                    }
                    if ($array['amount'] < 0) {
                        $array['amount'] = 0.00;
                    }
                }
            }
            if ($request['type_invoice'] == 'I') {
                $invoices = $this->invoice->model;
                if (is_array($array['fechpro'])) {
                    if ($request['type_service'] == 'S') {
                        $date = Carbon::parse($array['fechpro'][0]);
                        $date_end = Carbon::parse($array['fechpro'][1]);
                        $order = $this->order->model->where('orders.contract_id', (int) $array['contract_id'])->where('orders.posted_at', '<', $date_end->format('Y-m-d'))->first();
                        if (isset($order)) {
                            $query = $invoices->where('contract_id', '=', (int) $array['contract_id'])->whereDate('fechpro', $date)->first();
                            $array['fechpro'] = $date->format('Y-m-d');
                            if (!isset($query)) {
                                if ($array['amount'] > 0) {
                                    unset($array['detail']);
                                    $result = $this->invoice->model->insert($array);
                                }
                            }
                        }
                    } else {
                        $date = Carbon::parse($array['fechpro'][0]);
                        $date_end = $array['fechpro'][1];
                        do {
                            $order = $this->order->model->where('orders.contract_id', (int) $array['contract_id'])->where('orders.posted_at', '<', $date->format('Y-m-d'))->first();
                            if (isset($order)) {
                                $array['fechpro'] = $date->format('Y-m-d');

                                $query = $invoices->where('contract_id', '=', (int) $array['contract_id'])->whereDate('fechpro', $date->format('Y-m-d'))->first();
                                if (!isset($query)) {
                                    unset($array['detail']);
                                    $result = $this->invoice->model->insert($array);
                                }
                            }
                            $date->addDay();
                        } while ($date->diffInDays($date_end, false) >= 0);
                    }
                } else {
                    $query = $invoices->where('contract_id', '=', (int) $array['contract_id'])->whereDate('fechpro', $array['fechpro'])->first();

                    if (!isset($query)) {
                        if ($array['amount'] > 0) {
                            unset($array['detail']);
                            $result = $this->invoice->model->insert($array);
                        }
                    }
                }
            } else {
                $query = $this->forecast->where('contract_id', '=', (int) $array['contract_id'])->whereDate('fechpro', $array['fechpro'])->first();

                if (!isset($query)) {
                    $result = $this->forecast->insert($array);
                }
            }

            if (isset($result)) {
                $cont++;
            }
        }

        return $cont;
    }
    //* getInvoiceMasive
    //Provee la data a utilizar en la generación de archivo bancario para la cobranza masiva.

    protected function getInvoiceMasive($request)
    {
        $invoice = $this->invoice->model->select('customers.id as customer_id', 'customers.email', 'customers.mobile', 'invoices.*', 'customers.rif', 'customers.business_name', 'dcustomers.account_number', 'cu.abrev as currency', 'dcustomers.affiliate_number', 'dcustomers.personal_signature', 'terminals.serial as serial_terminal', \DB::raw("(CASE WHEN (dcustomers.type_account='Corriente') THEN 'C' ELSE 'A' END) AS type_account"))
            ->leftjoin('contracts as ct', 'ct.id', '=', 'invoices.contract_id')
            ->leftjoin('customers', 'customers.id', '=', 'ct.customer_id')
            ->leftjoin('dcustomers', 'dcustomers.id', '=', 'ct.dcustomer_id')
            ->leftjoin('currencies as cu', 'cu.id', '=', 'invoices.currency_id')
            ->leftjoin('terminals', 'terminals.id', '=', 'ct.terminal_id')
            ->where('dcustomers.bank_id', (int) $request['bank_id']);

        if ($request['type_manager'] == 'G') {
            if ($request['type_date'] == 'date') {
                $invoice->where('invoices.fechpro', 'LIKE', $request['fechpro'] . '%');
            } else {
                $date = explode('|', $request['date_range']);
                $invoice->where('invoices.fechpro', '>=', $date[0] . '%');
                $invoice->where('invoices.fechpro', '<=', $date[1] . '%');
            }
        } elseif ($request['type_manager'] == 'R') {
            if ($request['date_range'] != null) {
                if (str_contains($request['date_range'], '|')) {
                    $date = explode('|', $request['date_range']);
                    $invoice->where('invoices.fechpro', '>=', $date[0] . '%');
                    $invoice->where('invoices.fechpro', '<=', $date[1] . '%');
                } else {
                    $invoice->where('invoices.fechpro', '>=', $request['date_range'] . '%');
                    $invoice->where('invoices.fechpro', '<=', date('Y-m-d', strtotime('-1 days')) . '%');
                }
            } else {
                $invoice->where('invoices.fechpro', '<', date('Y-m-d', strtotime('-1 days')) . '%');
            }
        }
        $valid_bank = $this->bank->model->where('banks.id', (int) $request['bank_id'])->where('banks.is_register', 1)->first();

        if (isset($valid_bank)) {
            $invoice->where('ct.is_affiliate', 1);
        }
        $data = $invoice->where('invoices.concept_id', 2)->where('ct.status', 'LIKE', 'Activo')->whereIn('invoices.status', ['G', 'R', 'P'])->orderBy('contract_id', 'ASC')->orderBy('fechpro', 'ASC')->get();

        return $data;
    }
    //* downloadBankReport (generación de archivo bancario)
    //Determina que funcion aplicar segun la entidad bancaria. Generando el archivo para domiciliación en base a la data recibida por getInvoiceMasive.

    public function downloadBankReport($request)
    {
        ini_set('memory_limit', '8196M');
        $domiciliation = $this->domiciliation->model->where('domiciliations.bank_id', $request['bank_id'])->whereNotIn('domiciliations.status', ['Anulado', 'Enviado', 'Cargado', 'Procesado'])->first();
        if (!isset($domiciliation)) {
            $data = [];
            $masive = $this->getInvoiceMasive($request);
            if ($masive->count() > 0) {
                foreach ($masive as $key => $row) {
                    $data[$key] = $row;
                    $array = unserialize($row['conceptc']);
                    $data[$key]['bank_name'] = $array['bank_name'];
                    $data[$key]['serial_terminal'] = $array['terminal'];
                    $data[$key]['nrocta'] = str_replace('-', '', $row['account_number']);
                }
                //! Formato a aplicar segun la entidad bancaria

                if ($request['type_format'] == 'bank') {
                    switch ($request['bank_id']) {
                        case 1:
                            $result_file = $this->bdv($data, $request);
                            break;

                        case 2:
                            $result_file = $this->bfc($data, $request);
                            break;

                        case 3:
                            $result_file = $this->bancoPlaza($data, $request);
                            break;

                        case 4:
                            $result_file = $this->bancrecer($data, $request);
                            break;

                        case 5:
                            $result_file = $this->banplus($data, $request);
                            break;

                        case 6:
                            $result_file = $this->bancoSur($data, $request);
                            break;

                        case 7:
                            $result_file = $this->mibanco($data, $request);
                            break;

                        case 8:
                            $result_file = $this->bicentenario($data, $request);
                            break;

                        case 9:
                            $result_file = $this->mercantil($data, $request);
                            break;

                        case 10:
                            $result_file = $this->tesoro($data, $request);
                            break;

                        case 11:
                            $result_file = $this->activo($data, $request);
                            break;

                        case 12:
                            $result_file = $this->cienxciento($data, $request);
                            break;

                        case 13:
                            $result_file = $this->bancaribe($data, $request);
                            break;

                        case 14:
                            $result_file = $this->provincial($data, $request);
                            break;

                        case 15:
                            $result_file = $this->banesco($data, $request);
                            break;

                        default:
                            return ['success' => false, 'message' => 'No existe Estructura Bancaría para generar el Archivo'];
                            break;
                    }
                }

                $data_domiciliation = serialize([
                    'total_amount' => $result_file['total_amount'],
                    'total_amount_currency' => $result_file['total_amount_currency'],
                    'total_register' => $result_file['total_register'],
                ]);

                $date = $request['date_range'] != '' ? explode('|', $request['date_range']) : '';

                $result = $this->domiciliation->create([
                    'bank_id' => $request['bank_id'],
                    'type_management' => $request['type_manager'],
                    'amount_currency' => round((str_replace(',', '', $request['amount_currency']) / 1000000), 2),
                    'amount_currency_old' => str_replace(',', '', $request['amount_currency']),
                    'date_ini' => $date != '' ? $date[0] : null,
                    'date_end' => $date != '' ? $date[1] : null,
                    'file_bank' => $result_file['filename'],
                    'date_operation' => $request['date_operation'],
                    'data_domiciliation' => $data_domiciliation,
                    'status' => 'Generado',
                ]);

                if (isset($result)) {
                    return ['success' => true, 'message' => 'Gestión de Cobranza Servicio Generada Correctamente', 'result' => $result_file];
                }

                return ['success' => false, 'message' => 'Error al registrar la Gestión de Cobranza Servicio, intente de nuevo o comuniquese con el Area Soporte'];
            }

            return ['success' => false, 'message' => 'No se encontro ningún registro de Cobro x Servicios Generado o Pendiente por Conciliar x Gestión Bancaría'];
        }

        return ['success' => false, 'message' => 'Existe una Gestión de Cobranza de Servicio del Banco  en Proceso'];
    }

    //? Prorrateo de Cobranza x Servicios

    protected function prorationPosted($data, $request)
    {
        $order_posted = Carbon::parse($data['order_posted']);

        if ($request['type_service'] == 'S') {
            if ($request['type_weekly'] == 1) {
                $date_invoice = Carbon::parse($request['date_invoice'] . '-01');
                $date_finish = Carbon::parse($request['date_invoice'] . '-7');
            } elseif ($request['type_weekly'] == 2) {
                $date_invoice = Carbon::parse($request['date_invoice'] . '-08');
                $date_finish = Carbon::parse($request['date_invoice'] . '-14');
            } elseif ($request['type_weekly'] == 3) {
                $date_invoice = Carbon::parse($request['date_invoice'] . '-15');
                $date_finish = Carbon::parse($request['date_invoice'] . '-21');
            } elseif ($request['type_weekly'] == 4) {
                $date_invoice = Carbon::parse($request['date_invoice'] . '-22');
                $date_finish = Carbon::parse($request['date_invoice'] . '-28');
            }
        } else {
            $date_invoice = Carbon::parse($request['date_invoice'] . '-01');
            $date_finish = Carbon::parse($request['date_invoice'] . '-' . $date_invoice->daysInMonth);
        }

        if ($order_posted->format('Y-m') != $date_invoice->format('Y-m')) {
            if ($data['prepaid'] != null) {
                $prepaid = $data['prepaid'] * 30;
            } else {
                $prepaid = 0;
            }
            $diff = $order_posted->diffInDays($date_finish);

            return  $diff - $prepaid;
        } elseif ($order_posted->month == $date_invoice->month && $request['type_service'] == 'M') {
            return $order_posted->diffInDays($date_finish);
        } elseif ($order_posted->month == $date_invoice->month && $request['type_service'] == 'S' && $order_posted->diffInDays($date_finish) <= 7) {
            return $order_posted->diffInDays($date_finish);
        }

        return null;
    }
    //? Prorrateo por reconexión

    protected function prorationReconnection($data, $request)
    {
        if ($data['reactive_date'] != null) {
            $date = Carbon::parse($data['reactive_date']);

            return $date->daysInMonth - $date->day;
        }

        return null;
    }
    //? Prorrateo por Garantia

    protected function prorationWarranty($data, $request)
    {
        if (($data['status_contract'] == 'Soporte') && ($data['date_ini'] != null)) {
            $date = Carbon::parse($request['date_invoice'] . '-01');

            $date_ini = Carbon::parse($data['date_ini']);
            if ($date->month == $date_ini->mont) {
                return $date->diffInDays($date_ini);
            }
        } elseif (($data['status_contract'] == 'Activo') && ($data['date_end'] != null)) {
            $date = Carbon::parse($request['date_invoice'] . '-01');
            $date = $request['date_invoice'] . '-' . $date->daysInMonth;
            $date = Carbon::parse($date);

            $date_end = Carbon::parse($data['date_end']);
            if ($date->month == $date_end->mont) {
                return $date->diffInDays($date_end);
            }
        }

        return null;
    }
    //? Servicio Prepagado

    protected function prepaidService($data, $request)
    {
        $order_posted = Carbon::parse($data['order_posted']);
        $date = Carbon::parse($request['date_invoice'] . '-01');
        $date_finish = Carbon::parse($request['date_invoice'] . '-' . $date->daysInMonth);
        if ($order_posted->diffInDays($date_finish) > ($data['prepaid'] * 30)) {
            return true;
        }

        return false;
    }

    //? Tipo de Servicio funcion para determinar tipo de servicio a evaluar en la generación de cobros

    protected function typeService($request)
    {
        switch ($request['type_service']) {
            case 'M':
                return $request['date_invoice'] . '-01';
                break;

            case 'Q':
                if ($request['type_biweekly'] == 1) {
                    return $request['date_invoice'] . '-01';
                } elseif ($request['type_biweekly'] == 2) {
                    return $request['date_invoice'] . '-16';
                }
                break;

            case 'S':
                if ($request['type_weekly'] == 1) {
                    return [$request['date_invoice'] . '-01', $request['date_invoice'] . '-07'];
                } elseif ($request['type_weekly'] == 2) {
                    return [$request['date_invoice'] . '-08', $request['date_invoice'] . '-14'];
                } elseif ($request['type_weekly'] == 3) {
                    return [$request['date_invoice'] . '-15', $request['date_invoice'] . '-21'];
                } elseif ($request['type_weekly'] == 4) {
                    return [$request['date_invoice'] . '-22', $request['date_invoice'] . '-28'];
                }
                break;

            case 'D':
                if ($request['type_date'] == 'range') {
                    return explode('|', $request['date_range']);
                } else {
                    return $request['fechpro'];
                }
                break;

            default:
                return false;
                break;
        }
    }
    //? Tipo de Cobro/Invoice

    protected function typeInvoice($request)
    {
        if ($request['type_invoice'] == 'I') {
            return 'Cobro Servicio Transaccional';
        } else {
            return 'Pronostico';
        }
    }
    //? Datatable de Servicios, creo que esta en desuso

    public function serviceDatatable()
    {
        $data = $this->forecast->select('ct.id as contract_id', 't.serial as serial_terminal', 'forecasts.*', 'cu.abrev as currency')
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'forecasts.contract_id');
            })
            ->join('terminals as t', function ($join) {
                $join->on('t.id', '=', 'ct.terminal_id');
            })->join('currencies as cu', 'cu.id', '=', 'forecasts.currency_id')->get();

        return datatables()->of($data)
            ->editColumn('amount', function ($data) {
                $format = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);
                $action = '<center>' . $format->format($data->amount) . '</center>';

                return $action;
            })
            ->editColumn('nropos', function ($data) {
                $action = '<center>' . str_pad($data->nropos, 3, '0', STR_PAD_LEFT) . '</center>';

                return $action;
            })
            ->rawColumns(['amount', 'nropos'])
            ->toJson();
    }
    //? getServiceBank

    public function getServiceBank($request)
    {
        $data = $this->contract->model->select('bk.description as bank_name', \DB::raw("(CASE WHEN(invoices.status='C') THEN 'Conciliado' WHEN(invoices.status='E') THEN 'Exonerado' ELSE 'Sin Conciliar' END) AS status_invoice"), \DB::raw('COUNT(invoices.id) as total'), \DB::raw('SUM(invoices.amount) as amount_total'))
            ->join('invoices', function ($join) use ($request) {
                $join->on('invoices.contract_id', '=', 'contracts.id');
                $join->where('invoices.concept_id', 2);
                $join->whereIn('invoices.status', ['G', 'R', 'P', 'C']);
                if ($request['type_date'] == 'date') {
                    $join->where('invoices.fechpro', 'LIKE', $request['fechpro'] . '%');
                } elseif ($request['type_date'] == 'range') {
                    $date = explode('|', $request['date_range']);
                    $join->where('invoices.fechpro', '>=', $date[0] . '%');
                    $join->where('invoices.fechpro', '<=', $date[1] . '%');
                }
                $join->whereNull('invoices.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) use ($request) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->where('dc.bank_id', $request['bank_id']);
                $join->whereNull('dc.deleted_at');
            })
            ->join('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->groupBy('invoices.status')
            ->get();

        return $data;
    }

    //! Formatos Bancarios a aplicar segun el banco
    //* Bancaribe

    protected function bancaribe($masive, $request)
    {
        $data = [];
        $cont = 0;
        $total_amount = 0;

        foreach ($masive as $key => $row) {
            $data[$key]['type'] = 'PAP/';
            $data[$key]['blank1'] = '/';
            $data[$key]['zero0'] = '0/';
            $data[$key]['code_bank'] = '0114/';
            $data[$key]['number_account'] = str_pad(substr($row['nrocta'], 0, 20), 20, '0', STR_PAD_LEFT) . '/';
            $data[$key]['type_account'] = 'CTE/';
            $data[$key]['zero1'] = '0/';
            if ($row['currency_id'] > 1) {
                $round = round(str_replace(',', '.', $request['amount_currency']) * str_replace(',', '.', $row['amount']), 2);
                $amount = number_format($round, 2, '.', '');
                $data[$key]['amount'] = $amount;
            } else {
                $data[$key]['amount'] = str_replace(',', '.', $row['amount']);
            }

            $rif = explode('-', $row['rif']);
            // Revisa que el cliente sea Firma Personal, en caso de serlo, le cambia tipo de documento a "R". Asi mismo, los clientes que sean persona natural o firma personal, se les aplica formato integer para que no cuenten con ceros a la izquierda.

            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || $rif[0] == 'E') {
                $data[$key]['rif'] = $rif[0] . (int) $rif[1] . '/';
            } elseif ($rif[0] == 'V' && $row['personal_signature'] == 1) {
                $data[$key]['rif'] = 'R' . $rif[1] . (int) $rif[2] . '/';
            } else {
                $data[$key]['rif'] = $rif[0] . $rif[1] . $rif[2] . '/';
            }

            $data[$key]['business_name'] = preg_replace('([^A-Za-z0-9 ])', ' ', $row['business_name']) . '/';
            $data[$key]['refere'] = (int) $row['id'] . '/';

            $data[$key]['email'] = $row['email'] . '/';
            $data[$key]['mobile'] = str_replace('-', '', $row['mobile']) . '/';

            $total_amount = $total_amount + str_replace('.', '', $data[$key]['amount']);
            $cont++;
        }

        // Establece la ruta del documento a crear
        $document = '/domiciliacion/0114/bank/DOM-' . ($request['date_operation'] != '' ? date('dmy', strtotime($request['date_operation'])) : date_format(now(), 'dmy')) . '-' . date_format(now(), 'his') . '.txt';

        $file = fopen(storage_path() . $document, 'w'); // Abre el documento para escritura
        foreach ($data as $key => $final) {
            // ? Revisa que el conteo de la data no sea menor que el for each?
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['type'] . $final['blank1'] . $final['zero0'] . $final['code_bank'] . $final['number_account'] . $final['type_account'] . $final['zero1'] . $final['amount'] . '/' . $final['rif'] . $final['business_name'] . $final['refere'] . $final['email'] . $final['mobile'] . $final['blank1'] . PHP_EOL);
            } else {
                fwrite($file, $final['type'] . $final['blank1'] . $final['zero0'] . $final['code_bank'] . $final['number_account'] . $final['type_account'] . $final['zero1'] . $final['amount'] . '/' . $final['rif'] . $final['business_name'] . $final['refere'] . $final['email'] . $final['mobile'] . $final['blank1']);
            }
        }
        fclose($file); // Cerrar

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    // * Banplus
    //! New 30-08-2022
    protected function banplus($masive, $request)
    {
        $data = [];
        $total_amount = 0;
        $cont = 0;

        foreach ($masive as $key => $row) {
            $array = unserialize($row['conceptc']);
            $data[$key]['affiliate_number'] = str_pad($array['affiliate_number'], 8);
            $data[$key]['nropos'] = str_pad($row['nropos'], 3, '0', STR_PAD_LEFT);
            $data[$key]['number_account'] = substr($row['nrocta'], 10, 10);
            $rif = explode('-', $row['rif']);
            $data[$key]['rif'] = $rif[0] . str_pad($rif[1], 8, '0', STR_PAD_LEFT) . $rif[2];
            $data[$key]['business_name'] = str_pad(preg_replace('([^A-Za-z0-9 ])', ' ', $row['business_name']), 80, ' ', STR_PAD_RIGHT);
            $data[$key]['type_operation'] = 'DEBITO';
            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, ' ', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, ' ', STR_PAD_LEFT);
            }
            $data[$key]['desc'] = 'ND COBRO VEPAGOS     ';
            $date_operation = $request['date_operation'] != '' ? date('d/m/Y', strtotime($request['date_operation'])) . ' al ' . date('d/m/Y', strtotime($request['date_operation'])) : date_format(now(), 'd/m/Y') . ' al ' . date_format(now(), 'd/m/Y');
            $data[$key]['fechpro'] = str_pad($date_operation, 30, ' ', STR_PAD_RIGHT);
            $data[$key]['refere'] = str_pad($row['id'], 9, '0', STR_PAD_LEFT);
            $cont++;
            $total_amount = trim($total_amount) + trim($data[$key]['amount']);
        }

        $date_operation = $request['date_operation'] != '' ? date('Ymdh.i.s', strtotime($request['date_operation'])) : date_format(now(), 'Ymdh.i.s');

        // $document = "/domiciliacion/0174/bank/" . 'SALVEP' . $date_operation . ".txt";
        $document = '/domiciliacion/0174/bank/' . 'VEP' . '.txt';
        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo
        foreach ($data as $key => $final) {
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['affiliate_number'] . $final['nropos'] . $final['number_account'] . $final['rif'] . $final['business_name'] .
                    $final['type_operation'] . $final['amount'] . $final['desc'] . $final['fechpro'] . $final['refere'] . PHP_EOL);
            } else {
                fwrite($file, $final['affiliate_number'] . $final['nropos'] . $final['number_account'] . $final['rif'] . $final['business_name'] .
                    $final['type_operation'] . $final['amount'] . $final['desc'] . $final['fechpro'] . $final['refere']);
            }
        }
        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Bicentenario
    protected function bicentenario($masive, $request)
    { //TODO:
        $data = [];
        $cont = 0;
        $total_amount = 0;

        foreach ($masive as $key => $row) {
            $array = unserialize($row['conceptc']);

            $data[$key]['affiliate_number'] = str_pad($array['affiliate_number'], 8);
            $data[$key]['nropos'] = str_pad($row['nropos'], 4, '0', STR_PAD_LEFT);

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, '0', STR_PAD_LEFT);
            }
            $total_amount = $total_amount + $data[$key]['amount'];
            $cont++;
        }
        $date_operation = $request['date_operation'] != '' ? $request['date_operation'] : now();
        $document = '/domiciliacion/0175/bank/' . 'MACRO ' . date_format(Carbon::parse($date_operation), 'd-m-Y') . '.txt';
        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo
        foreach ($data as $final) {
            fwrite($file, $final['affiliate_number'] . $final['nropos'] . $final['amount'] . "\r\n");
        }
        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banco Delsur
    protected function bancoSur($masive, $request)
    { //Ok -> En producción
        $data = [];
        $cont = 0;
        $total_amount = 0;

        /*
            $payer = $this->payer->model->where('payers.bank_id',$request['bank_id'])->where('payers.type_file','LIKE','domiciliation')->first();
            if(isset($payer)){
                $payer_consecutive = (int)$payer->consecutive;
            }else{
                $payer_consecutive = null;
            }
            */

        foreach ($masive as $key => $row) {
            $array = unserialize($row['conceptc']);

            $data[$key]['code_company'] = '0266';
            $data[$key]['type_operation'] = '020';
            $data[$key]['subtype'] = '001';
            $data[$key]['number_account'] = str_pad(trim($row['nrocta']), 20, '0', STR_PAD_LEFT);

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, '0', STR_PAD_LEFT);
            }

            $rif = explode('-', $row['rif']);

            $data[$key]['letter_rif'] = $rif[0];

            if (($rif[0] == 'V' || $rif[0] == 'P' || $rif[0] == 'E') && $row['personal_signature'] != 1) {
                $data[$key]['type_ident'] = 'N';
                $data[$key]['rif'] = str_pad((int) $rif[1], 11, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'V' && $row['personal_signature'] == 1) {
                $data[$key]['type_ident'] = 'R';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 11, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'J') {
                $data[$key]['type_ident'] = 'J';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 11, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'G') {
                $data[$key]['type_ident'] = 'G';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 11, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['type_ident'] = 'N';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 11, '0', STR_PAD_LEFT);
            }

            $data[$key]['business_name'] = str_pad(preg_replace('/[.]/', '', preg_replace('/[,]/', ' ', preg_replace("[\n|\r|\n\r]", '', substr(utf8_decode($row['business_name']), 0, 30)))), 30, ' ', STR_PAD_RIGHT);
            $data[$key]['contract'] = str_pad(trim($row['serial_terminal']), 30, '0', STR_PAD_LEFT);

            $date_operation2 = $request['date_operation'] != '' ? date('dmy', strtotime($request['date_operation'])) : date_format(now(), 'dmy');
            $data[$key]['refere'] = $date_operation2 . str_pad($row['id'], 9, '0', STR_PAD_LEFT);
            $data[$key]['invoice'] = $date_operation2 . str_pad($date_operation2 . $row['id'], 24, '0', STR_PAD_LEFT);

            $date = Carbon::now();
            $data[$key]['date_ini'] = date_format(now(), 'dmY');
            $data[$key]['date_collection'] = date_format($date->addDay(), 'dmY');

            $cont++;
            $total_amount = $total_amount + $data[$key]['amount'];
        }

        $document = '/domiciliacion/0157/bank/' . date_format(now(), 'dmY') . 'DOMI' . '.txt';
        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo

        foreach ($data as $key => $final) {
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['code_company'] . $final['refere'] . $final['type_operation'] . $final['subtype'] . $final['number_account'] . $final['amount'] .
                    $final['type_ident'] . $final['letter_rif'] . $final['rif'] . $final['business_name'] . $final['contract'] . $final['invoice'] .
                    $final['date_ini'] . $final['date_collection'] . PHP_EOL);
            } else {
                fwrite($file, $final['code_company'] . $final['refere'] . $final['type_operation'] . $final['subtype'] . $final['number_account'] . $final['amount'] .
                    $final['type_ident'] . $final['letter_rif'] . $final['rif'] . $final['business_name'] . $final['contract'] . $final['invoice'] .
                    $final['date_ini'] . $final['date_collection']);
            }
        }

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banco del Tesoro
    protected function tesoro($masive, $request)
    { //ok Revisado -> Revisión x Cobranza: fecha culminación, Sin referencia
        $data = [];
        $cont = 0;
        $total_amount = 0;

        foreach ($masive as $key => $row) {
            $array = unserialize($row['conceptc']);
            $data[$key]['fixed'] = 'D';
            $data[$key]['number_account'] = str_pad(trim($row['nrocta']), 20, '0', STR_PAD_LEFT);

            $rif = explode('-', $row['rif']);

            if ($rif[0] == 'V' && $row['personal_signature'] == 1) {
                $data[$key]['type_company'] = 'R';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 9, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'E' && $row['personal_signature'] == 1) {
                $data[$key]['type_company'] = 'R';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 9, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'V' && $row['personal_signature'] != 1) {
                $data[$key]['type_company'] = 'V';
                $data[$key]['rif'] = str_pad($rif[1], 9, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'E' && $row['personal_signature'] != 1) {
                $data[$key]['type_company'] = 'E';
                $data[$key]['rif'] = str_pad($rif[1], 9, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['type_company'] = $rif[0];
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 9, '0', STR_PAD_LEFT);
            }

            $data[$key]['blank'] = str_pad('', 5, ' ', STR_PAD_LEFT);

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, '0', STR_PAD_LEFT);
            }

            $data[$key]['zero'] = str_pad($row['id'], 20, '0', STR_PAD_LEFT);

            $cont++;
            $total_amount = $total_amount + $data[$key]['amount'];
        }

        $document = '/domiciliacion/0163/bank/' . 'CJ4565' . date('dmy', strtotime($request['date_operation'])) . '.txt';

        $header['fixed'] = 'H';
        $header['code_company'] = '4565';
        $header['type_operation'] = '1';
        $header['referencia_company'] = str_pad('1', 9, '0', STR_PAD_LEFT);
        $header['account_company'] = '01630903619033006891';
        $header['rif'] = 'J411024449';
        $header['reserve'] = str_pad('', 5, ' ', STR_PAD_LEFT);
        //$header['date1'] = date_format(now(), "dmy");
        //$header['date2'] = date_format(now(), "dmy");

        $header['date1'] = date('dmy', strtotime($request['date_operation']));
        $header['date2'] = date('dmy', strtotime($request['date_operation']));

        $header['total'] = str_pad($cont, 5, '0', STR_PAD_LEFT);
        $header['amount'] = str_pad($total_amount, 15, '0', STR_PAD_LEFT);

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo
        fwrite($file, $header['fixed'] . $header['code_company'] . $header['type_operation'] . $header['referencia_company'] . $header['account_company'] . $header['rif'] .
            $header['reserve'] . $header['date1'] . $header['date2'] . $header['total'] . $header['amount'] . PHP_EOL);

        foreach ($data as $final) {
            fwrite($file, $final['fixed'] . $final['number_account'] . $final['type_company'] . $final['rif'] . $final['blank'] . $final['amount'] . $final['zero'] . PHP_EOL);
        }

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banco Mercantil
    protected function mercantil($masive, $request)
    { //ok Revisado -> Revisión x Cobranza: fecha culminación
        $data = [];
        $cont = 0;
        $total_amount = 0;

        $payer = $this->payer->model->where('payers.bank_id', $request['bank_id'])->where('payers.type_file', 'LIKE', 'domiciliation')->first();
        if (isset($payer)) {
            $payer_consecutive = (int) $payer->consecutive;
        } else {
            $payer_consecutive = null;
        }
        $payer_consecutive = $payer_consecutive + 1;
        if ($payer_consecutive != null) {
            $payer->consecutive = $payer_consecutive;
            $payer->save();
        }

        foreach ($masive as $key => $row) {
            $data[$key]['fixed'] = '2';
            $rif = explode('-', $row['rif']);
            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || ($rif[0] == 'E' && $row['personal_signature'] != 1)) {
                $data[$key]['rif'] = $rif[0] . str_pad($rif[1], 10, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'V' && $row['personal_signature'] == 1 || $rif[0] == 'E' && $row['personal_signature'] == 1) {
                $data[$key]['rif'] = $rif[0] . str_pad($rif[1] . $rif[2], 10, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['rif'] = $rif[0] . str_pad($rif[1] . $rif[2], 10, '0', STR_PAD_LEFT);
            }
            $data[$key]['number_account'] = str_pad($row['nrocta'], 21, '0', STR_PAD_LEFT);

            $data[$key]['blank_reserve'] = str_pad('', 10, ' ', STR_PAD_RIGHT);
            $data[$key]['identification_company'] = str_pad(trim($row['serial_terminal']), 16, ' ', STR_PAD_RIGHT);
            $data[$key]['reserve'] = str_pad('', 9, ' ', STR_PAD_RIGHT);
            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 17, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 17, '0', STR_PAD_LEFT);
            }

            $data[$key]['blank2'] = str_pad('', 30, ' ', STR_PAD_LEFT);
            $data[$key]['identification_company'] = str_pad(trim($row['serial_terminal']), 16, ' ', STR_PAD_RIGHT);
            $data[$key]['reserve2'] = str_pad('', 1, ' ', STR_PAD_RIGHT);
            //$date_operation2 = $request['date_operation'] != '' ? date('dmY', strtotime($request['date_operation'])) : date_format(now(), 'dmY');
            $date_operation2 = $request['date_operation'] != '' ? date('dmy', strtotime($request['date_operation'])) : date_format(now(), 'dmy');
            $data[$key]['refere'] = $date_operation2 . str_pad($row['id'], 9, '0', STR_PAD_LEFT);
            $data[$key]['no_document'] = str_pad('0', 1, '0', STR_PAD_LEFT);
            $data[$key]['financing'] = str_pad('0', 8, '0', STR_PAD_LEFT);
            $data[$key]['date_document'] = str_pad('0', 4, '0', STR_PAD_LEFT);

            $data[$key]['blank3'] = str_pad('', 30, ' ', STR_PAD_LEFT);
            $data[$key]['zero3'] = str_pad('0', 7, '0', STR_PAD_LEFT);
            $data[$key]['refere2'] = str_pad($row['id'], 8, '0', STR_PAD_LEFT);
            $data[$key]['date1'] = str_pad('0', 8, '0', STR_PAD_LEFT);
            $data[$key]['date2'] = str_pad('0', 8, '0', STR_PAD_LEFT);
            $data[$key]['message'] = str_pad(' C C VE PAGOS', 35, ' ', STR_PAD_RIGHT);

            $cont++;
            $total_amount = $total_amount + $data[$key]['amount'];
        }
        $date_operation = $request['date_operation'] != '' ? $request['date_operation'] : now();
        $document = '/domiciliacion/0105/bank/' . 'DOMDOM0269472' . date_format(Carbon::parse($date_operation), 'YmdHis') . '.txt';

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo

        $header['type'] = '1';
        $header['identificator'] = str_pad('BAMRVECA', 12, ' ', STR_PAD_RIGHT);
        $header['letter'] = 'C1';
        $header['lote'] = str_pad($payer_consecutive, 15, ' ', STR_PAD_RIGHT);
        $header['reserve'] = '000000';
        $header['product'] = 'DOMIC';
        $header['rif'] = 'J0411024449';
        $header['cont'] = str_pad($cont, 8, '0', STR_PAD_LEFT);
        $header['total_amount'] = str_pad($total_amount, 17, '0', STR_PAD_LEFT);
        $header['date_register'] = date_format(Carbon::parse($date_operation), 'Ymd');
        $header['account'] = '01050031141031731113';
        $header['aditional'] = str_pad('', 103, '0', STR_PAD_LEFT);
        $header['free'] = str_pad('', 48, ' ', STR_PAD_LEFT);

        fwrite($file, $header['type'] . $header['identificator'] . $header['letter'] . $header['lote'] . $header['reserve'] . $header['product'] . $header['rif'] . $header['cont'] . $header['total_amount'] . $header['date_register'] . $header['account'] . $header['aditional'] . $header['free'] . PHP_EOL);

        foreach ($data as $final) {
            fwrite($file, $final['fixed'] . $final['rif'] . $final['number_account'] .
                $final['blank_reserve'] . $final['identification_company'] . $final['reserve'] . $final['amount'] .
                $final['blank2'] . $final['identification_company'] . $final['reserve2'] . $final['refere'] . $final['no_document'] . $final['financing'] . $final['date_document'] .
                $final['blank3'] . $final['zero3'] . $final['refere2'] . $final['date1'] . $final['date2'] . $final['message'] . PHP_EOL);
        }

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* BFC (Banco Fondo Comun)
    protected function bfc($masive, $request)
    { //ok Revisado -> Revisión x Cobranza: fecha culminación
        $data = [];
        $cont = 1;
        $total_amount = 0;

        foreach ($masive as $key => $row) {
            $data[$key]['consecutive'] = str_pad($cont, 6, '0', STR_PAD_LEFT);
            $data[$key]['blank'] = str_pad('', 3, ' ', STR_PAD_LEFT);
            $data[$key]['number_account'] = $row['nrocta'];

            $rif = explode('-', $row['rif']);
            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || $rif[0] == 'E') {
                $data[$key]['rif'] = $rif[0] . str_pad((int) $rif[1], 10, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['rif'] = $rif[0] . str_pad($rif[1] . $rif[2], 10, '0', STR_PAD_LEFT);
            }
            $data[$key]['zero'] = str_pad('', 10, '0', STR_PAD_LEFT);

            $data[$key]['refere'] = str_pad((int) $row['id'], 10, '0', STR_PAD_LEFT);

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, ' ', STR_PAD_RIGHT);
            }

            $data[$key]['blank1'] = str_pad('', 83, ' ', STR_PAD_LEFT) . '000';
            $data[$key]['blank2'] = str_pad('', 69, ' ', STR_PAD_LEFT);
            $data[$key]['contract'] = str_pad(strtoupper($row['serial_terminal']), 30, '0', STR_PAD_LEFT);
            $data[$key]['invoice'] = str_pad((int) $row['id'], 20, '0', STR_PAD_LEFT);

            $data[$key]['date_register'] = date_format(now(), 'Ymd');
            $data[$key]['date_due'] = date_format(now(), 'Ymd');
            $total_amount = $total_amount + $data[$key]['amount'];
            $cont++;
        }
        $date = Carbon::now();
        $document = '/domiciliacion/0151/bank/' . 'DOM026947' . date_format(now(), 'YmdHis') . '.txt';

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo

        $header['zero'] = '000000';
        $header['created'] = date_format(now(), 'YmdHis');
        $header['date_lote'] = date_format(now(), 'YmdHis');
        $header['date'] = date_format(now(), 'YmdHis');
        $header['code_company'] = '026947';
        $header['zero1'] = str_pad('', 6, '0', STR_PAD_LEFT);
        $header['blank'] = str_pad('', 3, ' ', STR_PAD_LEFT);
        $header['account'] = '01510100861001161802';
        $header['zero2'] = str_pad('', 37, '0', STR_PAD_LEFT);
        $header['blank1'] = str_pad('', 110, ' ', STR_PAD_LEFT);

        $footer['code'] = '999999';
        $footer['company'] = str_pad('VEPAGOS', 40, ' ', STR_PAD_RIGHT);
        $footer['cant'] = str_pad($cont - 1, 6, '0', STR_PAD_LEFT);
        $footer['cant1'] = '000001';
        $footer['cant2'] = str_pad('', 136, ' ', STR_PAD_RIGHT);
        $footer['$total_amount'] = str_pad($total_amount, 15, '0', STR_PAD_LEFT);
        $footer['$total_amount1'] = str_pad($total_amount, 15, '0', STR_PAD_LEFT);

        fwrite($file, $header['zero'] . $header['created'] . $header['date_lote'] . $header['date'] . $header['code_company'] . $header['zero1'] . $header['blank'] . $header['account'] . $header['zero2'] . $header['blank1'] . "\r\n");

        foreach ($data as $final) {
            fwrite($file, $final['consecutive'] . $final['blank'] . $final['number_account'] . $final['rif'] . $final['zero'] . $final['refere'] . $final['amount'] . $final['blank1'] .
                $final['blank2'] . $final['contract'] . $final['invoice'] . $final['date_register'] . $final['date_due'] . "\r\n");
        }
        fwrite($file, $footer['code'] . $footer['company'] . $footer['cant'] . $footer['$total_amount'] . $footer['$total_amount1'] . $footer['cant'] . $footer['cant1'] . $footer['cant2'] . "\r\n");

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Bancrecer
    protected function bancrecer($masive, $request)
    { //ok -> En producción
        $data = [];
        $total_amount = 0;
        $cont = 0;
        /*
            $payer = $this->payer->model->where('payers.bank_id',$request['bank_id'])->where('payers.type_file','LIKE','domiciliation')->first();
            if(isset($payer)){
                $payer_consecutive = (int)$payer->consecutive;
            }else{
                $payer_consecutive = null;
            }*/

        foreach ($masive as $key => $row) {
            $data[$key]['code_bcv'] = '0010';
            $data[$key]['type_operation'] = '020';
            $data[$key]['type_domain'] = '001';
            $data[$key]['number_account'] = $row['nrocta'];

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, ' ', STR_PAD_RIGHT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, ' ', STR_PAD_RIGHT);
            }

            $rif = explode('-', $row['rif']);

            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || $rif[0] == 'E') {
                $data[$key]['type_company'] = 'N';
                $data[$key]['rif'] = str_pad((int) $rif[1], 11, ' ', STR_PAD_RIGHT);
            } elseif ($rif[0] == 'V' && $row['personal_signature'] == 1) {
                $data[$key]['type_company'] = 'N';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 11, ' ', STR_PAD_RIGHT);
            } else {
                $data[$key]['type_company'] = 'J';
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 11, ' ', STR_PAD_RIGHT);
            }

            $data[$key]['letter_rif'] = $rif[0] != 'R' ? $rif[0] : 'V';
            $data[$key]['business_name'] = str_pad(preg_replace('/[.]/', '', preg_replace('/[,]/', ' ', preg_replace("[\n|\r|\n\r]", '', substr(utf8_decode($row['business_name']), 0, 30)))), 30, ' ', STR_PAD_RIGHT);

            $data[$key]['serial_terminal'] = str_pad(trim($row['serial_terminal']), 30, ' ', STR_PAD_RIGHT);

            $date_operation = $request['date_operation'] != '' ? date('dmY', strtotime($request['date_operation'])) : date_format(now(), 'dmY');
            $data[$key]['fechpro'] = $date_operation;
            $data[$key]['date_due'] = $date_operation;
            /*
                if($payer_consecutive != 0){
                    $consecutive = $this->consecutive->model->where('consecutives.invoice_id',(int)$row['id'])->whereNull('consecutives.is_management')->first();
                        if(isset($consecutive)){
                            $data[$key]['refere'] = str_pad((int)$consecutive['consecutive'], 15, "0", STR_PAD_LEFT);
                            $data[$key]['refere2'] = str_pad((int)$row['id'], 20, "0", STR_PAD_LEFT);
                        }else{
                            $payer_consecutive++;
                            $consec = $this->consecutive->model->create([
                                'fechpro' => date_format(now(),"Y-m-d"),
                                'bank_id' => $request['bank_id'],
                                'invoice_id' => (int)$row['id'],
                                'consecutive' => $payer_consecutive,
                                'is_management' => 1,
                                'user_created_id' => Auth::user()->id
                            ]);
                            if(isset($consec)){
                                $data[$key]['refere'] = str_pad((int)$consec['consecutive'], 15, "0", STR_PAD_LEFT);
                                $data[$key]['refere2'] = str_pad((int)$row['id'], 20, "0", STR_PAD_LEFT);
                            }
                        }
                    }else{
                        $data[$key]['refere'] = str_pad($row['id'], 15, "0", STR_PAD_LEFT);
                        $data[$key]['refere2'] = str_pad($row['id'], 20, "0", STR_PAD_LEFT);
                    }
                    */
            $date_operation2 = $request['date_operation'] != '' ? date('dmy', strtotime($request['date_operation'])) : date_format(now(), 'dmy');
            $data[$key]['refere'] = $date_operation2 . str_pad($row['id'], 9, '0', STR_PAD_LEFT);
            $data[$key]['refere2'] = $date_operation2 . str_pad($date_operation2 . $row['id'], 14, '0', STR_PAD_LEFT);

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, ' ', STR_PAD_RIGHT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, ' ', STR_PAD_RIGHT);
            }

            $cont++;
            $total_amount = trim($total_amount) + trim($data[$key]['amount']);
        }

        /*
        if($payer_consecutive != null){
            $payer->consecutive = $payer_consecutive;
            $payer->save();
        }*/

        $date_operation = $request['date_operation'] != '' ? date('dmy', strtotime($request['date_operation'])) : date_format(now(), 'dmy');
        $document = '/domiciliacion/0168/bank/' . 'DO_0010_' . $date_operation . '.TXT';

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo
        foreach ($data as $key => $final) {
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['code_bcv'] . $final['refere'] . $final['type_operation'] . $final['type_domain'] . $final['number_account'] .
                    $final['amount'] . $final['type_company'] . $final['letter_rif'] . $final['rif'] . $final['business_name'] . $final['serial_terminal'] . $final['refere2'] . $final['fechpro'] . $final['date_due'] . PHP_EOL);
            } else {
                fwrite($file, $final['code_bcv'] . $final['refere'] . $final['type_operation'] . $final['type_domain'] . $final['number_account'] .
                    $final['amount'] . $final['type_company'] . $final['letter_rif'] . $final['rif'] . $final['business_name'] . $final['serial_terminal'] . $final['refere2'] . $final['fechpro'] . $final['date_due']);
            }
        }
        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banco de Venezuela
    protected function bdv($masive, $request)
    { //ok Revisado -> Revisión x Cobranza: fecha culminación
        $data = [];
        $cont = 0;
        $total_amount = 0;
        foreach ($masive as $key => $row) {
            $data[$key]['identificator'] = '02';
            $rif = explode('-', $row['rif']);
            $data[$key]['letter_rif'] = $rif[0];
            if ($data[$key]['letter_rif'] == 'V' || $data[$key]['letter_rif'] == 'E') {
                $validation = 0;
            } else {
                $validation = $rif[2];
            }
            $data[$key]['rif'] = str_pad($rif[1] . $validation, 9, '0', STR_PAD_LEFT);
            $data[$key]['customer_id'] = str_pad($row['customer_id'], 20, '0', STR_PAD_LEFT);
            $data[$key]['type_payment'] = 'C';
            $data[$key]['account_type'] = '00';
            $data[$key]['number_account'] = $row['nrocta'];
            $data[$key]['blank1'] = str_pad('', 77, '0', STR_PAD_LEFT);
            $data[$key]['date'] = date_format(now(), 'd/m/Y');

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 13, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 13, '0', STR_PAD_LEFT);
            }
            $data[$key]['refere'] = str_pad($row['id'], 20, '0', STR_PAD_LEFT);
            $data[$key]['email'] = str_pad('', 50, '0', STR_PAD_LEFT);

            $cont++;
            $total_amount = $total_amount + $data[$key]['amount'];
        }
        $date = Carbon::now();
        $document = '/domiciliacion/0102/bank/' . 'archivo_de_cobranza' . date_format(now(), 'Ymd') . '.txt';
        // $document =  "/domiciliacion/0102/bank/" . str_pad('99', 8, "0", STR_PAD_LEFT) . '-' . date_format(now(), "d-m-Y") . '-Operacion ' . $total_amount . ".txt";

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo

        fwrite($file, '01J411024449' . str_pad($cont, 10, '0', STR_PAD_LEFT) . str_pad($total_amount, 13, '0', STR_PAD_LEFT) . date_format(now(), 'd/m/Y') . str_pad(date_format(now(), 'dmYh'), 10, '0', STR_PAD_LEFT) . str_pad(date_format(now(), 'dmYh'), 20, '0', STR_PAD_LEFT) . str_pad('', 40, '0', STR_PAD_LEFT) . date_format(now(), 'd/m/Y') . date_format(now(), 'd/m/Y') . PHP_EOL);

        foreach ($data as $final) {
            fwrite($file, $final['identificator'] . $final['letter_rif'] . $final['rif'] . $final['customer_id'] . $final['type_payment'] . $final['account_type'] . $final['number_account'] . $final['blank1'] . $final['date'] . $final['amount'] . $final['refere'] . $final['email'] . PHP_EOL);
        }

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banco Plaza
    protected function bancoPlaza($masive, $request)
    { //ok -> En producción
        $data = [];
        $cont = 0;
        $total_amount = 0;

        $fechpro = Carbon::parse($request['fechpro']);

        foreach ($masive as $key => $row) {
            $array = unserialize($row['conceptc']);

            $data[$key]['type_register'] = 2;

            $rif = explode('-', $row['rif']);
            $data[$key]['letter_rif'] = $rif[0];
            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || ($rif[0] == 'E' && $row['personal_signature'] != 1)) {
                $data[$key]['rif'] = str_pad((int) $rif[1], 10, '0', STR_PAD_LEFT);
            } elseif ($rif[0] == 'V' && $row['personal_signature'] == 1 || $rif[0] == 'E' && $row['personal_signature'] == 1) {
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 10, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['rif'] = str_pad($rif[1] . $rif[2], 10, '0', STR_PAD_LEFT);
            }
            $data[$key]['affiliate_number'] = trim($array['affiliate_number']);
            $data[$key]['nropos'] = str_pad($row['nropos'], 4, '0', STR_PAD_LEFT);
            $data[$key]['number_account'] = $row['nrocta'];
            $data[$key]['fechpro'] = date_format(now(), 'mmY');
            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, '0', STR_PAD_LEFT);
            }
            $data[$key]['refere'] = str_pad($row['id'], 13, '0', STR_PAD_LEFT);

            $cont++;
            $total_amount = $total_amount + $data[$key]['amount'];
        }
        $date_operation = $request['date_operation'] != '' ? $request['date_operation'] : now();
        $document = '/domiciliacion/0138/bank/' . 'DOMVPGPOS' . date_format(Carbon::parse($date_operation), 'Ymd') . '00060' . '.txt';
        // $document = "/domiciliacion/0138/bank/" . 'DOMVPGPOS' . date_format($date_operation, "Ymd") . "00060_" . date_format($date_operation, "his") . ".txt";

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo
        fwrite($file, '1J0411024449' . date_format(Carbon::parse($date_operation), 'Ymd') . '00060' . str_pad($cont, 5, '0', STR_PAD_LEFT) . str_pad($total_amount, 15, '0', STR_PAD_LEFT) . str_pad('', 30, ' ', STR_PAD_LEFT) . PHP_EOL);
        foreach ($data as $key => $final) {
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['type_register'] . $final['letter_rif'] . $final['rif'] . $final['affiliate_number'] . $final['nropos'] . date_format($fechpro, 'my') . $final['number_account'] . $final['amount'] . str_pad('', 60, ' ', STR_PAD_LEFT) . $final['refere'] . PHP_EOL);
            } else {
                fwrite($file, $final['type_register'] . $final['letter_rif'] . $final['rif'] . $final['affiliate_number'] . $final['nropos'] . date_format($fechpro, 'my') . $final['number_account'] . $final['amount'] . str_pad('', 60, ' ', STR_PAD_LEFT) . $final['refere']);
            }
        }

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Mi Banco
    protected function mibanco($masive, $request)
    { //ok -> En producción
        $data = [];
        $cont = 0;
        $total_amount = 0;
        $fechpro = Carbon::parse($request['date_operation']);
        foreach ($masive as $key => $row) {
            $data[$key]['type_register'] = '02';
            $data[$key]['type_account'] = $row['type_account'];
            $data[$key]['number_account'] = str_pad($row['nrocta'], 20, '0', STR_PAD_LEFT);
            $data[$key]['date'] = date_format($fechpro, 'dmY');
            $data[$key]['type_note'] = 'ND';
            $data[$key]['refere'] = '024' . date_format($fechpro, 'dm') . substr(date('y'), -1);

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, '0', STR_PAD_LEFT);
            }

            $data[$key]['affiliate_number'] = (int) $row['affiliate_number'];
            $data[$key]['nropos'] = str_pad($row['nropos'], 4, '0', STR_PAD_LEFT);
            $data[$key]['lote'] = str_pad((int) $row['id'], 6, '0', STR_PAD_LEFT);
            $data[$key]['bank'] = str_pad('', 41, ' ', STR_PAD_LEFT);

            $total_amount = $total_amount + $data[$key]['amount'];

            $cont++;
        }

        $document = '/domiciliacion/0169/bank/' . '20023' . date_format($fechpro, 'dmY') . '.txt';

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo

        $header['fixed'] = '00';
        $header['date'] = date_format($fechpro, 'dmY');
        $header['total_register'] = str_pad($cont, 6, '0', STR_PAD_LEFT);
        $header['total_amount'] = str_pad($total_amount, 15, '0', STR_PAD_LEFT);
        $header['aditional'] = str_pad('', 69, ' ', STR_PAD_LEFT);

        fwrite($file, $header['fixed'] . $header['date'] . $header['total_register'] . $header['total_amount'] . $header['aditional'] . PHP_EOL);

        foreach ($data as $key => $final) {
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['type_register'] . $final['type_account'] . $final['number_account'] . $final['date'] . $final['type_note'] . $final['refere'] . $final['amount'] . $final['affiliate_number'] . $final['nropos'] . $final['lote'] . $final['bank'] . PHP_EOL);
            } else {
                fwrite($file, $final['type_register'] . $final['type_account'] . $final['number_account'] . $final['date'] . $final['type_note'] . $final['refere'] . $final['amount'] . $final['affiliate_number'] . $final['nropos'] . $final['lote'] . $final['bank']);
            }
        }
        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banco Activo
    protected function activo($masive, $request)
    { //ok -> En producción
        $data = [];
        $cont = 0;
        $total_amount = 0;
        foreach ($masive as $key => $row) {

            $data[$key]['number_account'] = substr($row['nrocta'], 10, 10);
            $vowels = array("-", " ", ".");
            $data[$key]['rif'] = str_replace($vowels, "", $row['rif']);
            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 13, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 13, '0', STR_PAD_LEFT);
            }
            $data[$key]['date'] = date("dm", strtotime($row['fechpro'])) . date("Y", strtotime($row['fechpro'])) . date("m", strtotime($row['fechpro']));
            $data[$key]['affiliate_number'] = (int) $row['affiliate_number'];
            $data[$key]['nropos'] = str_pad($row['nropos'], 3, '0', STR_PAD_LEFT);
            $data[$key]['refere'] = str_pad($row['id'], 55, ' ', STR_PAD_RIGHT);
            $data[$key]['aliado'] = str_pad("Vepagos", 13, ' ', STR_PAD_RIGHT);
            $data[$key]['tipocobro'] = "M";

            $total_amount = $total_amount + $data[$key]['amount'];
            $cont++;
        }

        $date_operation = $request['date_operation'] != '' ? $request['date_operation'] : now();
        $document = '/domiciliacion/0171/bank/' . 'F03_20013_' . date_format(Carbon::parse($date_operation), 'dmY') . '.txt';
        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo

        foreach ($data as $key => $final) {
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['number_account'] . $final['rif'] . $final['amount'] . $final['date'] . $final['affiliate_number'] . $final['nropos'] .  $final['refere'] . $final['aliado'] . $final['tipocobro'] . PHP_EOL);
            } else {
                fwrite($file, $final['number_account'] . $final['rif'] . $final['amount'] . $final['date'] . $final['affiliate_number'] . $final['nropos'] .  $final['refere'] . $final['aliado'] . $final['tipocobro']);
            }
        }
        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banco 100%
    protected function cienxciento($masive, $request)
    { //ok -> Producción
        $cont = 0;
        $total_amount = 0;
        $data = [];

        $date = date('Ymdhis', strtotime(now()));

        $rif_company = 'J0411024449';
        $bank = '01560030610201795843';
        $message = 'DOMICILIACION DE VEPAGOS';
        $title = str_pad($message, 40, ' ', STR_PAD_RIGHT);

        foreach ($masive as $key => $row) {
            $array = unserialize($row['conceptc']);

            $rif = explode('-', $row['rif']);
            // Revisa que el cliente sea Firma Personal, en caso de serlo, le cambia tipo de documento a "R". Asi mismo, los clientes que sean persona natural o firma personal, se les aplica formato integer para que no cuenten con ceros a la izquierda.

            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || $rif[0] == 'E') {
                $data[$key]['rif'] = $rif[0] . str_pad($rif[1], 11, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['rif'] = $rif[0] . str_pad($rif[1] . $rif[2], 11, '0', STR_PAD_LEFT);
            }

            $data[$key]['number_account'] = $row['nrocta'];

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, '0', STR_PAD_LEFT);
            }
            $data[$key]['concepct'] = str_pad('C/C VEPAGOS', 40, ' ', STR_PAD_RIGHT);
            $data[$key]['affiliate_number'] = str_pad($array['affiliate_number'], 8, '0', STR_PAD_LEFT);
            $data[$key]['nropos'] = str_pad($row['nropos'], 3, '0', STR_PAD_LEFT);
            $data[$key]['refere'] = str_pad($row['id'], 12, '0', STR_PAD_LEFT);

            $cont++;
            $total_amount = $total_amount + $data[$key]['amount'];
        }

        $total_register = str_pad($cont, 8, '0', STR_PAD_LEFT);
        $amount = str_pad($total_amount, 17, '0', STR_PAD_LEFT);
        $date_operation = $request['date_operation'] != '' ? $request['date_operation'] : now();
        $document = '/domiciliacion/0156/bank/' . 'VEPAGOS_ ' . date_format(Carbon::parse($date_operation), 'dmY') . '.txt';

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo
        fwrite($file, $date . $total_register . $amount . $rif_company . $bank . $title . PHP_EOL);

        foreach ($data as $key => $final) {
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['rif'] . $final['number_account'] . $final['amount'] . $final['concepct'] . $final['affiliate_number'] . $final['nropos'] . $final['refere'] . PHP_EOL);
            } else {
                fwrite($file, $final['rif'] . $final['number_account'] . $final['amount'] . $final['concepct'] . $final['affiliate_number'] . $final['nropos'] . $final['refere']);
            }
        }

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Provincial
    protected function provincial($masive, $request)
    {
        $data = [];
        $cont = 0;
        $total_amount = 0;

        foreach ($masive as $key => $row) {
            $data[$key]['number_account'] = str_pad(substr($row['nrocta'], 0, 20), 21, ' ', STR_PAD_RIGHT);
            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, '0', STR_PAD_LEFT);
            }
            $data[$key]['business_name'] = preg_replace('([^A-Za-z0-9 ])', ' ', $row['business_name']);
            $data[$key]['refere'] = str_pad($row['id'], 17, ' ', STR_PAD_RIGHT);

            $total_amount = $total_amount + $data[$key]['amount'];
            $cont++;
        }

        // Establece la ruta del documento a crear
        $document = '/domiciliacion/0108/bank/PROV-' . ($request['date_operation'] != '' ? date('dmy', strtotime($request['date_operation'])) : date_format(now(), 'dmy')) . '-' . date_format(now(), 'his') . '.txt';

        $file = fopen(storage_path() . $document, 'w'); // Abre el documento para escritura
        foreach ($data as $key => $final) {
            // ? Revisa que el conteo de la data no sea menor que el for each?
            if ($key < (count($data) - 1)) {
                fwrite($file, $final['number_account'] . $final['refere'] . $final['amount'] . ' ' . $final['business_name'] . PHP_EOL);
            } else {
                fwrite($file, $final['number_account'] . $final['refere'] . $final['amount'] . ' ' . $final['business_name']);
            }
        }
        fclose($file); // Cerrar

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }

    //* Banesco
    protected function banesco($masive, $request)
    { //CREADO ALCIDES DA SILVA 16-05-2023
        $data = [];
        $cont = 0;
        $total_amount = 0;

        foreach ($masive as $key => $row) {
            $data[$key]['tipe_registre'] = '03';
            $data[$key]['moneda'] = 'VES';
            $data[$key]['number_account'] = str_pad($row['nrocta'], 30, ' ', STR_PAD_RIGHT);
            $data[$key]['code_swift'] = str_pad('BANSVECA', 11, ' ', STR_PAD_RIGHT);
            $name = substr($row['business_name'], 0, 30);
            $data[$key]['business_name'] = str_pad(preg_replace('([^A-Za-z0-9 ])', ' ', $name), 35, ' ', STR_PAD_RIGHT);

            $rif = explode('-', $row['rif']);
            if (($rif[0] == 'V' && $row['personal_signature'] != 1) || $rif[0] == 'E') {
                $data[$key]['rif'] = $rif[0] . str_pad((int) $rif[1], 16, ' ', STR_PAD_RIGHT);
            } else {
                $data[$key]['rif'] = $rif[0] . str_pad($rif[1] . $rif[2], 16, ' ', STR_PAD_RIGHT);
            }
            $data[$key]['zero'] = str_pad('', 10, '0', STR_PAD_LEFT);

            $data[$key]['refere'] = str_pad((int) $row['id'], 10, '0', STR_PAD_LEFT);

            if ($row['currency_id'] > 1) {
                $amount = round(str_replace(',', '', $request['amount_currency']) * str_replace(',', '', $row['amount']), 2);
                $data[$key]['amount'] = str_pad(str_replace('.', '', ($amount * 100)), 15, '0', STR_PAD_LEFT);
            } else {
                $data[$key]['amount'] = str_pad(str_replace('.', '', str_replace(',', '', $row['amount'])), 15, ' ', STR_PAD_RIGHT);
            }

            $data[$key]['contract'] = str_pad(strtoupper($row['serial_terminal']), 35, ' ', STR_PAD_RIGHT);
            $data[$key]['invoice'] = str_pad((int) $row['id'], 30, ' ', STR_PAD_RIGHT);

            $data[$key]['date_register'] = date_format(now(), 'Ymd');
            $data[$key]['date_due'] = date_format(now(), 'Ymd');
            $total_amount = $total_amount + $data[$key]['amount'];
            $cont++;
        }
        $date = Carbon::now();
        $document = '/domiciliacion/0134/bank/' . 'BdomCC' . date_format(now(), 'dMyHis') . '.txt';

        $file = fopen(storage_path() . $document, 'w'); // Abrir archivo


        //CABEZERA FIJA
        $fijar['res1'] = 'HDR';
        $fijar['res2'] = str_pad('BANESCO', 15, ' ', STR_PAD_RIGHT);
        $fijar['res3'] = str_pad('E', 1, ' ', STR_PAD_RIGHT);
        $fijar['res4'] = 'D  96ADIRDEBP';

        $header['zero1'] = '01';
        $header['zero2'] = str_pad('SUB', 35, ' ', STR_PAD_RIGHT);
        $header['zero3'] = str_pad('9', 3, ' ', STR_PAD_RIGHT);
        $header['zero4'] = str_pad(date_format(now(), 'YmdHis'), 35, ' ', STR_PAD_RIGHT);
        $header['zero5'] = str_pad(date('YmdHis', strtotime($request['date_operation'])), 14, ' ', STR_PAD_RIGHT);

        $tress['cabe1'] = '02';
        $tress['cabe2'] = str_pad(date_format(now(), 'dmyH'), 30, ' ', STR_PAD_RIGHT);
        $tress['cabe3'] = str_pad('J411024449', 17, ' ', STR_PAD_RIGHT);
        $tress['cabe4'] = str_pad('VEPAGOS', 35, ' ', STR_PAD_RIGHT);
        $tress['cabe5'] = str_pad($total_amount, 15, '0', STR_PAD_LEFT);
        $tress['cabe6'] = 'VES ';
        $tress['cabe7'] = str_pad('01340031860311160776', 35, ' ', STR_PAD_RIGHT);
        $tress['cabe8'] = str_pad('BANSVECA', 11, ' ', STR_PAD_RIGHT);
        $tress['cabe9'] = str_pad(date('Ymd', strtotime($request['date_operation'])), 8, ' ', STR_PAD_RIGHT);
        $tress['cabe0'] = 'CB';

        $footer['foo1'] = '04';
        $footer['foo2'] = str_pad('1', 15, '0', STR_PAD_LEFT);
        $footer['foo3'] = str_pad($cont, 15, '0', STR_PAD_LEFT);
        $footer['foo4'] = str_pad($total_amount, 15, '0', STR_PAD_LEFT);

        fwrite($file, $fijar['res1'] . $fijar['res2'] . $fijar['res3'] . $fijar['res4'] . "\r\n");
        fwrite($file, $header['zero1'] . $header['zero2'] . $header['zero3'] . $header['zero4'] . $header['zero5'] . "\r\n");
        fwrite($file, $tress['cabe1'] . $tress['cabe2'] . $tress['cabe3'] . $tress['cabe4'] . $tress['cabe5'] . $tress['cabe6'] . $tress['cabe7'] . $tress['cabe8'] . $tress['cabe9'] . $tress['cabe0'] . "\r\n");

        foreach ($data as $final) {
            fwrite($file, $final['tipe_registre'] . $final['invoice'] . $final['amount'] . $final['moneda'] . $final['number_account'] . $final['code_swift'] . $final['rif']  . $final['business_name'] . "   " . $final['contract'] . "      " . "\r\n");
        }

        fwrite($file, $footer['foo1'] . $footer['foo2'] . $footer['foo3'] . $footer['foo4'] . "\r\n");

        fclose($file); // Cerrar archivo

        return ['filename' => $document, 'total_amount' => $total_amount != 0 ? number_format(($total_amount / 100), 2, ',', '.') : 0, 'currency' => $request['amount_currency'], 'total_amount_currency' => $total_amount != 0 ? number_format((($total_amount / 100) / round(str_replace(',', '', $request['amount_currency']), 2)), 2, ',', '.') : 0, 'total_register' => $cont];
    }


    //* reportFinancial
    //Query enviado al servicio de ServiceFinancialReportExport, para generar el Reporte de Cartera Financiera
    public function reportFinancial($request)
    {
        $query = $this->contract->model->query();

        $query->select(
            // \DB::raw("CONCAT(bk.bank_code,LPAD(cs.id, 6, '0'),t.serial,terms.abrev) as code_unique"),
            \DB::raw("CONCAT(bk.bank_code,LPAD(cs.foreign_id,6,'0'),t.serial,terms.abrev) as code_unique"),
            \DB::raw("(CASE WHEN (cs.foreign_id IS NOT NULL) THEN LPAD(cs.foreign_id,6,'0') ELSE '----' END) AS foreign_id"),
            'contracts.id AS contract_id',
            \DB::raw('TRIM(dc.affiliate_number) as affiliate_number'),
            't.serial as serial_terminal',
            'mt.description as modelterminal',
            'bk.description as bank',
            'dc.account_number',
            'terms.abrev as term',
            \DB::raw("(CASE WHEN (terms.type_invoice = 'D') THEN 'Diario' WHEN (terms.type_invoice='S') THEN 'Semanal' WHEN (terms.type_invoice='Q') THEN 'Quincenal' WHEN (terms.type_invoice='M') THEN 'Mensual' ELSE '----' END) AS type_invoice"),
            'terms.comission_flatrate',
            \DB::raw('(terms.comission_flatrate*30) as total_month'),
            \DB::raw("DATE_FORMAT(or.posted_at, '%Y-%m-%d') as order_osted"),
            \DB::raw("LPAD(contracts.nropos, 3, '0') as nropos"),
            \DB::raw("LPAD(cs.id, 6, '0') as customer_id"),
            'contracts.status as contract_status'
        )
            ->join('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'contracts.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->join('terms', 'terms.id', '=', 'contracts.term_id')
            ->join('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->join('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->join('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'contracts.id');
                $join->where('or.status', 'C');
                $join->whereNull('or.deleted_at');
            });
        if ($request['bank_id'] != null) {
            $query->where('bk.id', $request['bank_id']);
        }

        if ($request['mterminal_id'] != null) {
            $query->where('t.modelterminal_id', $request['mterminal_id']);
        }

        if ($request['term_id'] != null) {
            $query->where('terms.id', $request['term_id']);
        }

        if ($request['date_range'] != null) {
            $date = explode('|', $request['date_range']);
            $query->whereBetween('or.posted_at', [$date[0], $date[1]]);
        }

        if ($request['field'] != null) {
            $count = count($request['field']);

            for ($i = 0; $i < $count; $i++) {
                if ($request['field'][$i] != null && $request['query'][$i] != null) {
                    if ($request['operator'][$i] != null) {
                        $operator = $request['operator'][$i];
                    } else {
                        $operator = '=';
                    }

                    if ($i == 0) {
                        if ($request['field'][$i] == 'affiliate_number') {
                            $table = 'dc.';
                        } elseif ($request['field'][$i] == 'customer_id') {
                            $table = 'contracts.';
                        } elseif ($request['field'][$i] == 'serial') {
                            $table = 't.';
                        }

                        $query->where($table . $request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    } else {
                        if ($cond == 'AND' || $cond == '') {
                            $query->where($table . $request['field'][$i], $operator, $request['query'][$i]);
                            $cond = $request['conditional'][$i];
                        } else {
                            $query->OrWhere($table . $request['field'][$i], $operator, $request['query'][$i]);
                            $cond = $request['conditional'][$i];
                        }
                    }
                }
            }
        }
        $data = $query->get();

        return Excel::download(new ServiceFinancialReportExport($data), 'Reporte Cartera Financiera ' . date('Y-m-d') . '.xlsx');
    }

    //* reportBankMovement
    //Query enviado al servicio de ServiceBankMovementReportExport, para generar el Reporte de Resumen Bancario
    public function reportBankMovement($request)
    {
        $query = $this->domiciliation->model->query();

        $query->select(\DB::raw('DATE(domiciliations.date_operation) AS Fecha'), 'ban.description AS Banco', 'domiciliations.amount_currency_old AS Tasa_Aplicada', 'domiciliations.total_register AS Registros_Enviados', 'domiciliations.total_amount_register AS Monto_Enviado_Bs', \DB::raw('round(
            domiciliations.total_amount_register / domiciliations.amount_currency_old,
            2
        ) AS Monto_Enviado_USD'), 'domiciliations.total_processed AS Registros_Aprobados', 'domiciliations.total_amount_processed AS Monto_Aprobado_Bs', \DB::raw('round(
            domiciliations.total_amount_processed / domiciliations.amount_currency_old,
            2
        ) AS Monto_Aprobado_USD'), 'domiciliations.total_pending AS Registros_Pendientes_Bs', 'domiciliations.total_amount_pending AS Monto_Pendiente_Bs', \DB::raw('round(
            domiciliations.total_amount_pending / domiciliations.amount_currency_old,
            2
        ) AS Monto_Pendiente_USD'), 'domiciliations.total_processed_real AS Registros_Procesados', 'domiciliations.total_amount_processed_real AS Monto_Procesado_Bs')
            ->join('banks as ban', 'ban.id', '=', 'domiciliations.bank_id')
            ->whereNull('domiciliations.deleted_at')->whereNotNull('domiciliations.date_operation')->where('domiciliations.status', 'Procesado');

        if ($request['date_range'] != null) {
            $date = explode('|', $request['date_range']);
            $query->whereBetween('domiciliations.date_operation', [$date[0], $date[1]]);
        }

        $data = $query->get();

        return Excel::download(new ServiceBankMovementReportExport($data), 'Resumen Bancario ' . date('Y-m-d') . '.xlsx');
    }

    //* downloadInvoiceDetail
    //Query enviado al servicio de ServiceDetailReportExport, para generar el Reporte Cobranza Servicio Diaria
    public function downloadInvoiceDetail($request)
    {
        ini_set('memory_limit', '-1');
        $model = $this->invoice->model->select(
            'invoices.contract_id',
            'invoices.id',
            'cs.id as customer_id',
            \DB::raw("(CASE WHEN (cs.foreign_id IS NOT NULL) THEN LPAD(cs.foreign_id, 6, '0') ELSE '----' END) AS foreign_id"),
            'cs.rif',
            'cs.business_name',
            'banks.description',
            \DB::raw("(REPLACE(dc.account_number, '-', '')) as nrocta"),
            'invoices.fechpro',
            \DB::raw("(CASE WHEN (collections.id IS NOT NULL) THEN collections.fechpro ELSE '----' END) AS fechpro_collection"),
            'invoices.amount',
            \DB::raw("(CASE WHEN (collections.id IS NOT NULL) THEN collections.dicom ELSE '----' END) AS amount_currency"),
            \DB::raw("(CASE WHEN (collections.id IS NOT NULL) THEN (collections.amount_currency) ELSE '----' END) AS total_amount"),
            \DB::raw("(CASE WHEN (invoices.status='G') THEN 'Generado' WHEN (invoices.status='P') THEN 'Pendiente' WHEN (invoices.status='C') THEN 'Conciliado' WHEN (invoices.status='E') THEN 'Exonerado' WHEN (invoices.status='N') THEN 'En Negociación' WHEN (invoices.status='R') THEN 'Rezagado' ELSE '----' END)  AS status_invoice"),
            \DB::raw('(TRIM(dc.affiliate_number)) as affiliate_number'),
            \DB::raw('(TRIM(contracts.nropos)) as posnumber'),
            \DB::raw('UPPER(t.serial) AS serial'),
            'terms.abrev as term',
            \DB::raw("(CASE WHEN (terms.type_invoice='D') THEN 'Diaria' WHEN (terms.type_invoice='S') THEN 'Semanal' WHEN (terms.type_invoice='Q') THEN 'Quincenal' WHEN (terms.type_invoice='M') THEN 'Mensual' ELSE '----' END) AS typeinvoice_term"),
            \DB::raw("CONCAT(SUBSTRING_INDEX(dc.account_number,'-', 1),LPAD(cs.foreign_id,6,'0'),UPPER(t.serial),UPPER(simcards.serial_sim)) AS code_concat"),
            'collections.refere',
            'invoices.created_at'
        )
            ->leftjoin('contracts', function ($join) {
                $join->on('contracts.id', '=', 'invoices.contract_id');
                $join->whereNull('contracts.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
            })
            ->leftjoin('banks', function ($join) {
                $join->on('banks.id', '=', 'invoices.bank_id');
            })
            ->leftjoin('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
            })
            ->leftjoin('collections', function ($join) {
                $join->on('collections.invoice_id', '=', 'invoices.id');
                $join->whereNull('collections.deleted_at');
            })
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'contracts.terminal_id');
            })
            ->leftjoin('simcards', function ($join) {
                $join->on('simcards.id', '=', 'contracts.simcard_id');
            });

        if ($request->has('statusc') && $request['statusc'] != null) {
            if ($request['statusc'] == 'G') {
                $model->whereIn('invoices.status', ['G', 'P']);
            } else {
                $model->where('invoices.status', 'LIKE', $request['statusc']);
            }
        }

        if ($request->has('bank_id') && $request['bank_id'] != null) {
            $model->where('invoices.bank_id', $request['bank_id']);
        }

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {

                if ($request->has('statusc') && $request['statusc'] != null) {

                    if ($request['statusc'] == 'G' or $request['statusc'] == 'P') {
                        $model->whereBetween('invoices.fechpro', [$date[0] . ' 00:00:00', $date[1] . '  00:00:00']);
                    } else {
                        $model->whereBetween('collections.created_at', [$date[0] . ' 00:00:00', $date[1] . ' 23:59:59']);
                    }
                } else {

                    //$model->whereBetween('collections.created_at', [$date[0].' 00:00:00', $date[1].' 23:59:59']);
                    $model->whereBetween('invoices.fechpro', [$date[0] . ' 00:00:00', $date[1] . '  00:00:00']);
                }
            }
        }

        $data = $model->where('invoices.concept_id', 2)->orderBy('term', 'ASC')->orderBy('affiliate_number', 'ASC')->get();

        return Excel::download(new ServiceDetailReportExport($data), 'Reporte Cobranza Servicio Diaria ' . date('Y-m-d') . '.xlsx');
    }

    //* demographicReport
    //Query enviado al servicio de DemographicReportExport, para generar el Reporte Cartera Demográfica
    public function demographicReport($request)
    {
        return Excel::download(new DemographicReportExport($request), 'Reporte Cartera Demográfica ' . date('Y-m-d') . '.xlsx');
    }

    //* reportService
    //Query enviado al servicio de ServiceActiveReportExport, para generar el Consolidado Pronostico Cobro x Servicios
    public function reportService()
    {
        $data = $this->forecast->select('banks.description as bank_name', 'ct.id as contract_id', 't.serial as serial_terminal', 'forecasts.*', 'forecasts.fechpro as date_invoice', 'cu.abrev as currency')
            ->join('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'forecasts.contract_id');
            })
            ->join('terminals as t', function ($join) {
                $join->on('t.id', '=', 'ct.terminal_id');
            })
            ->join('currencies as cu', 'cu.id', '=', 'forecasts.currency_id')
            ->join('banks', function ($join) {
                $join->on('banks.id', '=', 'forecasts.bank_id');
            })
            ->get()
            ->toArray();

        return Excel::download(new ServiceActiveReportExport($data), 'Consolidado Pronostico Cobro x Servicios ' . date('Y-m-d') . '.xlsx');
    }

    //* activeReport
    //Query enviado al servicio de InvoiceActiveReportExport, para generar el Reporte Cobranza Activa
    public function activeReport($request)
    {
        ini_set('memory_limit', '-1');
        $model = $this->contract->model->select(
            \DB::raw("UPPER(CONCAT(banks.bank_code,LPAD((CASE WHEN (cs.foreign_id IS NULL) THEN '0' ELSE LPAD(cs.foreign_id,6,'0') END),6,'0'),t.serial,terms.abrev)) AS number_account"),
            'banks.description as bank_name',
            'contracts.id AS contract_id',
            'cs.rif',
            \DB::raw("LPAD(cs.id,6,'0') AS customer_id"),
            \DB::raw("(CASE WHEN (cs.foreign_id IS NOT NULL) THEN LPAD(cs.foreign_id,6,'0') ELSE '----' END) AS foreign_id"),
            'cs.business_name',
            \DB::raw("DATE_FORMAT(or.posted_at, '%Y-%m-%d') AS posted"),
            \DB::raw("(SELECT collections.fechpro FROM collections LEFT JOIN invoices ON invoices.id=collections.invoice_id AND invoices.concept_id=2 WHERE invoices.contract_id=contracts.id AND invoices.status LIKE 'C' AND collections.deleted_at IS NULL ORDER BY collections.id DESC LIMIT 1) AS fechpro_collection"),
            \DB::raw("(SELECT collections.amount FROM collections LEFT JOIN invoices ON invoices.id=collections.invoice_id AND invoices.concept_id=2 WHERE invoices.contract_id=contracts.id AND invoices.status LIKE 'C' AND collections.deleted_at IS NULL ORDER BY collections.id DESC LIMIT 1) AS amount_collection"),
            \DB::raw("(SELECT collections.amount_currency FROM collections LEFT JOIN invoices ON invoices.id=collections.invoice_id AND invoices.concept_id=2 WHERE invoices.contract_id=contracts.id AND invoices.status LIKE 'C' AND collections.deleted_at IS NULL ORDER BY collections.id DESC LIMIT 1) AS amount_currency_collection"),
            \DB::raw('UPPER(t.serial) as serial_terminal'),
            \DB::raw("(CASE WHEN(((SELECT SUM(invoices.amount) FROM invoices WHERE invoices.contract_id=contracts.id AND invoices.concept_id=2 AND invoices.status IN ('G','P','R') AND invoices.deleted_at IS NULL)) IS NOT NULL) THEN (SELECT SUM(invoices.amount) FROM invoices WHERE invoices.contract_id=contracts.id AND invoices.concept_id=2 AND invoices.status IN ('G','P','R') AND invoices.deleted_at IS NULL)  ELSE '----' END) AS amount_invoice"),
            'mt.description as modelterminal',
            'terms.abrev as term_abrev',
            'terms.comission_flatrate',
            \DB::raw("(SELECT COUNT(invoices.id) FROM invoices WHERE invoices.contract_id=contracts.id  AND invoices.concept_id=2 AND invoices.status IN ('G','P','R') AND invoices.deleted_at IS NULL) AS count_invoice"),
            'contracts.status AS contract_status'
        )
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'contracts.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'contracts.dcustomer_id');
            })
            ->leftjoin('banks', function ($join) {
                $join->on('banks.id', '=', 'dc.bank_id');
            })
            ->leftjoin('terms', function ($join) {
                $join->on('terms.id', '=', 'contracts.term_id');
            })
            ->leftjoin('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 'contracts.modelterminal_id');
            })
            ->leftjoin('terminals as t', function ($join) {
                $join->on('t.id', '=', 'contracts.terminal_id');
            })
            ->leftjoin('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'contracts.id');
                $join->whereNull('or.deleted_at');
            });

        if ($request['bank_id'] != '') {
            $model->where('dc.bank_id', $request['bank_id']);
        }

        if ($request['statusc'] != '') {
            $model->where('contracts.status', $request['statusc']);
        }

        $data = $model->orderBy('bank_name', 'ASC')->orderBy('foreign_id', 'ASC')->whereIn('contracts.status', ['Cancelado', 'Activo', 'Suspendido', 'Soporte'])->get();

        return Excel::download(new InvoiceActiveReportExport($data), 'Reporte Cobranza Activa ' . date('Y-m-d') . '.xlsx');
    }
}
