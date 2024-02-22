<?php

namespace App\Modules\Sales\Repositories;

use App\Mail\DoCoFinished;
use App\Mail\DoCoStarted;
use App\Modules\Sales\Jobs\DomiciliationCollectionBank;
use App\Modules\Sales\Models\Domiciliation;
use App\Modules\Sales\Repositories\ConciliationService\ConciliationServiceFactory;
use App\Modules\Users\Models\User;
use Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Storage;

class DomiciliationRepository implements DomiciliationInterface
{
    protected $domiciliation;

    public function __construct(Domiciliation $domiciliation)
    {
        $this->model = $domiciliation;
    }

    /************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'bank_id' => $request['bank_id'],
            'amount_currency_old' => $request['amount_currency_old'],
            'amount_currency' => $request['amount_currency'],
            'type_management' => $this->typeManagement($request['type_management']),
            'date_ini' => $request['date_ini'] != '' ? $request['date_ini'] : null,
            'date_end' => $request['date_end'] != '' ? $request['date_end'] : null,
            'date_operation' => $request['date_operation'] != '' ? $request['date_operation'] : now(),
            'file_bank' => $request['file_bank'],
            'data' => $request['data_domiciliation'],
            'status' => $request['status'],
            'user_created_id' => Auth::user()->id,
        ]);

        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    protected function typeManagement($type_management)
    {
        if ($type_management == 'G') {
            return 'Diario';
        } elseif ($type_management == 'R') {
            return 'Morosidad';
        }

        return 'Masivo';
    }

    /************************************************************************/
    public function find($id)
    {
        $domiciliation = $this->model->select('domiciliations.data', \DB::raw('FORMAT(domiciliations.amount_currency_old,2) as amount_currency_old'))->where('domiciliations.id', $id)->first();
        if (isset($domiciliation)) {
            $array = unserialize($domiciliation->data);
            $data = [
                'total_amount' => $array['total_amount'],
                'total_amount_currency' => $array['total_amount_currency'],
                'total_register' => $array['total_register'],
                'amount_currency' => number_format(str_replace(',', '', $domiciliation->amount_currency_old), 2, ',', '.'),
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
        $model = $this->model->where('domiciliations.id', $id)->whereIn('domiciliations.status', ['Generado', 'Cargado', 'Enviado'])->first();
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
            'domiciliations.id',
            \DB::raw("DATE_FORMAT(domiciliations.created_at, '%Y-%m-%d %H:%i:%s') as created"),
            'banks.id as bank_id',
            'banks.description as bank_name',
            'type_management',
            \DB::raw("(CASE WHEN(domiciliations.date_ini IS NOT NULL) THEN DATE_FORMAT(domiciliations.date_ini, '%Y-%m-%d') ELSE '----' END) AS date_ini"),
            \DB::raw("(CASE WHEN(domiciliations.date_end IS NOT NULL) THEN DATE_FORMAT(domiciliations.date_end, '%Y-%m-%d') ELSE '----' END) AS date_end"),
            \DB::raw("(CASE WHEN(domiciliations.date_operation IS NOT NULL) THEN DATE_FORMAT(domiciliations.date_operation, '%Y-%m-%d') ELSE '----' END) AS date_operation"),
            \DB::raw('FORMAT(domiciliations.amount_currency,2) as amount_currency'),
            \DB::raw('FORMAT(domiciliations.amount_currency_old,2) as amount_currency_old'),
            \DB::raw('(CASE WHEN (domiciliations.file_bank IS NOT NULL) THEN 1 ELSE 0 END) AS file_bank'),
            \DB::raw('(CASE WHEN (domiciliations.file_response_bank IS NOT NULL) THEN 1 ELSE 0 END) AS file_response'),
            \DB::raw("(CASE WHEN (domiciliations.send_email IS NOT NULL) THEN 'Si' ELSE '----' END) AS send_email"),
            'domiciliations.status',
            'domiciliations.status as status_button',
            \DB::raw("(CASE WHEN(domiciliations.user_created_id IS NOT NULL) THEN CONCAT(usersc.name,' ',usersc.last_name) ELSE '---' END) AS created_name"),
            \DB::raw("(CASE WHEN(domiciliations.user_upload_id IS NOT NULL) THEN CONCAT(usersu.name,' ',usersu.last_name) ELSE '---' END) AS upload_name"),
            \DB::raw("(CASE WHEN(domiciliations.user_process_id IS NOT NULL) THEN CONCAT(usersp.name,' ',usersp.last_name) ELSE '---' END) AS process_name"),
            \DB::raw("(CASE WHEN(domiciliations.user_send_id IS NOT NULL) THEN CONCAT(userss.name,' ',userss.last_name) ELSE '---' END) AS send_name"),
            \DB::raw("(CASE WHEN(domiciliations.send_at IS NOT NULL) THEN DATE_FORMAT(domiciliations.send_at, '%Y-%m-%d %H:%i:%s') ELSE '---' END) AS send_at"),
            \DB::raw("(CASE WHEN(domiciliations.process_at IS NOT NULL) THEN DATE_FORMAT(domiciliations.process_at, '%Y-%m-%d %H:%i:%s') ELSE '----' END) AS process_at"),
            \DB::raw("(CASE WHEN(domiciliations.upload_at IS NOT NULL) THEN DATE_FORMAT(domiciliations.upload_at, '%Y-%m-%d %H:%i:%s') ELSE '----' END) AS upload_at")
        )
            ->join('banks', 'banks.id', '=', 'domiciliations.bank_id')
            ->leftjoin('users as usersc', 'usersc.id', '=', 'domiciliations.user_created_id')
            ->leftjoin('users as usersu', 'usersu.id', '=', 'domiciliations.user_upload_id')
            ->leftjoin('users as userss', 'userss.id', '=', 'domiciliations.user_send_id')
            ->leftjoin('users as usersp', 'usersp.id', '=', 'domiciliations.user_process_id');

        if ($request['status'] != 'Anulado' && $request['status'] != 'Procesado') {
            $model->whereIn('domiciliations.status', ['Generado', 'Enviado', 'Cargado']);
        } else {
            $model->where('domiciliations.status', 'LIKE', $request['status']);
        }

        $data = $model->get();

        return datatables()->of($data)
            ->editColumn('file_bank', function ($data) {
                return '<a class="btn btn-sm btn-danger" href="/domiciliations/download/' . $data->id . '" title="Descargar Archivo Bancario"><i class="nav-icon i-File-Download"></i></a>&nbsp;';
            })
            ->editColumn('file_response', function ($data) {
                if ($data->file_response != null) {
                    return '<a  class="btn btn-sm btn-danger" href="/domiciliations/download/response/' . $data->id . '" title="Descargar Archivo  Resultados Domiciliación"><i class="nav-icon i-File-Download"></i></a>';
                }

                return '---';
            })
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                $actions .= '<button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                           </button><div class="dropdown-menu" x-placement="bottom-start">';

                $actions .= '<button class="btn dropdown-item" data-toggle="modal"  value="' . $data->id . '"  OnClick="DomiciliationView(this);" data-target="#viewDomiciliation"  title="Información Gestión Cobranza Servicio">Información Gestión</button>';

                if ($data->status == 'Generado' || $data->status == 'Enviado' || $data->status == 'Cargado') {
                    if ($data->status == 'Generado') {
                        $actions .= '<button class="btn dropdown-item" data-toggle="modal" value="' . $data->id . '"  OnClick="DomiciliationSend(this);" data-target="#sendDomiciliation"  title="Envio Archivo Domiciliación x Gestión Cobro Servicio">Envio Archivo</button>';
                    }

                    if ($data->status == 'Enviado' || $data->status == 'Cargado') {
                        if (auth()->user()->can('domiciliations.edit')) {
                            $actions .= '<button class="btn dropdown-item" data-toggle="modal" value="' . $data->id . '"  OnClick="DomiciliationUpload(this);" data-target="#uploadResponseDomiciliation"  title="Cargar Resultado Gestión Cobro Servicio Bancario">Cargar Resultados</button>';
                        }
                    }

                    if ($data->status == 'Cargado') {
                        $actions .= '<button  class="btn dropdown-item" data-toggle="modal" value="' . $data->id . '"  OnClick="DomiciliationProcess(this);" data-target="#processDomiciliation"  title="Procesar Conciliación Resultados  Gestión Cobro Servicio Bancario">Conciliar Resultado</button>';
                    }

                    if (auth()->user()->can('domiciliations.destroy')) {
                        $actions .= '<button class="btn dropdown-item" data-toggle="modal" value="' . $data->id . '"  OnClick="DomiciliationDestroy(this);" data-target="#deleteDomiciliation"  title="Anular Gestión Cobro Servicio Bancario">Anular</button>';
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
        $domiciliation = $this->model->select('domiciliations.file_bank')->where('domiciliations.id', $id)->first();
        if (isset($domiciliation)) {
            return response()->download(storage_path($domiciliation->file_bank));
        }

        return false;
    }

    /************************************************************************/
    public function downloadResponse($id)
    {
        $domiciliation = $this->model->select('domiciliations.file_response_bank')->where('domiciliations.id', $id)->first();
        if (isset($domiciliation)) {
            return response()->download(storage_path($domiciliation->file_response_bank));
        }

        return false;
    }

    /************************************************************************/
    public function send($id)
    {
        $domiciliation = $this->model->where('domiciliations.id', $id)->where('domiciliations.status', 'LIKE', 'Generado')->first();
        if (isset($domiciliation)) {
            $domiciliation->status = 'Enviado';
            $domiciliation->user_send_id = Auth::user()->id;
            $domiciliation->send_at = now();
            $result = $domiciliation->save();

            if (isset($result)) {
                return true;
            }
        }

        return false;
    }

    /************************************************************************/
    public function upload($request)
    {
        ini_set('post_max_size', '300M');
        ini_set('upload_max_filesize', '300M');
        $domiciliation = $this->model->select('domiciliations.*', 'banks.bank_code')->join('banks', 'banks.id', '=', 'domiciliations.bank_id')->where('domiciliations.id', $request['upload_id'])->first();
        if (isset($domiciliation)) {
            $file = $request->file('file');
            $path = $domiciliation->bank_code . '/response/' . $file->getClientOriginalName();

            if (file_exists(storage_path() . $path)) {
                $result = Storage::disk('domiciliation')->delete($path);
            }

            $result = Storage::disk('domiciliation')->put($path, \File::get($file));

            if (isset($result)) {
                $domiciliation->file_response_bank = '/domiciliacion/' . $path;
                $domiciliation->status = 'Cargado';
                $domiciliation->user_upload_id = Auth::user()->id;
                $domiciliation->upload_at = now();
                $result = $domiciliation->save();

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
        ini_set('memory_limit', '8196M');
        $domiciliation = $this->model->where('domiciliations.id', $id)->where('domiciliations.status', 'LIKE', 'Cargado')->first();

        if (isset($domiciliation)) {
            $ConciliationServiceFactory = new ConciliationServiceFactory();
            $service = $ConciliationServiceFactory->initialize($domiciliation);
            $data = $service->insert($domiciliation);
            $user = User::find(Auth::user()->id);
            $bank = $this->model->select('banks.description as description')->join('banks', 'banks.id', '=', 'domiciliations.bank_id')->where('domiciliations.id', $id)->where('domiciliations.status', 'LIKE', 'Cargado')->first();
            /**
             * ! Jorge Thomas 28-11-2021 / Agregada variable para identificar cola por cada banco.
             */
            $countproc = 0;
            $countregs = 0;
            $total_amount_processed = 0;
            $total_amount_register = 0;
            foreach ($data as $key => $row) {
                if ($row['status_bank'] == 'P000' || $row['status_bank'] == '00' || $row['status_bank'] == '0000' || $row['status_bank'] == 'C' || $row['status_bank'] == 'Cobrado' || $row['status_bank'] == 'Aplicado' || $row['status_bank'] == 'TRANSACCION EXITOSA' || $row['status_bank'] == '000000' || $row['status_bank'] == '010' || $row['status_bank'] == 'P' || $row['status_bank'] == 'T' && $row['bank_id'] == 5 || $row['status_bank'] == '74') {
                    $countproc++;
                    $total_amount_processed = $row['amount'] + $total_amount_processed;
                }
                $countregs++;
                $total_amount_register = $row['amount'] + $total_amount_register;
            }
            $bankdescr = $bank->description;
            $rejected = $countregs - $countproc;
            $batch = Bus::batch([])->name($bankdescr)->onQueue($bankdescr)->then(function () use ($bankdescr, $countproc, $countregs, $rejected) {
                ini_set('memory_limit', '8196M');
                //Mail::to('cobranza@vepagos.com', 'sistemas@vepagos.com')->send(new DoCoFinished($bankdescr, $countproc, $rejected, $countregs));
            })->dispatch();
            //Mail::to('cobranza@vepagos.com', 'sistemas@vepagos.com')->send(new DoCoStarted($bankdescr, $countproc, $rejected, $countregs, $batch->id));
            foreach ($data as $key => $row) {
                $batch->add(new DomiciliationCollectionBank($row, $user, $id));
            }
            /**
             * ! Jorge Thomas 14-12-2021
             * * Se establecio un proceso de trabajos por cola que envian correo al finalizar los batches del proceso.
             */
            $domiciliation->status = 'Procesado';
            $domiciliation->total_processed = $countproc;
            $domiciliation->total_pending = $rejected;
            $domiciliation->total_amount_pending = $total_amount_register - $total_amount_processed;
            $domiciliation->total_amount_processed = $total_amount_processed;
            $domiciliation->total_amount_register = $total_amount_register;
            $domiciliation->total_register = $countregs;
            $domiciliation->user_process_id = Auth::user()->id;
            $domiciliation->process_at = now();
            $result = $domiciliation->save();

            if (isset($result)) {
                return true;
            }
        }

        return false;
    }
}
