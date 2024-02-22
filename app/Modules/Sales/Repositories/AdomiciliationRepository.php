<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Models\Adomiciliation;
use App\Modules\Sales\Models\Contract;
use App\Modules\Sales\Models\Raffiliate;
use App\Modules\Sales\Repositories\Affiliate\Response\AffiliateResponseFactory;
use Auth;
use Storage;

class AdomiciliationRepository implements AdomiciliationInterface
{
    protected $adomiciliation;

    public function __construct(Adomiciliation $adomiciliation)
    {
        $this->model = $adomiciliation;
    }

    /************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'bank_id' => $request['bank_id'],
            'file_bank' => $request['file_bank'],
            'data' => $request['data'],
            'status' => $request['status'],
            'user_created_id' => Auth::user()->id,
        ]);

        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    public function find($id)
    {
        $adomiciliation = $this->model->select('adomiciliations.data', 'banks.description as bank_name')->join('banks', 'banks.id', '=', 'adomiciliations.bank_id')->where('adomiciliations.id', $id)->first();
        if (isset($adomiciliation)) {
            $array = unserialize($adomiciliation->data);
            $data = [
                'total_register' => $array['total_register'],
                'bank_name' => $adomiciliation->bank_name,
            ];

            return \Response::json($data);
        }

        return false;
    }

    /************************************************************************/
    public function update($request, $id)
    {
        $data = [
            'description' => $request['description'],
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    public function delete($id)
    {
        $model = $this->model->where('adomiciliations.id', $id)->whereIn('adomiciliations.status', ['Generado', 'Cargado', 'Enviado'])->first();
        if (isset($model)) {
            $model->status = 'Anulado';
            $model->user_deleted_id = Auth::user()->id;
            $result = $model->update();

            if ($result) {
                return true;
            }
        }

        return false;
    }

    /************************************************************************/
    public function datatable($request)
    {
        $model = $this->model->select(
            'adomiciliations.id',
            \DB::raw("DATE_FORMAT(adomiciliations.created_at, '%Y-%m-%d %H:%i:%s') as created"),
            'banks.id as bank_id',
            'banks.description as bank_name',
            \DB::raw('(CASE WHEN (adomiciliations.file_bank IS NOT NULL) THEN 1 ELSE 0 END) AS file_bank'),
            \DB::raw('(CASE WHEN (adomiciliations.file_response_bank IS NOT NULL) THEN 1 ELSE 0 END) AS file_response'),
            \DB::raw("(CASE WHEN (adomiciliations.send_email IS NOT NULL) THEN 'Si' ELSE '----' END) AS send_email"),
            'adomiciliations.status',
            'adomiciliations.status as status_button',
            \DB::raw("(CASE WHEN(adomiciliations.user_created_id IS NOT NULL) THEN CONCAT(usersc.name,' ',usersc.last_name) ELSE '---' END) AS created_name"),
            \DB::raw("(CASE WHEN(adomiciliations.user_upload_id IS NOT NULL) THEN CONCAT(usersu.name,' ',usersu.last_name) ELSE '---' END) AS upload_name"),
            \DB::raw("(CASE WHEN(adomiciliations.user_process_id IS NOT NULL) THEN CONCAT(usersp.name,' ',usersp.last_name) ELSE '---' END) AS process_name"),
            \DB::raw("(CASE WHEN(adomiciliations.user_send_id IS NOT NULL) THEN CONCAT(userss.name,' ',userss.last_name) ELSE '---' END) AS send_name"),
            \DB::raw("(CASE WHEN(adomiciliations.send_at IS NOT NULL) THEN DATE_FORMAT(adomiciliations.send_at, '%Y-%m-%d %H:%i:%s') ELSE '---' END) AS send_at"),
            \DB::raw("(CASE WHEN(adomiciliations.process_at IS NOT NULL) THEN DATE_FORMAT(adomiciliations.process_at, '%Y-%m-%d %H:%i:%s') ELSE '----' END) AS process_at"),
            \DB::raw("(CASE WHEN(adomiciliations.upload_at IS NOT NULL) THEN DATE_FORMAT(adomiciliations.upload_at, '%Y-%m-%d %H:%i:%s') ELSE '----' END) AS upload_at")
        )
            ->join('banks', 'banks.id', '=', 'adomiciliations.bank_id')
            ->leftjoin('users as usersc', 'usersc.id', '=', 'adomiciliations.user_created_id')
            ->leftjoin('users as usersu', 'usersu.id', '=', 'adomiciliations.user_upload_id')
            ->leftjoin('users as userss', 'userss.id', '=', 'adomiciliations.user_send_id')
            ->leftjoin('users as usersp', 'usersp.id', '=', 'adomiciliations.user_process_id');

        if ($request['status'] != 'Anulado' && $request['status'] != 'Procesado') {
            $model->whereIn('adomiciliations.status', ['Generado', 'Enviado', 'Cargado']);
        } else {
            $model->where('adomiciliations.status', 'LIKE', $request['status']);
        }

        $data = $model->get();

        return datatables()->of($data)
            ->editColumn('file_bank', function ($data) {
                return '<a class="btn btn-sm btn-danger" href="/adomiciliations/download/'.$data->id.'" title="Descargar Archivo Bancario"><i class="nav-icon i-File-Download"></i></a>&nbsp;';
            })
            ->editColumn('file_response', function ($data) {
                if ($data->file_response != null) {
                    return '<a  class="btn btn-sm btn-danger" href="/adomiciliations/download/response/'.$data->id.'" title="Descargar Archivo  Resultados Domiciliación"><i class="nav-icon i-File-Download"></i></a>';
                }

                return '---';
            })
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                $actions .= '<button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                           </button><div class="dropdown-menu" x-placement="bottom-start">';

                $actions .= '<button class="btn dropdown-item" data-toggle="modal"  value="'.$data->id.'"  OnClick="AdomiciliationView(this);" data-target="#viewAdomiciliation"  title="Información Gestión Afiliación Servicio">Información Gestión</button>';

                if ($data->status == 'Generado' || $data->status == 'Enviado' || $data->status == 'Cargado') {
                    if ($data->status == 'Generado') {
                        $actions .= '<button class="btn dropdown-item" data-toggle="modal" value="'.$data->id.'"  OnClick="AdomiciliationSend(this);" data-target="#sendAdomiciliation"  title="Envio Archivo Afiliación x Gestión Cobro Servicio">Envio Archivo</button>';
                    }

                    if ($data->status == 'Enviado' || $data->status == 'Cargado') {
                        if (auth()->user()->can('adomiciliations.edit')) {
                            $actions .= '<button class="btn dropdown-item" data-toggle="modal" value="'.$data->id.'"  OnClick="AdomiciliationUpload(this);" data-target="#uploadResponseAdomiciliation"  title="Cargar Resultado Gestión Afiliación Servicio Bancario">Cargar Resultados</button>';
                        }
                    }

                    if ($data->status == 'Cargado') {
                        $actions .= '<button  class="btn dropdown-item" data-toggle="modal" value="'.$data->id.'"  OnClick="AdomiciliationProcess(this);" data-target="#processAdomiciliation"  title="Procesar Resultados  Gestión Afiliación Servicio Bancario">Conciliar Resultado</button>';
                    }

                    if (auth()->user()->can('adomiciliations.destroy')) {
                        $actions .= '<button class="btn dropdown-item" data-toggle="modal" value="'.$data->id.'"  OnClick="AdomiciliationDestroy(this);" data-target="#deleteAdomiciliation"  title="Anular Gestión Afiliación Servicio Bancario">Anular</button>';
                    }
                }

                $actions .= '</div></center>';

                return $actions;
            })->rawColumns(['status_button', 'file_bank', 'file_response', 'actions'])
            ->toJson();
    }

