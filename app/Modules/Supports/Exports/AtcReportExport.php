<?php

namespace App\Modules\Supports\Exports;

use App\Modules\Supports\Models\Atc;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AtcReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents, WithColumnFormatting, WithMapping
{
    public $cont;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /****************************************************************************/
    public function array(): array
    {
        return $this->data;
    }

    /****************************************************************************/
    public function collection()
    {
        $request = $this->data;
        $query = Atc::query();

        $query->select(
            \DB::raw("LPAD(atcs.id ,6,'0') AS atc_id"), //Nro de Caso
            \DB::raw(' atcs.created_at AS created'), //Fecha Creación
            \DB::raw("(CASE WHEN (atcs.customer_id IS NULL AND mt.slug = 'internal') THEN CONCAT(atcs.first_name,' ',atcs.last_name) WHEN (atcs.customer_id IS NOT NULL AND mt.slug != 'internal') THEN cs.business_name ELSE CONCAT(us.name,' ',us.last_name) END) AS name"), // Nombre de Comercio
            \DB::raw("(CASE WHEN (atcs.customer_id IS NULL AND mt.slug!='internal') THEN atcs.telephone WHEN (atcs.customer_id IS NOT NULL AND mt.slug!='internal') THEN cs.telephone ELSE '----' END) AS telephone"), //Telefono
            \DB::raw("(CASE WHEN (atcs.customer_id IS NULL AND mt.slug!='internal') THEN atcs.mobile WHEN (atcs.customer_id IS NOT NULL AND mt.slug!='internal') THEN cs.mobile ELSE '----' END) AS mobile"), //Celular
            \DB::raw("(CASE WHEN (atcs.customer_id IS NULL AND mt.slug!='internal') THEN atcs.email WHEN (atcs.customer_id IS NOT NULL AND mt.slug!='internal') THEN cs.email ELSE '----' END) AS email"), //Email
            \DB::raw("(CASE WHEN (atcs.contract_id IS NULL) THEN '----' ELSE mte.description END) AS modelterminal"), //Modelo de Terminal
            \DB::raw("(CASE WHEN (atcs.contract_id IS NULL) THEN '----' ELSE ter.serial END) AS serial"), //Serial Terminal
            \DB::raw("(CASE WHEN (atcs.contract_id IS NULL) THEN '----' ELSE op.description END) AS operadora"), //Operadora Telefonica
            \DB::raw("(CASE WHEN (atcs.contract_id IS NULL) THEN '----' ELSE bk.description END) AS banco"), //Banco
            \DB::raw("(CASE WHEN (atcs.contract_id IS NULL) THEN '----' ELSE cm.description END) AS almacen"), //Almacen
            'channels.description as channel', //Canal de Gestión
            'mt.description as managementtype', //Tipo de Gestión
            'mitem.description as mtypeitem', // Tipo de Item
            'atcs.observation', //Observaciones
            \DB::raw("(CASE WHEN (atcs.observation_manager IS NULL) THEN '----' ELSE atcs.observation_manager END) AS observation_manager"), //Observaciones de Gestión
            \DB::raw("(CASE WHEN (atcs.status='G') THEN 'Generado' WHEN (atcs.status='P') THEN 'En Proceso' WHEN (atcs.status='F') THEN 'Finalizado'  WHEN (atcs.status='X') THEN 'Anulado' ELSE '----' END) AS statusc"), //Status de Gestión
            \DB::raw("CONCAT(us.name,' ',us.last_name) AS user_created"), //Usuario de Creación
            \DB::raw("(CASE WHEN (atcs.updated_at IS NULL) THEN '----' ELSE atcs.updated_at END) AS updated"), //Fecha de Actualización
            \DB::raw("(CASE WHEN (atcs.user_updated_id IS NULL) THEN '----' ELSE CONCAT(users.name,' ',users.last_name) END) AS name_updated") //Usuario de Actualización
        )
            ->leftjoin('customers as cs', 'cs.id', '=', 'atcs.customer_id')
            ->leftjoin('contracts', 'contracts.id', '=', 'atcs.contract_id')
            ->leftjoin('modelterminal as mte', 'mte.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('terminals as ter', 'ter.id', '=', 'contracts.terminal_id')
            ->leftjoin('operators as op', 'op.id', '=', 'contracts.operator_id')
            ->leftjoin('companies as cm', 'cm.id', '=', 'contracts.company_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('managementtypes as mt', 'mt.id', '=', 'atcs.managementtype_id')
            ->leftjoin('mtypeitems as mitem', 'mitem.id', '=', 'atcs.mtypeitem_id')
            ->leftjoin('channels', 'channels.id', '=', 'atcs.channel_id')
            ->leftjoin('users', 'users.id', '=', 'atcs.user_updated_id')
            ->leftjoin('users as us', 'us.id', '=', 'atcs.user_created_id');

        if ($request['channel_id'] != '') {
            $query->where('atcs.channel_id', '=', $request['channel_id']);
        }

        if ($request['managementtype_id'] != '') {
            $query->where('atcs.managementtype_id', '=', $request['managementtype_id']);
        }

        if ($request['mtypeitem'] != '') {
            $query->where('atcs.mtypeitem_id', '=', $request['mtypeitem_id']);
        }

        if ($request['statusc'] != '') {
            $query->where('atcs.status', 'LIKE', $request['statusc']);
        }

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('atcs.created_at', [$date[0].'%', $date[1].'%']);
            }
        }

        $data = $query->orderBy('atcs.id', 'ASC')->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    /****************************************************************************/
    public function headings(): array
    {
        return [
            'No. ATC',
            'Creado',
            'Comercio / Usuario',
            'Telefono',
            'Movíl',
            'Email',
            'Modelo Terminal',
            'Serial Terminal',
            'Operadora',
            'Banco',
            'Almacen',
            'Canal Gestión',
            'Tipo Gestión',
            'Item Gestión',
            'Obsevación Inicial',
            'Observación Final',
            'Status',
            'Creado Por',
            'Actualizado',
            'Actualizado Por',
        ];
    }

    /****************************************************************************/
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'S' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    /****************************************************************************/
    public function map($row): array
    {
        if ($row->created == null) {
            $row->created = 0;
        }
        if ($row->updated == null) {
            $row->updated = 0;
        }

        return [
            $row->atc_id,
            Date::dateTimeToExcel(Carbon::parse($row->created)),
            $row->name,
            $row->telephone,
            $row->mobile,
            $row->email,
            $row->modelterminal,
            $row->serial,
            $row->operadora,
            $row->banco,
            $row->almacen,
            $row->channel,
            $row->managementtype,
            $row->mtypeitem,
            $row->observation,
            $row->observation_manager,
            $row->statusc,
            $row->user_created,
            Date::dateTimeToExcel(Carbon::parse($row->updated)),
            $row->name_updated,
        ];
    }

    /****************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:T'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->setAutoFilter($event->sheet->getDelegate()->calculateWorksheetDimension());

                $event->sheet->getDelegate()->getStyle('A1:T1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:T'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:B'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('D1:N'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Q1:T'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
