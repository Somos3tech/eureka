<?php

namespace App\Modules\Warehouses\Exports;

use App\Modules\Warehouses\Models\Simcard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportSimcardExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function collection()
    {
        $request = $this->data;

        $query = Simcard::query();
        $query->select(
            'simcards.id',
            \DB::raw("CONCAT(' ', simcards.serial_sim) as serial_sim"),
            'op.description as operator',
            \DB::raw(" (CASE WHEN (apn.id IS NULL) THEN '---' ELSE apn.description END) as apn"),
            'cp.description as company',
            \DB::raw("(CASE WHEN (cs.business_name IS NULL) THEN '-----' ELSE cs.business_name END) as business_name"),
            'simcards.status as simcard_status',
            \DB::raw(" (CASE WHEN (simcards.status='Disponible' AND or.status = 'P') THEN '----' WHEN (simcards.status='Asignado' AND or.status = 'P') THEN 'En Programación' WHEN (simcards.status='Asignado' AND or.status = 'PF') THEN 'Programación - Finalizada' WHEN (simcards.status='Asignado' AND or.status = 'A') THEN 'En Almacen - Sin Facturar'  WHEN (simcards.status='Asignado' AND or.status = 'F') THEN 'En Almacen - Facturado' WHEN (simcards.status='Asignado' AND or.status = 'D') THEN 'En Despacho'  WHEN (simcards.status='Entregado' AND or.status = 'C') THEN 'Entregado Cliente' ELSE '----' END) as status"),
            \DB::raw(" (CASE WHEN (assign.status = 'P') THEN CONCAT(us.name,' ', us.last_name) ELSE '----' END) as username"),
            \DB::raw(" (CASE WHEN (assign.created_at IS NULL) THEN '----' ELSE assign.created_at END) as created_at_assign"),
            \DB::raw(" (CASE WHEN (assign.updated_at IS NULL) THEN '----' ELSE assign.updated_at END) as updated_at_assign")
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.simcard_id', '=', 'simcards.id');
                $join->whereIn('ct.status', ['Activo', 'Pendiente', 'Cancelado', 'Suspendido']);
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('assignments as assign', function ($join) {
                $join->on('assign.simcard_id', '=', 'simcards.id');
                $join->whereNull('assign.deleted_at');
            })
            ->leftjoin('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'ct.id');
                $join->where('or.status', '!=', 'X');
                $join->whereNull('or.deleted_at');
            })
            ->leftjoin('operators as op', function ($join) {
                $join->on('op.id', '=', 'simcards.operator_id');
                $join->whereNull('op.deleted_at');
            })
            ->leftjoin('apn', function ($join) {
                $join->on('apn.id', '=', 'simcards.apn_id');
                $join->whereNull('apn.deleted_at');
            })
            ->leftjoin('companies as cp', 'cp.id', '=', 'simcards.company_id')
            ->leftjoin('users as us', 'us.id', '=', 'assign.user_assign_id');

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('simcards.created_at', [$date[0] . '%', $date[1] . '%']);
            }
        }

        if ($request['statusc'] != '') {
            $query->where('simcards.status', '=', $request['statusc']);
        }

        $data = $query->orderBy('simcards.status', 'DESC')->orderBy('assign.status', 'DESC')->get();

        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            '# Serial',
            'Serial',
            'Operador',
            'APN',
            'Almacén',
            'Nombre Comercio',
            'Status Simcard',
            'Canal Asignado',
            'Usuario Asignado / Usuario Entrega',
            'Creado',
            'Actualizado',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:L' . $this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:L1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');

                $event->sheet->getDelegate()->getStyle('A1:L' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:L' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