    /************************************************************************/
    public function download($id)
    {
        $adomiciliation = $this->model->select('adomiciliations.file_bank')->where('adomiciliations.id', $id)->first();
        if (isset($adomiciliation)) {
            return response()->download(storage_path($adomiciliation->file_bank));
        }

        return false;
    }

    /************************************************************************/
    public function downloadResponse($id)
    {
        $adomiciliation = $this->model->select('adomiciliations.file_response_bank')->where('adomiciliations.id', $id)->first();
        if (isset($adomiciliation)) {
            return response()->download(storage_path($adomiciliation->file_response_bank));
        }

        return false;
    }

    /************************************************************************/
    public function send($id)
    {
        $adomiciliation = $this->model->where('adomiciliations.id', $id)->where('adomiciliations.status', 'LIKE', 'Generado')->first();
        if (isset($adomiciliation)) {
            $adomiciliation->status = 'Enviado';
            $adomiciliation->user_send_id = Auth::user()->id;
            $adomiciliation->send_at = now();
            $result = $adomiciliation->save();

            if (isset($result)) {
                return true;
            }
        }

        return false;
    }

    /************************************************************************/
    public function upload($request)
    {
        $adomiciliation = $this->model->select('adomiciliations.*', 'banks.bank_code')->join('banks', 'banks.id', '=', 'adomiciliations.bank_id')->where('adomiciliations.id', $request['upload_id'])->first();
        if (isset($adomiciliation)) {
            $file = $request->file('file');
            $path = $adomiciliation->bank_code.'/response/'.$file->getClientOriginalName();

            if (file_exists(storage_path().$path)) {
                $result = Storage::disk('affiliate')->delete($path);
            }

            $result = Storage::disk('affiliate')->put($path, \File::get($file));

            if (isset($result)) {
                $adomiciliation->file_response_bank = '/afiliacion/'.$path;
                $adomiciliation->status = 'Cargado';
                $adomiciliation->user_upload_id = Auth::user()->id;
                $adomiciliation->upload_at = now();
                $result = $adomiciliation->save();

                if (isset($result)) {
                    return true;
                }
            }
        }

        return false;
    }

