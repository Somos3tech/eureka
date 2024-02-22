<?php

namespace App\Modules\Supports\Repositories;

use App\Events\Atc as AtcEvent;
use App\Modules\Supports\Exports\AtcReportExport;
use App\Modules\Supports\Models\Atc;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class AtcRepository implements AtcInterface
{
    protected $atc;

    /**
     * AtcRepository constructor.
     *
     * @param  Atc  $atc
     */
    public function __construct(Atc $atc)
    {
        $this->model = $atc;
    }

    /**************************************************************************/
    public function create($request)
    {
        $result = $this->model->create([
            'channel_id' => $request['channel_id'],
            'customer_id' => $request->has('customer_id') ? $request['customer_id'] : null,
            'contract_id' => $request->has('contract_id') ? $request['contract_id'] : null,
            'rif' => $request->has('customer_id') ? $request['rif'] : '----',
            'first_name' => $request->has('business_name') ? $request['business_name'] : $request['first_name'],
            'last_name' => $request->has('business_name') && $request['type_atc'] != 'customer' ? null : '----',
            'telephone' => $request->has('telephone') ? $request['telephone'] : null,
            'mobile' => $request->has('mobile') ? $request['mobile'] : null,
            'email' => $request['email'],
            'managementtype_id' => $request['managementtype_id'],
            'mtypeitem_id' => $request['mtypeitem_id'],
            'observation' => $request['observation'],
            'status' => 'G',
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            $data = $this->totalStatus();
            event(new AtcEvent($data));

            return true;
        }

        return false;
    }

    /**************************************************************************/
    public function find($id)
    {
        $model = $this->model->query();
        $data = $model->select(
            \DB::raw("LPAD(atcs.id,6,'0') as id"),
            \DB::raw("(CASE WHEN (atcs.customer_id IS NULL) THEN '----' ELSE LPAD(atcs.customer_id,6,'0') END) as customer_id"),
            'atcs.rif',
            \DB::raw("(CASE WHEN (atcs.customer_id IS NOT NULL) THEN atcs.first_name WHEN (atcs.rif IS NULL) THEN atcs.first_name ELSE CONCAT(atcs.first_name,' ',atcs.last_name) END) as name"),
            'atcs.telephone',
            'atcs.mobile',
            'atcs.email',
            'managementtypes.description as managementtype',
            'mtypeitems.description as mtypeitem',
            'atcs.status',
            \DB::raw("DATE_FORMAT(atcs.created_at,'%Y-%m-%d') as created"),
            \DB::raw("(CASE WHEN (atcs.user_created_id IS NULL) THEN '----' ELSE CONCAT(users.name,' ',users.last_name) END) as created_name"),
            \DB::raw("DATE_FORMAT(atcs.updated_at,'%Y-%m-%d') as updated"),
            \DB::raw("(CASE WHEN (atcs.user_updated_id IS NULL) THEN '----' ELSE CONCAT(us.name,' ',us.last_name) END) as updated_name"),
            'channels.description as channel',
            'atcs.status as status_atc',
            'managementtypes.slug',
            \DB::raw("(CASE WHEN (atcs.observation IS NULL) THEN '----' ELSE atcs.observation END) as observation"),
            \DB::raw("(CASE WHEN (atcs.observation_manager IS NULL) THEN '----' ELSE atcs.observation_manager END) as observation_manager")
        )
            ->leftjoin('managementtypes', 'managementtypes.id', '=', 'atcs.managementtype_id')
            ->leftjoin('mtypeitems', 'mtypeitems.id', '=', 'atcs.mtypeitem_id')
            ->leftjoin('channels', 'channels.id', '=', 'atcs.channel_id')
            ->leftjoin('users', 'users.id', '=', 'atcs.user_created_id')
            ->leftjoin('users as us', 'us.id', '=', 'atcs.user_updated_id')
            ->where('atcs.id', $id)
            ->first();

        return \Response::json($data);
    }

    /**************************************************************************/
    public function update($request, $id)
    {
        $model = $this->model->findOrfail($id);

        if ($request->has('management')) {
            $model->status = 'P';
            $model->observation_manager = $request['observation_manager'];
        } elseif ($request->has('edit')) {
            if ($request['channel_id'] != null) {
                $model->channel_id = $request['channel_id'];
            }
            if ($request['managementtype_id'] != null && $request['mtypeitem_id'] != null) {
                $model->managementtype_id = $request['managementtype_id'];
                $model->mtypeitem_id = $request['mtypeitem_id'];
            }
        } else {
            $model->observation_manager = $request['observation_manager'];
            $model->status = 'F';
        }
        $model->user_updated_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $data = $this->totalStatus();
            event(new AtcEvent($data));

            return true;
        }

        return false;
    }

    /**************************************************************************/
    public function delete($request, $id)
    {
        $model = $this->model->findOrfail($id);
        $model->observation_manager = $request['observation_manager'];
        $model->status = 'X';
        $model->user_updated_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $data = $this->totalStatus();
            event(new AtcEvent($data));

            return true;
        }

        return false;
    }

    /**************************************************************************/
    public function datatable($request)
    {
        $model = $this->model->query();
        $model->select(\DB::raw("LPAD(atcs.id,6,'0') as id"), \DB::raw("(CASE WHEN (atcs.rif IS NOT NULL) THEN atcs.rif ELSE '----' END) as rif"), \DB::raw("(CASE WHEN (atcs.customer_id IS NOT NULL) THEN atcs.first_name WHEN (atcs.rif IS NULL) THEN atcs.first_name ELSE CONCAT(atcs.first_name,' ',atcs.last_name) END) as name"), 'managementtypes.description as managementtype', 'managementtypes.slug', 'atcs.status', \DB::raw("DATE_FORMAT(atcs.created_at,'%Y-%m-%d') as created"), \DB::raw("(CASE WHEN (atcs.user_created_id IS NULL) THEN '----' ELSE CONCAT(users.name,' ',users.last_name) END) as created_name"), \DB::raw("DATE_FORMAT(atcs.updated_at,'%Y-%m-%d') as updated"), \DB::raw("(CASE WHEN (atcs.user_updated_id IS NULL) THEN '----' ELSE CONCAT(us.name,' ',us.last_name) END) as updated_name"), 'channels.description as channel', 'atcs.status as status_atc')
            ->leftjoin('managementtypes', 'managementtypes.id', '=', 'atcs.managementtype_id')
            ->leftjoin('channels', 'channels.id', '=', 'atcs.channel_id')
            ->leftjoin('users', 'users.id', '=', 'atcs.user_created_id')
            ->leftjoin('users as us', 'us.id', '=', 'atcs.user_updated_id');

        if ($request->has('slug') && $request['slug'] != '') {
            $model->where('managementtypes.slug', 'LIKE', $request['slug']);
        }

        if ($request->has('status') && $request['status'] != '') {
            $model->where('atcs.status', 'LIKE', $request['status']);
        } else {
            $model->whereIn('atcs.status', ['G', 'P']);
        }

        $data = $model->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                        </button><div class="dropdown-menu" x-placement="bottom-start">';

                $actions .= '<button class="dropdown-item"  data-toggle="modal" value="'.(int) $data->id.'"  OnClick="atcsshow(this);" data-target="#atcsShow" title="Ver Información">Ver Información</button>';

                if ($data->status_atc != 'X' && $data->status_atc != 'F') {
                    if (auth()->user()->can('atcs.edit')) {
                        if ($data->status_atc == 'G') {
                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="'.(int) $data->id.'"  OnClick="atcsshow(this);" data-target="#atcsChange" title="Editar">Editar</button>';

                            $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="'.(int) $data->id.'"  OnClick="atcsshow(this);" data-target="#atcsManagement" title="Gestionar">Gestionar Ticket</button>';
                        }
                        $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="'.(int) $data->id.'"  OnClick="atcsshow(this);" data-target="#atcsUpdate" title="Procesar">Procesar</button>';
                    }
                    if (auth()->user()->can('atcs.destroy')) {
                        $actions .= '<button class="dropdown-item" href="#" data-toggle="modal" value="'.(int) $data->id.'"  OnClick="atcsshow(this);" data-target="#atcsDelete" title="Anular">Anular</button>';
                    }
                }
                $actions .= '</div>';

                return $actions;
            })->rawColumns(['actions', 'status'])
            ->toJson();
    }

    /*************************************************************************/
    public function totalStatus()
    {
        $data_status = $this->model->select('atcs.status as atc_status', \DB::raw('count(*) as total'))
            ->whereNull('atcs.deleted_at')
            ->groupBy('atc_status')
            ->get();

        $data_type = $this->model->select(\DB::raw("(CASE WHEN (managementtypes.slug='developer') THEN 'internal' WHEN (managementtypes.slug='internal') THEN 'internal' ELSE managementtypes.slug END) AS atc_status"), \DB::raw('count(*) as total'))
            ->join('managementtypes', 'managementtypes.id', '=', 'atcs.managementtype_id')
            ->whereNull('atcs.deleted_at')
            ->groupBy('atc_status')
            ->get();

        $data = array_merge($data_status->toArray(), $data_type->toArray());

        return \Response::json($data);
    }

    /******************************Reporte de ATC******************************/
    public function report($request)
    {
        $export = new AtcReportExport($request);

        return Excel::download($export, 'Reporte Gestión ATC '.date('Y-m-d').'.xlsx');
    }
}
