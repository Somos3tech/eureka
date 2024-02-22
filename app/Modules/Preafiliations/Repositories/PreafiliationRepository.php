<?php

namespace App\Modules\Preafiliations\Repositories;

use App\Events\Preafiliation as PreafiliationEvent;
use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\Dcustomer;
use App\Modules\Customers\Models\Rcustomer;
use App\Modules\Parameters\Models\City;
use App\Modules\Parameters\Models\State;
use App\Modules\Parameters\Repositories\BankInterface;
use App\Modules\Parameters\Repositories\CactivityInterface;
use App\Modules\Parameters\Repositories\CompanyInterface;
use App\Modules\Parameters\Repositories\CurrencyInterface;
use App\Modules\Parameters\Repositories\MterminalInterface;
use App\Modules\Parameters\Repositories\OperatorInterface;
use App\Modules\Parameters\Repositories\PmethodInterface;
use App\Modules\Parameters\Repositories\TermInterface;
use App\Modules\Preafiliations\Exports\PreafiliationReportExport;
use App\Modules\Preafiliations\Models\Preafiliation;
use App\Modules\Sales\Models\Contract;
use App\Modules\Sales\Models\Invoice;
use Auth;
//Reporte Cliente
use Datatable;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class PreafiliationRepository implements PreafiliationInterface
{
    protected $preafiliation;

    protected $company;

    protected $cactivity;

    protected $bank;

    protected $modelterminal;

    protected $operator;

    protected $term;

    protected $pmethod;

    protected $currency;

    /**
     * PreafiliationRepository constructor.
     *
     * @param  Preafiliation  $preafiliation
     */
    public function __construct(
        Preafiliation $preafiliation,
        CompanyInterface $company,
        CactivityInterface $cactivity,
        BankInterface $bank,
        MterminalInterface $modelterminal,
        OperatorInterface $operator,
        TermInterface $term,
        PmethodInterface $pmethod,
        CurrencyInterface $currency
    ) {
        $this->model = $preafiliation;
        $this->company = $company;
        $this->cactivity = $cactivity;
        $this->bank = $bank;
        $this->modelterminal = $modelterminal;
        $this->operator = $operator;
        $this->term = $term;
        $this->pmethod = $pmethod;
        $this->currency = $currency;
    }

    /*************************Registrar Preafiliación*************************/
    public function create($request)
    {
        $customer = [
            'company_id' => $request['company_id'],
            'business_name' => $request['business_name'],
            'cactivity_id' => $request['cactivity_id'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'mobile' => $request['mobile'],
            'mobile2' => $request['mobile'],
            'state_id' => $request['state_id'],
            'city_id' => $request['city_id'],
            'municipality' => $request['municipality'],
            'address' => $request['address'],
            'postal_code' => $request['postal_code'],
        ];

        $state_fiscal_id = $request->has('state_fiscal_id') ? $request['state_fiscal_id'] : null;
        $city_fiscal_id = $request->has('city_fiscal_id') ? $request['city_fiscal_id'] : null;
        $municipality_fiscal = $request->has('municipality_fiscal') ? $request['municipality_fiscal'] : null;
        $address_fiscal = $request->has('address_fiscal') ? $request['address_fiscal'] : null;
        $postal_code_fiscal = $request->has('postal_code_fiscal') ? $request['postal_code_fiscal'] : null;

        $fiscal = [
            'state_fiscal_id' => $state_fiscal_id,
            'city_fiscal_id' => $city_fiscal_id,
            'municipality_fiscal' => $municipality_fiscal,
            'address_fiscal' => $address_fiscal,
            'postal_code_fiscal' => $postal_code_fiscal,
        ];

        $rcustomer = [
            'ident_number' => serialize($request['ident_number_r']),
            'fullname' => serialize($request['fullname_r']),
            'jobtitle' => serialize($request['jobtitle_r']),
            'email' => serialize($request['email_r']),
            'mobile' => serialize($request['mobile_r']),
        ];

        $mercantil = [
            'type_cont' => $request['type_cont'],
            'tax' => $request->has('tax') ? $request['tax'] : null,
        ];

        $bank = [
            'bank_id' => $request['bank_id'],
            'bank_code' => $request['bank_code'],
            'account_bank' => $request['account_bank'],
            'affiliate_number' => $request['affiliate_number'],
        ];

        $contract = [
            'modelterminal_id' => $request['modelterminal_id'],
            'operator_id' => $request['operator_id'],
            'term_id' => $request['term_id'],
        ];

        if ($request->has('amountm')) {
            $amount = str_replace(',', '', $request['amountm']);
        } else {
            $amount = str_replace(',', '', $request['amount']);
        }

        $dicom = str_replace(',', '', $request['dicom']);

        if ($dicom == 0) {
            $dicom = 1;
        }

        $payment = [
            'pmethod_id' => $request['pmethod_id'],
            'currency_id' => $request['currency_id'],
            'currency' => $request['currency'],
            'dicom' => $dicom,
            'amount' => $amount,
            'amount_exchange' => $amount * $dicom,
            'refere' => $request['refere'],
        ];

        $data_customer = serialize(array_merge($customer, $fiscal));
        $data_rcustomer = serialize($rcustomer);
        $data_mercantil = serialize($mercantil);
        $data_bank = serialize($bank);
        $data_contract = serialize($contract);
        $data_payment = serialize($payment);

        $result = $this->model->create([
            'company_id' => $request['company_id'],
            'rif' => $request['rif'],
            'data_customer' => $data_customer,
            'document_rif' => $request['rif_path'],
            'data_rcustomer' => $data_rcustomer,
            'data_mercantil' => $data_mercantil,
            'document_mercantil' => $request['rm_path'],
            'data_bank' => $data_bank,
            'document_bank' => $request['bank_path'],
            'autorization_bank' => $request['auth_bank_path'],
            'data_contract' => $data_contract,
            'data_payment' => $data_payment,
            'document_payment' => $request['payment_path'],
            'observation_initial' => $request['observation_initial'],
            'status' => 'Cargado',
            'user_created_id' => $request['user_id'],
            'consultant_id' => $request['consultant_id'],
        ]);

        if ($result) {
            if ($request->has('rif_path') && $request['rif_path'] != null) {
                Storage::disk('base')->move('temporal/' . $request['rif'] . '/' . $request['rif_path'], 'preafiliations/' . $request['rif'] . '/' . $request['rif_path']);
            }

            if ($request->has('rm_path') && $request['rm_path'] != null) {
                Storage::disk('base')->move('temporal/' . $request['rif'] . '/' . $request['rm_path'], 'preafiliations/' . $request['rif'] . '/' . $request['rm_path']);
            }

            if ($request->has('bank_path') && $request['bank_path'] != null) {
                Storage::disk('base')->move('temporal/' . $request['rif'] . '/' . $request['bank_path'], 'preafiliations/' . $request['rif'] . '/' . $request['bank_path']);
            }

            if ($request->has('auth_bank_path') && $request['auth_bank_path'] != null) {
                Storage::disk('base')->move('temporal/' . $request['rif'] . '/' . $request['auth_bank_path'], 'preafiliations/' . $request['rif'] . '/' . $request['auth_bank_path']);
            }

            if ($request->has('payment_path') && $request['payment_path'] != null) {
                Storage::disk('base')->move('temporal/' . $request['rif'] . '/' . $request['payment_path'], 'preafiliations/' . $request['rif'] . '/' . $request['payment_path']);
                Storage::deleteDirectory(storage_path('temporal') . '/' . $request['rif']);
            }
            $data = $this->model->whereIn('preafiliations.status', ['Cargado'])->get();
            event(new PreafiliationEvent($data->count()));

            return true;
        }

        return false;
    }

    /********************Buscar Información Preafiliación*********************/
    public function find($id)
    {
        $data = $this->arrayData($id, null);

        return $data->toArray();
    }

    /*******************Trasladar Archivos de Preafiliación******************/
    private function moveDirectory($row, $rif)
    {
        if (isset($row['document_rif']) && $row['document_rif'] != null) {
            if (file_exists(storage_path() . '/preafiliations/' . $rif . '/' . $row['document_rif'])) {
                Storage::disk('base')->move('preafiliations/' . $rif . '/' . $row['document_rif'], 'customers/' . $rif . '/' . $row['document_rif']);
            }
        }

        if (isset($row['document_mercantil']) && $row['document_mercantil'] != null) {
            if (file_exists(storage_path() . '/preafiliations/' . $rif . '/' . $row['document_mercantil'])) {
                Storage::disk('base')->move('preafiliations/' . $rif . '/' . $row['document_mercantil'], 'customers/' . $rif . '/' . $row['document_mercantil']);
            }
        }

        if (isset($row['document_bank']) && $row['document_bank'] != null) {
            if (file_exists(storage_path() . '/preafiliations/' . $rif . '/' . $row['document_bank'])) {
                Storage::disk('base')->move('preafiliations/' . $rif . '/' . $row['document_bank'], 'customers/' . $rif . '/' . $row['document_bank']);
            }
        }

        if (isset($row['autorization_bank']) && $row['autorization_bank'] != null) {
            if (file_exists(storage_path() . '/preafiliations/' . $rif . '/' . $row['autorization_bank'])) {
                Storage::disk('base')->move('preafiliations/' . $rif . '/' . $row['autorization_bank'], 'customers/' . $rif . '/' . $row['autorization_bank']);
            }
        }

        if (isset($row['document_payment']) && $row['document_payment'] != null) {
            if (file_exists(storage_path() . '/preafiliations/' . $rif . '/' . $row['document_payment'])) {
                Storage::disk('base')->move('preafiliations/' . $rif . '/' . $row['document_payment'], 'customers/' . $rif . '/' . $row['document_payment']);
            }
        }

        if (isset($row['path_rcustomer']) && $row['path_rcustomer'] != null) {
            foreach ($row['path_rcustomer'] as $file) {
                if (file_exists(storage_path() . '/preafiliations/' . $rif . '/' . $file)) {
                    Storage::disk('base')->move('preafiliations/' . $rif . '/' . $file, 'customers/' . $rif . '/' . $file);
                }
            }

            Storage::deleteDirectory(storage_path('preafiliations') . '/' . $rif);
        }
    }

    /*************************Actualizar Preafiliación************************/
    public function updateValid($request, $id)
    {
        $data = [
            'is_rif' => $request['is_rif'],
            'is_bank' => $request['is_bank'],
            'is_auth_bank' => $request['is_auth_bank'],
            'is_mercantil' => $request['is_mercantil'],
            'is_payment' => $request['is_payment'],
            'status' => $request['status'],
            'user_updated_id' => Auth::user()->id,
        ];

        $preafiliation = $this->model->where('preafiliations.id', '=', $id)->first();
        $result = $preafiliation->update($data);

        if (isset($result)) {
            if ($request['status'] == 'Procesado') {
                //Crear Registro Customer
                $preafiliation = $this->model->where('preafiliations.id', '=', $id)->first();

                $data_customer = unserialize($preafiliation->data_customer);
                $data_mercantil = unserialize($preafiliation->data_mercantil);

                $documents = [
                    'document_rif' => $preafiliation['document_rif'],
                    'document_mercantil' => $preafiliation['document_mercantil'],
                    'document_bank' => $preafiliation['document_bank'],
                    'document_payment' => $preafiliation['document_payment'],
                    'autorization_bank' => $preafiliation['autorization_bank'],
                ];

                $data_rcustomer = unserialize($preafiliation->data_rcustomer);

                $ident_number = unserialize($data_rcustomer['ident_number']);
                $fullname = unserialize($data_rcustomer['fullname']);
                $jobtitle = unserialize($data_rcustomer['jobtitle']);
                $email = unserialize($data_rcustomer['email']);
                $mobile = unserialize($data_rcustomer['mobile']);

                if (array_key_exists('path_document', $data_rcustomer)) {
                    $path_document = unserialize($data_rcustomer['path_document']);
                } else {
                    $path_document = [];
                }

                $array = [
                    'rif' => $preafiliation['rif'],
                    'company_id' => $preafiliation['company_id'],
                    'business_name' => $data_customer['business_name'],
                    'cactivity_id' => $data_customer['cactivity_id'],
                    'email' => $data_customer['email'],
                    'telephone' => $data_customer['mobile2'],
                    'mobile' => $data_customer['mobile'],
                    'state_id' => $data_customer['state_id'],
                    'city_id' => $data_customer['city_id'],
                    'municipality' => $data_customer['municipality'],
                    'address' => $data_customer['address'],
                    'postal_code' => $data_customer['postal_code'],
                    'type_cont' => $data_mercantil['type_cont'],
                    'tax' => $data_mercantil['tax'],
                    'file_document' => serialize($documents),
                    'user_created_id' => $preafiliation->user_created_id,
                ];

                if (array_key_exists('state_fiscal_id', $data_mercantil)) {
                    $fiscal = [
                        'fiscal' => 1,
                        'state_fiscal_id' => $data_customer['state_fiscal_id'],
                        'city_fiscal_id' => $data_customer['city_fiscal_id'],
                        'municipality_fiscal' => $data_customer['municipality_fiscal'],
                        'address_fiscal' => $data_customer['address_fiscal'],
                        'postal_code_fiscal' => $data_customer['postal_code_fiscal'],
                    ];
                } else {
                    $fiscal = [];
                }

                $mercantil = [
                    'date_register' => $request->has('date_register') ? $request['date_register'] : null,
                    'comercial_register' => $request->has('comercial_register') ? $request['comercial_register'] : null,
                    'city_register' => $request->has('city_register') ? $request['city_register'] : null,
                    'number_register' => $request->has('number_register') ? $request['number_register'] : null,
                    'took_register' => $request->has('took_register') ? $request['took_register'] : null,
                    'clause_register' => $request->has('clause_register') ? $request['clause_register'] : null,
                ];

                $documents = array_merge($documents, ['path_rcustomer' => $path_document]);
                $this->moveDirectory($documents, $preafiliation['rif']);

                $data = array_merge($array, $mercantil, $fiscal);
                $customer = Customer::where('customers.rif', 'LIKE', $preafiliation['rif'])->first();
                if (!isset($customer)) {
                    $customer = Customer::create($data);
                    $customer_id = $customer->id;
                    $data_dcustomer = unserialize($preafiliation->data_bank);
                    $dcustomer = Dcustomer::create([
                        'customer_id' => $customer_id,
                        'bank_id' => $data_dcustomer['bank_id'],
                        'affiliate_number' => $data_dcustomer['affiliate_number'],
                        'type_account' => 'Corriente',
                        'account_number' => $data_dcustomer['bank_code'] . $data_dcustomer['account_bank'],
                        'user_created_id' => $preafiliation->user_created_id,
                    ]);
                    $dcustomer_id = $dcustomer->id;

                    for ($i = 0; $i < count($ident_number); $i++) {
                        $rcustomer = Rcustomer::create([
                            'customer_id' => $customer->id,
                            'document' => $ident_number[$i],
                            'first_name' => $fullname[$i],
                            'jobtitle' => $jobtitle[$i],
                            'email' => $email[$i],
                            'telephone' => $mobile[$i],
                            'file_document' => $path_document[$i] ?? '',
                            'user_created_id' => $preafiliation->user_created_id,
                        ]);

                        $data_contract = unserialize($preafiliation->data_contract);
                        $contract = Contract::create([
                            'customer_id' => $customer_id,
                            'dcustomer_id' => $dcustomer_id,
                            'type_dcustomer' => 'commerce',
                            'company_id' => $preafiliation->company_id,
                            'modelterminal_id' => $data_contract['modelterminal_id'],
                            'operator_id' => $data_contract['operator_id'],
                            'observation' => $preafiliation->observation_initial,
                            'term_id' => $data_contract['term_id'],
                            'status' => 'Pendiente',
                            'user_created_id' => $preafiliation->user_created_id,
                            'consultant_id' => $preafiliation->consultant_id,
                        ]);
                    }
                    $contract_id = $contract->id;

                    $data_payment = unserialize($preafiliation->data_payment);

                    $pmethod = $this->pmethod->select('slug')->where('id', $data_payment['pmethod_id'])->first();
                    if (isset($pmethod)) {
                        $tipnot = $pmethod->slug;
                    } else {
                        $tipnot = 'Efectivo';
                    }
                    $invoice = Invoice::create([
                        'company_id' => $preafiliation->company_id,
                        'customer_id' => $customer_id,
                        'contract_id' => $contract_id,
                        'fechpro' => date('Y-m-d', strtotime(now())),
                        'refere' => $data_payment['refere'],
                        'currency_id' => $data_payment['currency_id'],
                        'concept_id' => 1,
                        'rif' => $customer->rif,
                        'business_name' => $customer->business_name,
                        'payment_date' => date('Y-m-d', strtotime(now())),
                        'tipnot' => $tipnot,
                        'type_sale' => 'basic',
                        'amount' => $data_payment['amount'],
                        'free' => 0.00,
                        'amount_currency' => $data_payment['dicom'],
                        'frec_invoice' => 'D',
                        'conceptc' => 'COBRO VENTA EQUIPO',
                        'conciliation_doc' => $preafiliation->document_payment,
                        'status' => 'G',
                        'user_created_id' => $preafiliation->user_created_id,
                    ]);
                }

                ////////////////////////////////////////////////////////////
                //AGREGADO ALCIDES DA SILVA 01/06/2023
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://192.168.0.23:9191/profit/GrabarCliente/' . $preafiliation['rif']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                /////////////////////////////////////////////////////////////


            }
            $data = $this->model->whereIn('preafiliations.status', ['Cargado'])->get();
            event(new PreafiliationEvent($data->count()));

            return \Response::json($result);
        }

        return false;
    }

    /*************************Actualizar Preafiliación************************/
    public function update($request, $id)
    {
        $customer = [
            'company_id' => $request['company_id'],
            'business_name' => $request['business_name'],
            'cactivity_id' => $request['cactivity_id'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'mobile' => $request['mobile'],
            'mobile2' => $request['mobile'],
            'state_id' => $request['state_id'],
            'city_id' => $request['city_id'],
            'municipality' => $request['municipality'],
            'address' => $request['address'],
            'postal_code' => $request['postal_code'],
        ];

        $state_fiscal_id = $request->has('state_fiscal_id') ? $request['state_fiscal_id'] : null;
        $city_fiscal_id = $request->has('city_fiscal_id') ? $request['city_fiscal_id'] : null;
        $municipality_fiscal = $request->has('municipality_fiscal') ? $request['municipality_fiscal'] : null;
        $address_fiscal = $request->has('address_fiscal') ? $request['address_fiscal'] : null;
        $postal_code_fiscal = $request->has('postal_code_fiscal') ? $request['postal_code_fiscal'] : null;

        $fiscal = [
            'state_fiscal_id' => $state_fiscal_id,
            'city_fiscal_id' => $city_fiscal_id,
            'municipality_fiscal' => $municipality_fiscal,
            'address_fiscal' => $address_fiscal,
            'postal_code_fiscal' => $postal_code_fiscal,
        ];

        $mercantil = [
            'type_cont' => $request['type_cont'],
            'tax' => $request->has('tax') ? $request['tax'] : null,
            'date_register' => $request['date_register'],
            'comercial_register' => $request['comercial_register'],
            'city_register' => $request['city_register'],
            'number_register' => $request['number_register'],
            'took_register' => $request['took_register'],
            'clause_register' => $request['clause_register'],
        ];

        $bank = [
            'bank_id' => $request['bank_id'],
            'bank_code' => $request['bank_code'],
            'account_bank' => $request['account_bank'],
            'affiliate_number' => $request['affiliate_number'],
        ];

        $contract = [
            'modelterminal_id' => $request['modelterminal_id'],
            'operator_id' => $request['operator_id'],
            'term_id' => $request['term_id'],
        ];

        if ($request->has('amountm')) {
            $amount = str_replace(',', '', $request['amountm']);
        } else {
            $amount = str_replace(',', '', $request['amount']);
        }

        $dicom = str_replace(',', '', $request['dicom']);

        if ($dicom == 0) {
            $dicom = 1;
        }

        $payment = [
            'pmethod_id' => $request['pmethod_id'],
            'currency_id' => $request['currency_id'],
            'currency' => $request['currency'],
            'dicom' => $dicom,
            'amount' => $amount,
            'amount_exchange' => ((int) $amount + (int) $dicom),
            'refere' => $request['refere'],
        ];

        $data_customer = serialize(array_merge($customer, $fiscal));
        $data_mercantil = serialize($mercantil);
        $data_bank = serialize($bank);
        $data_contract = serialize($contract);
        $data_payment = serialize($payment);

        $array = [
            'data_customer' => $data_customer,
            'data_mercantil' => $data_mercantil,
            'data_bank' => $data_bank,
            'data_contract' => $data_contract,
            'data_payment' => $data_payment,
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($array);

        if ($result) {
            return true;
        }

        return false;
    }

    /*************************Eliminar Preafiliación**************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                $data = $this->model->whereIn('preafiliations.status', ['Cargado'])->get();
                event(new PreafiliationEvent($data->count()));

                return true;
                dd();
            }
        }

        return false;
    }

    /************************Datatable Preafiliación**************************/
    public function datatable($request)
    {
        $data = $this->arrayData(null, $request['status']);
        ini_set('memory_limit', '1024M');

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>
                      <button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                      </button><div class="dropdown-menu" x-placement="bottom-start">';

                $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '"  OnClick="preafiliationsView(this);" data-target="#preafiliationsView" title="Ver Detalle Información">Ver Detalle Información</button>';

                if (auth()->user()->can('preafiliations.create')) {
                    if ($data['status'] == 'Cargado') {
                        if ($data['observations'] != null && $data['observations_sale'] == null) {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '" OnClick="preafiliationsSupport(this);" data-target="#preafiliationsSupportSale" title="Respuesta Solicitud de Ajustes de Documentos">Responder Solicitud</button>';
                        }

                        if ($data['document_rif'] == null || $data['observations'] != null && $data['observations_sale'] == null) {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . (int) $data['id'] . '"  OnClick="preafiliations(this);" data-target="#uploadRif" title="Actualizar Documento RIF">Documento RIF</button>';
                        }
                        if ($data['document_mercantil'] == null || $data['observations'] != null && $data['observations_sale'] == null) {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . (int) $data['id'] . '"  OnClick="preafiliations(this);" data-target="#uploadMercantil" title="Actualizar Registro Mercantíl">Registro Mercantíl</button>';
                        }
                        if ($data['document_bank'] == null || $data['observations'] != null && $data['observations_sale'] == null) {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . (int) $data['id'] . '"  OnClick="preafiliations(this);" data-target="#uploadBank" title="Actualizar Certificado Bancario">Certificado Bancario</button>';
                        }
                        if ($data['autorization_bank'] == null || $data['observations'] != null && $data['observations_sale'] == null) {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . (int) $data['id'] . '"  OnClick="preafiliations(this);" data-target="#uploadAuthBank" title="Actualizar Autorización Débito">Autorización Débito</button>';
                        }
                        if ($data['document_payment'] == null || $data['observations'] != null && $data['observations_sale'] == null) {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . (int) $data['id'] . '"  OnClick="preafiliations(this);" data-target="#uploadPayment" title="Actualizar Soporte Pago">Soporte Pago</button>';
                        }
                        if ($data['document_count'] == false || $data['observations'] != null && $data['observations_sale'] == null) {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . (int) $data['id'] . '"  OnClick="Rcustomer(this);" data-target="#detailsRcustomer" title="Actualizar Representante Legal">Representante Legal</button>';
                        }
                    }
                }
                $actions .= '</center>';

                return $actions;
            })->addColumn('documents', function ($data) {
                $documents = '<p></p>';
                if ($data['document_rif'] != null) {
                    $documents .= '<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['document_rif'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento RIF" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Documento Rif*';
                }
                if ($data['document_mercantil'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['document_mercantil'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Última Actualización Registro Mercantíl" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Registro Mercantíl*';
                }
                if ($data['document_bank'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['document_bank'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Soporte Cuenta Bancaria" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Soporte Cuenta Bancaria*';
                }
                if ($data['autorization_bank'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['autorization_bank'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Autorización Débito Bancario" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Autorización Débito Bancario*';
                }
                if ($data['document_payment'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-info" type="button" data-toggle="modal" value="' . $data['document_payment'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Soporte de Pago" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Soporte Pago*';
                }

                return $documents;
            })->rawColumns(['actions', 'documents', 'status_preafiliation'])
            ->toJson();
    }

    /*************************************************************************/
    public function validDatatable($request)
    {
        ini_set('memory_limit', '1024M');
        $data = $this->arrayData(null, $request['status']);

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $modal = 'preafiliations';
                $actions = '<center><button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                              </button><div class="dropdown-menu" x-placement="bottom-start">';
                $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '"  OnClick="' . $modal . 'View(this);" data-target="#' . $modal . 'View" title="Ver Detalle Información">Ver Detalle Información</button>';
                $actions .= '<a class="dropdown-item" href="' . route('preafiliations.edit', (int) $data['id']) . '" title="Ver Detalle Información">Actualizar Información</a>';

                if ($data['observations'] == null) {
                    $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '" OnClick="' . $modal . 'Support(this);" data-target="#' . $modal . 'Support" title="Solicitud de Ajustes de Documentos">Solicitar Ajustes</button>';
                }

                if ($data['status'] != 'Procesado') {
                    $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '"  OnClick="' . $modal . '(this);" data-target="#' . $modal . 'Update" title="Validar Información">Validar Información</button>';
                }
                $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . $data['id'] . '"  OnClick="' . $modal . '(this);" data-target="#' . $modal . 'Delete" title="Anular Pre-Afiliación">Anular Pre-Afiliación</button></center>';
                $actions .= '</div>';

                return $actions;
            })
            ->addColumn('is_rif', function ($data) {
                if ($data['is_rif'] != '') {
                    $is_rif = '<center>Si</center>';
                } else {
                    $is_rif = '<center>---</center>';
                }

                return $is_rif;
            })
            ->addColumn('is_bank', function ($data) {
                if ($data['is_bank'] != '') {
                    $is_bank = '<center>Si</center>';
                } else {
                    $is_bank = '<center>---</center>';
                }

                return $is_bank;
            })
            ->addColumn('is_auth_bank', function ($data) {
                if ($data['is_auth_bank'] != '') {
                    $is_auth_bank = '<center>Si</center>';
                } else {
                    $is_auth_bank = '<center>---</center>';
                }

                return $is_auth_bank;
            })
            ->addColumn('is_mercantil', function ($data) {
                if ($data['is_mercantil'] != '') {
                    $is_mercantil = '<center>Si</center>';
                } else {
                    $is_mercantil = '<center>---</center>';
                }

                return $is_mercantil;
            })
            ->addColumn('documents', function ($data) {
                $documents = '';
                if ($data['document_rif'] != null) {
                    $documents .= '<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['document_rif'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento RIF" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Documento Rif*';
                }
                if ($data['document_mercantil'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['document_mercantil'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Última Actualización Registro Mercantíl" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Registro Mercantíl*';
                }
                if ($data['document_bank'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['document_bank'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Soporte Cuenta Bancaria" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Soporte Cuenta Bancaria*';
                }
                if ($data['autorization_bank'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value="' . $data['autorization_bank'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Autorización Débito Bancario" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Autorización Débito Bancario*';
                }
                if ($data['document_payment'] != null) {
                    $documents .= '&nbsp;|&nbsp;<button class="btn btn-sm btn-info" type="button" data-toggle="modal" value="' . $data['document_payment'] . '|preafiliations|' . $data['rif'] . '" onclick="CustomerDocument(this)" title="Documento Soporte de Pago" class="view-document"><i class="i-File-Cloud"></i></button>&nbsp;Soporte Pago*';
                }

                return $documents;
            })->rawColumns(['is_rif', 'is_auth_bank', 'is_mercantil', 'actions', 'documents', 'status_preafiliation'])
            ->toJson();
    }

    /*************************************************************************/
    private function arrayData($id, $status)
    {
        $data = [];
        $cont = 0;

        $model = $this->model->query();

        $model->select(
            'preafiliations.id',
            'preafiliations.company_id',
            'preafiliations.rif',
            'preafiliations.is_customer',
            'preafiliations.data_customer',
            'preafiliations.document_rif',
            'preafiliations.is_rif',
            'preafiliations.data_rcustomer',
            'preafiliations.data_mercantil',
            'preafiliations.document_mercantil',
            'preafiliations.is_mercantil',
            'preafiliations.data_bank',
            'preafiliations.document_bank',
            'preafiliations.is_bank',
            'preafiliations.autorization_bank',
            'preafiliations.is_auth_bank',
            'preafiliations.data_contract',
            'preafiliations.data_payment',
            'preafiliations.document_payment',
            'preafiliations.is_payment',
            'preafiliations.observation_initial',
            'preafiliations.observations',
            'preafiliations.observations_sale',
            'preafiliations.status',
            'preafiliations.status as status_preafiliation',
            'preafiliations.created_at',
            'preafiliations.user_created_id',
            'preafiliations.user_updated_id',
            'preafiliations.user_deleted_id',
            \DB::raw("CONCAT(users.name,' ',users.last_name) AS user_created"),
            \DB::raw("(CASE WHEN (consultant_id IS NULL) THEN '----' ELSE CONCAT(consultants.first_name,' ',consultants.last_name) END) AS consultant")
        )
            ->leftjoin('users', function ($join) {
                $join->on('users.id', '=', 'preafiliations.user_created_id');
            })
            ->leftjoin('consultants', function ($join) {
                $join->on('consultants.id', '=', 'preafiliations.consultant_id');
            })->get();

        if ($id != null) {
            $model->where('preafiliations.id', $id);
        }

        if ($status != null) {
            $model->where('preafiliations.status', 'LIKE', $status);
        }

        if (Auth::user()->company_id != null) {
            $model->where('preafiliations.company_id', 'LIKE', Auth::user()->company_id);
        }

        if (!auth()->user()->can('preafiliations.edit')) {
            $model->where('preafiliations.user_created_id', Auth::user()->id);
        }

        $array = $model->get();

        foreach ($array as $row) {
            $data[$cont]['id'] = str_pad($row['id'], 7, '0', STR_PAD_LEFT);
            $data[$cont]['created'] = date_format($row['created_at'], 'Y-m-d H:i:s');
            $data[$cont]['status'] = $row['status'];
            $data[$cont]['status_preafiliation'] = $row['status_preafiliation'];
            $data[$cont]['rif'] = $row['rif'];
            $data[$cont]['observations'] = $row['observations'];
            $data[$cont]['observations_sale'] = $row['observations_sale'];
            $data[$cont]['is_rif'] = $row['is_rif'];
            $data[$cont]['is_mercantil'] = $row['is_mercantil'];
            $data[$cont]['is_bank'] = $row['is_bank'];
            $data[$cont]['is_auth_bank'] = $row['is_auth_bank'];
            $data[$cont]['is_payment'] = $row['is_payment'];
            $data[$cont]['user_created'] = $row['user_created'];
            $data[$cont]['consultant'] = $row['consultant'];

            $customer = unserialize($row['data_customer']);

            $data[$cont]['business_name'] = $customer['business_name'];
            $data[$cont]['email'] = $customer['email'];
            if ($customer['telephone'] != null) {
                $data[$cont]['telephone'] = $customer['telephone'];
            } else {
                $data[$cont]['telephone'] = '---';
            }
            $data[$cont]['mobile'] = $customer['mobile'];
            $data[$cont]['mobile2'] = $customer['mobile2'];

            $company = $this->company->select('description')->where('id', '=', $row['company_id'])->first();
            if (isset($company)) {
                $data[$cont]['company'] = $company['description'];
                $data[$cont]['company_id'] = $row['company_id'];
            } else {
                $data[$cont]['company'] = '';
                $data[$cont]['company_id'] = '';
            }
            $cactivity = $this->cactivity->model->select('description')->where('id', '=', $customer['cactivity_id'])->first();
            if (isset($cactivity)) {
                $data[$cont]['cactivity'] = $cactivity['description'];
                $data[$cont]['cactivity_id'] = $customer['cactivity_id'];
            } else {
                $data[$cont]['cactivity'] = '';
                $data[$cont]['cactivity_id'] = '';
            }
            $rcustomer = unserialize($row['data_rcustomer']);
            $ident_number = unserialize($rcustomer['ident_number']);
            $fullname = unserialize($rcustomer['fullname']);
            $jobtitle = unserialize($rcustomer['jobtitle']);
            $email = unserialize($rcustomer['email']);
            $mobile = unserialize($rcustomer['mobile']);

            if (array_key_exists('path_document', $rcustomer)) {
                if (count(unserialize($rcustomer['path_document'])) > 0) {
                    $data[$cont]['document_rm'] = unserialize($rcustomer['path_document']);
                    $path_document = true;
                } else {
                    $data[$cont]['document_rm'] = false;
                    $path_document = false;
                }
            } else {
                $path_document = false;
                $data[$cont]['document_rm'] = false;
            }

            $rows = [];
            for ($i = 0; $i < count($ident_number); $i++) {
                $rows[$i]['ident_number_r'] = $ident_number;
                $rows[$i]['fullname_r'] = $fullname;
                $rows[$i]['jobtitle_r'] = $jobtitle;
                $rows[$i]['email_r'] = $email;
                $rows[$i]['mobile_r'] = $mobile;
            }
            $data[$cont]['document_count'] = $path_document;

            $data[$cont]['ident_number_r'] = $ident_number;
            $data[$cont]['fullname_r'] = $fullname;
            $data[$cont]['jobtitle_r'] = $jobtitle;
            $data[$cont]['email_r'] = $email;
            $data[$cont]['mobile_r'] = $mobile;

            $data[$cont]['ident_number_r'] = $ident_number;
            $data[$cont]['fullname_r'] = $fullname;
            $data[$cont]['jobtitle_r'] = $jobtitle;
            $data[$cont]['email_r'] = $email;
            $data[$cont]['mobile_r'] = $mobile;

            if (isset($path_document)) {
                $data[$cont]['path_document'] = false;
            } else {
                $data[$cont]['path_document'] = true;
            }

            $state = State::select('description')->where('id', $customer['state_id'])->first();
            $data[$cont]['state'] = $state['description'];
            $data[$cont]['state_id'] = $customer['state_id'];

            if (array_key_exists('city_id', $customer) && $customer['city_id'] != null) {
                $city = City::select('description')->where('id', $customer['city_id'])->first();

                $data[$cont]['city'] = $city['description'];
                $data[$cont]['city_id'] = $customer['city_id'];
            } else {
                $data[$cont]['city'] = '----';
                $data[$cont]['city_id'] = null;
            }
            $data[$cont]['municipality'] = $customer['municipality'];
            $data[$cont]['address'] = $customer['address'];
            $data[$cont]['postal_code'] = $customer['postal_code'];

            if (array_key_exists('state_fiscal_id', $customer) && $customer['state_fiscal_id'] != null) {
                $state_fiscal = State::select('description')->where('id', $customer['state_fiscal_id'])->first();

                $data[$cont]['state_fiscal'] = $state_fiscal['description'];
                $data[$cont]['state_fiscal_id'] = $customer['state_fiscal_id'];
            } else {
                $data[$cont]['state_fiscal'] = '';
                $data[$cont]['state_fiscal_id'] = '';
            }
            if (array_key_exists('city_fiscal_id', $customer) && $customer['city_fiscal_id'] != null) {
                $city = City::select('description')->where('id', $customer['city_fiscal_id'])->first();
                $data[$cont]['city_fiscal'] = $city['description'];
                $data[$cont]['city_fiscal_id'] = $customer['city_fiscal_id'];
            } else {
                $data[$cont]['city_fiscal'] = '----';
                $data[$cont]['city_fiscal_id'] = null;
            }

            $data[$cont]['municipality_fiscal'] = $customer['municipality_fiscal'];
            $data[$cont]['address_fiscal'] = $customer['address_fiscal'];
            $data[$cont]['postal_code_fiscal'] = $customer['postal_code_fiscal'];

            $bank = unserialize($row['data_bank']);
            $data[$cont]['affiliate_number'] = $bank['affiliate_number'];
            $data[$cont]['account_bank'] = $bank['bank_code'] . $bank['account_bank'];
            $data[$cont]['bank_id'] = $bank['bank_id'];
            $data[$cont]['bank_code'] = $bank['bank_code'];
            $data[$cont]['account_bank'] = $bank['account_bank'];

            $bank = $this->bank->model->select('description')->where('id', $bank['bank_id'])->first();
            $data[$cont]['bank'] = $bank['description'];

            $mercantil = unserialize($row['data_mercantil']);
            $data[$cont]['type_cont'] = $mercantil['type_cont'];
            if ($mercantil['type_cont'] == 1) {
                $data[$cont]['type_cont_desc'] = 'Ordinario';
            } else {
                $data[$cont]['type_cont_desc'] = 'Especial';
            }
            $data[$cont]['tax'] = $mercantil['tax'];
            if (isset($mercantil['date_register'])) {
                $data[$cont]['date_register'] = $mercantil['date_register'];
            } else {
                $data[$cont]['date_register'] = '';
            }
            if (isset($mercantil['comercial_register'])) {
                $data[$cont]['comercial_register'] = $mercantil['comercial_register'];
            } else {
                $data[$cont]['comercial_register'] = '';
            }
            if (isset($mercantil['city_register'])) {
                $data[$cont]['city_register'] = $mercantil['city_register'];
            } else {
                $data[$cont]['city_register'] = '';
            }
            if (isset($mercantil['number_register'])) {
                $data[$cont]['number_register'] = $mercantil['number_register'];
            } else {
                $data[$cont]['number_register'] = '';
            }
            if (isset($mercantil['took_register'])) {
                $data[$cont]['took_register'] = $mercantil['took_register'];
            } else {
                $data[$cont]['took_register'] = '';
            }
            if (isset($mercantil['clause_register'])) {
                $data[$cont]['clause_register'] = $mercantil['clause_register'];
            } else {
                $data[$cont]['clause_register'] = '';
            }

            $contract = unserialize($row['data_contract']);
            $modelterminal = $this->modelterminal->model->select('description')->where('id', $contract['modelterminal_id'])->first();
            $data[$cont]['modelterminal'] = $modelterminal['description'];
            $data[$cont]['modelterminal_id'] = $contract['modelterminal_id'];

            $operator = $this->operator->model->select('description')->where('id', $contract['operator_id'])->first();
            $data[$cont]['operator'] = $operator['description'];
            $data[$cont]['operator_id'] = $contract['operator_id'];

            $term = $this->term->model->select('description', 'observations')->where('id', $contract['term_id'])->first();
            $data[$cont]['term'] = $term['description'] . ' - ' . $term['observations'];
            $data[$cont]['term_id'] = $contract['term_id'];

            $data[$cont]['document_rif'] = $row['document_rif'];
            $data[$cont]['document_mercantil'] = $row['document_mercantil'];
            $data[$cont]['document_bank'] = $row['document_bank'];
            $data[$cont]['autorization_bank'] = $row['autorization_bank'];
            $data[$cont]['document_payment'] = $row['document_payment'];
            $data[$cont]['observation_initial'] = $row['observation_initial'];

            $payment = unserialize($row['data_payment']);

            $format = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);

            if ($payment['pmethod_id'] != null) {
                $pmethod = $this->pmethod->model->select('description')->where('id', $payment['pmethod_id'])->first();
                $data[$cont]['pmethod'] = $pmethod['description'];
            } else {
                $data[$cont]['pmethod'] = '----';
            }
            $data[$cont]['pmethod_id'] = $payment['pmethod_id'];

            if ($payment['refere'] != null) {
                $data[$cont]['refere'] = $payment['refere'];
            } else {
                $data[$cont]['refere'] = '----';
            }

            $data[$cont]['dicom'] = $format->format($payment['dicom']);

            $currency = $this->currency->model->select('abrev')->where('id', $payment['currency_id'])->first();
            $data[$cont]['currency'] = $currency['abrev'];
            if (isset($payment['currency_id'])) {
                $data[$cont]['currency_id'] = $payment['currency_id'];
            } else {
                $data[$cont]['currency_id'] = null;
            }
            $data[$cont]['amount'] = $format->format($payment['amount']);
            $data[$cont]['amount_exchange'] = $format->format($payment['amount_exchange']);

            $cont++;
        }

        return Collect($data);
    }

    /****************Ver en archivo PDF Información Cliente*******************/
    public function documentPdf($request)
    {
        $path = storage_path($request['path']) . '/' . $request['rif'] . '/' . $request['uri'];

        return \Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $request['path'] . '/' . $request['uri'] . '.pdf"',
        ]);
    }

    /*************************************************************************/
    public function rcustomerDetail($request)
    {
        $data = [];

        $model = $this->model->query();
        $preafiliation = $model->where('preafiliations.id', '=', $request['preafiliation_id'])->first();
        if (isset($preafiliation)) {
            $array = unserialize($preafiliation['data_rcustomer']);
            $ident_number = unserialize($array['ident_number']);
            $fullname = unserialize($array['fullname']);
            $jobtitle = unserialize($array['jobtitle']);
            $email = unserialize($array['email']);
            $mobile = unserialize($array['mobile']);

            if (array_key_exists('path_document', $array)) {
                $path_document = unserialize($array['path_document']);
            } else {
                $path_document = [];
            }
            for ($i = 0; $i < count($ident_number); $i++) {
                if (count($path_document) > 0) {
                    $data[$i] = [
                        'ident_number' => $ident_number[$i],
                        'fullname' => $fullname[$i],
                        'jobtitle' => $jobtitle[$i],
                        'email' => $email[$i],
                        'mobile' => $mobile[$i],
                        'path_document' => $path_document[$i],
                    ];
                } else {
                    $data[$i] = [
                        'ident_number' => $ident_number[$i],
                        'fullname' => $fullname[$i],
                        'jobtitle' => $jobtitle[$i],
                        'email' => $email[$i],
                        'mobile' => $mobile[$i],
                    ];
                }
            }

            return $data;
        }

        return false;
    }

    /*************************************************************************/
    public function remove($request)
    {
        $rif = explode('_', $request['path']);
        //indicamos que queremos guardar un nuevo archivo en el disco local
        if (file_exists(storage_path() . '/temporal/' . $rif[0] . '/' . $request['path'])) {
            $result = Storage::disk('temporal')->delete($rif[0] . '/' . $request['path']);
        }

        return  $result;
    }

    /*************************************************************************/
    public function tempUpload($request)
    {
        $path = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // generar un nombre con la extension
            $path = $request['rif'] . '_' . $request['type_document'] . '.' . $file->getClientOriginalExtension();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path() . '/temporal/' . $request['rif'] . '/' . $path)) {
                $result = Storage::disk('temporal')->delete($request['rif'] . '/' . $path);
            }
            $result = Storage::disk('temporal')->put($request['rif'] . '/' . $path, \File::get($file));
        }

        return $path;
    }

    /*************************************************************************/
    public function upload($request)
    {
        $preafiliation = $this->model->where('id', '=', $request['preafiliation_id'])->first();

        if (isset($request['consec'])) {
            $type_document = $request['type_document'] . '_' . $request['consec'];
        } else {
            $type_document = $request['type_document'];
        }
        if (isset($preafiliation)) {
            $path = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // generar un nombre con la extension
                $path = $preafiliation['rif'] . '_' . $type_document . '.' . $file->getClientOriginalExtension();
                //indicamos que queremos guardar un nuevo archivo en el disco local
                if (file_exists(storage_path() . '/preafiliations/' . $preafiliation['rif'] . '/' . $path)) {
                    $result = Storage::disk('preafiliations')->delete($preafiliation['rif'] . '/' . $path);
                }
                $result = Storage::disk('preafiliations')->put($preafiliation['rif'] . '/' . $path, \File::get($file));
            }
        }

        switch ($request['type_document']) {
            case 'rif':
                $preafiliation->document_rif = $path;
                break;
            case 'rm':
                $preafiliation->document_mercantil = $path;
                break;
            case 'bank':
                $preafiliation->document_bank = $path;
                break;
            case 'auth-bank':
                $preafiliation->autorization_bank = $path;
                break;
            case 'payment':
                $preafiliation->document_payment = $path;
                break;
            case 'rcustomer':
                $rcustomer = unserialize($preafiliation->data_rcustomer);
                $ident_number = unserialize($rcustomer['ident_number']);

                if (array_key_exists('path_document', $rcustomer)) {
                    $path_document = unserialize($rcustomer['path_document']);
                } else {
                    $path_document = [];
                }
                $document = [];
                for ($i = 0; $i < count($ident_number); $i++) {
                    if (count($path_document) > 0) {
                        if ($request['consec'] == $ident_number[$i]) {
                            $document[$i] = $path;
                        } else {
                            $document[$i] = $path_document[$i];
                        }
                    } else {
                        $document[$i] = $path;
                    }
                    $array = [
                        'ident_number' => $rcustomer['ident_number'],
                        'fullname' => $rcustomer['fullname'],
                        'jobtitle' => $rcustomer['jobtitle'],
                        'email' => $rcustomer['email'],
                        'mobile' => $rcustomer['mobile'],
                    ];

                    if (count($document) > 0) {
                        $array1 = [
                            'path_document' => serialize($document),
                        ];
                        $preafiliation->data_rcustomer = serialize(array_merge($array, $array1));
                    } else {
                        $preafiliation->data_rcustomer = serialize($array);
                    }
                }
                break;
            default:
                return false;
                break;
        }
        $result = $preafiliation->save();

        if ($result) {
            return true;
        }

        return false;
    }

    /**************************************************************************/
    public function totalAvailable($request)
    {
        $cont = 0;

        if ($request->has('modelterminal_id')) {
            $model = $this->model->query();

            $model->select('preafiliations.data_contract');

            if ($request->has('company_id')) {
                $model->where('preafiliations.company_id', $request['company_id']);
            } else {
                if (Auth::user()->company_id != null) {
                    $model->where('preafiliations.company_id', Auth::user()->company_id);
                } else {
                    $model->where('preafiliations.company_id', 1);
                }
            }
            $array = $model->where('preafiliations.status', 'LIKE', 'Cargado')->get();

            if (count($array) > 0) {
                foreach ($array as $row) {
                    $contract = unserialize($row['data_contract']);
                    if ($contract['modelterminal_id'] == $request['modelterminal_id']) {
                        $cont++;
                    }
                }
                if ($request->has('total_terminal') && $request['total_terminal'] > 0) {
                    $cont = $request['total_terminal'] - $cont;
                }
            } else {
                $cont = $request['total_terminal'];
            }
        }

        return \Response::json($cont);
    }

    /*************************************************************************/
    public function getTotal()
    {
        $data = $this->model->where('preafiliations.status', 'Cargado')->get();

        return $data->count();
    }

    /*************************************************************************/
    public function support($request, $id)
    {
        $model = $this->model->findOrfail($id);
        if ($request['user_observation'] == 'assistant') {
            $model->observations = $request['observations'];
        } elseif ($request['user_observation'] == 'sales') {
            $model->observations_sale = $request['observations'];
        }
        $model->user_updated_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    public function report($request)
    {
        ini_set('memory_limit', '1024M');

        return Excel::download(new PreafiliationReportExport($request), 'Reporte PreAfiliados ' . date('Y-m-d') . '.xlsx');
    }
}