    /************************************************************************/
    public function process($id)
    {
        $adomiciliation = $this->model->where('adomiciliations.id', $id)->where('adomiciliations.status', 'LIKE', 'Cargado')->first();

        if (isset($adomiciliation)) {
            $AffiliateResponseFactory = new AffiliateResponseFactory();
            $service = $AffiliateResponseFactory->initialize($adomiciliation);

            $data = $service->response($adomiciliation);

            if ($adomiciliation['bank_id'] == 4 || $adomiciliation['bank_id'] == 6) {
                // Delsur y Bancrecer
                foreach ($data as $key => $content) {
                    $contract = Contract::select('contracts.*', 'customers.rif', 'customers.business_name', \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"))
                        ->join('aconsecutives', 'aconsecutives.contract_id', '=', 'contracts.id')
                        ->join('customers', 'customers.id', '=', 'contracts.customer_id')
                        ->where('aconsecutives.refere', (int) $content['refere'])
                        ->where('aconsecutives.bank_id', (int) $content['bank_id'])
                        ->first();

                    if (isset($contract)) {
                        if ($content['response'] == '000') {
                            $contract->is_affiliate = 1;
                            $contract->affiliate_date = date_format(now(), 'Y-m-d');

                            $result = $contract->save();

                            $status = 'Afiliado';
                        } else {
                            $status = 'Procesado';
                        }
                        $contract_id = (int) $contract->id;
                        $dcustomer_id = (int) $contract->dcustomer_id;

                        $data = [
                            'fecha_procesado' => date_format(now(), 'Y-m-d'),
                            'rif' => $contract->rif,
                            'comercio' => $contract->business_name,
                            'contrato' => $contract->contract_id,
                            'respuesta' => $content['response'],
                            'mensaje' => $content['message'],
                        ];

                        $raffiliate = Raffiliate::create([
                            'fechpro' => date_format(now(), 'Y-m-d'),
                            'contract_id' => $contract_id,
                            'dcustomer_id' => $dcustomer_id,
                            'bank_id' => $content['bank_id'],
                            'data' => serialize($data),
                            'observation_response' => $content['response'] = '000' ? $content['response'].'-'.$content['message'] : 'Servicio Terminal Activo x Cobranza',
                            'status' => $status,
                            'user_created_id' => Auth::user()->id,
                        ]);
                    }
                }
            } elseif ($adomiciliation['bank_id'] == 9) {
                // Mercantil
                foreach ($data as $key => $content) {
                    $contract = Contract::select('contracts.*', 'customers.rif', 'customers.business_name', \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"))
                        ->join('customers', 'customers.id', '=', 'contracts.customer_id')
                        ->join('terminals', 'terminals.id', '=', 'contracts.terminal_id')
                        ->where('terminals.serial', $content['terminal'])
                        ->first();

                    if (isset($contract)) {
                        if ($content['response'] == '63') {
                            $contract->is_affiliate = 1;
                            $contract->affiliate_date = date_format(now(), 'Y-m-d');

                            $result = $contract->save();

                            $status = 'Afiliado';
                        } else {
                            $status = 'Procesado';
                        }
                        $contract_id = (int) $contract->id;
                        $dcustomer_id = (int) $contract->dcustomer_id;

                        $data = [
                            'fecha_procesado' => date_format(now(), 'Y-m-d'),
                            'rif' => $contract->rif,
                            'comercio' => $contract->business_name,
                            'contrato' => $contract->contract_id,
                            'respuesta' => $content['response'],
                            'mensaje' => $content['message'],
                        ];

                        $raffiliate = Raffiliate::create([
                            'fechpro' => date_format(now(), 'Y-m-d'),
                            'contract_id' => $contract_id,
                            'dcustomer_id' => $dcustomer_id,
                            'bank_id' => $content['bank_id'],
                            'data' => serialize($data),
                            'observation_response' => $content['response'] = '63' ? $content['response'].'-'.$content['message'] : 'Servicio Terminal Activo x Cobranza',
                            'status' => $status,
                            'user_created_id' => Auth::user()->id,
                        ]);
                    }
                }
            } else {
                // BFC
                foreach ($data as $key => $content) {
                    $contract = Contract::select('contracts.*', 'customers.rif', 'customers.business_name', \DB::raw("LPAD(contracts.id,6,'0') AS contract_id"))
                        ->join('customers', 'customers.id', '=', 'contracts.customer_id')
                        ->join('terminals', 'terminals.id', '=', 'contracts.terminal_id')
                        ->where('terminals.serial', $content['terminal'])
                        ->first();

                    if (isset($contract)) {
                        if ($content['response'] == '000') {
                            $contract->is_affiliate = 1;
                            $contract->affiliate_date = date_format(now(), 'Y-m-d');

                            $result = $contract->save();

                            $status = 'Afiliado';
                        } else {
                            $status = 'Procesado';
                        }
                        $contract_id = (int) $contract->id;
                        $dcustomer_id = (int) $contract->dcustomer_id;

                        $data = [
                            'fecha_procesado' => date_format(now(), 'Y-m-d'),
                            'rif' => $contract->rif,
                            'comercio' => $contract->business_name,
                            'contrato' => $contract->contract_id,
                            'respuesta' => $content['response'],
                            'mensaje' => $content['message'],
                        ];

                        $raffiliate = Raffiliate::create([
                            'fechpro' => date_format(now(), 'Y-m-d'),
                            'contract_id' => $contract_id,
                            'dcustomer_id' => $dcustomer_id,
                            'bank_id' => $content['bank_id'],
                            'data' => serialize($data),
                            'observation_response' => $content['response'] = '000' ? $content['response'].'-'.$content['message'] : 'Servicio Terminal Activo x Cobranza',
                            'status' => $status,
                            'user_created_id' => Auth::user()->id,
                        ]);
                    }
                }
            }

            //TODO Generar una Cola de trabajo y tener una barra de estado para visualizar el status proceso
            $adomiciliation->status = 'Procesado';
            $adomiciliation->user_process_id = Auth::user()->id;
            $adomiciliation->process_at = now();
            $result = $adomiciliation->save();

            if (isset($result)) {
                return true;
            }
        }

        return false;
    }
}
