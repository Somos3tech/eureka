<?php

namespace App\Modules\Warehouses\Exports;

use App\Modules\Warehouses\Models\Terminal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportTerminalExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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

        $query = Terminal::query();

        $query->select(
            \DB::raw(" (CASE WHEN (terminals.fechpro IS NULL) THEN '---' ELSE terminals.fechpro END) as fechpro"),
            'terminals.serial',
            'mt.description as modelterminal',
            'cp.description',
            'terminals.status as terminal_status',
            \DB::raw(" (CASE WHEN (terminals.status='Disponible' AND or.status = 'P') THEN '----' WHEN (terminals.status='Asignado' AND or.status = 'P') THEN 'En Programación' WHEN (terminals.status='Asignado' AND or.status = 'PF') THEN 'Programación - Finalizada' WHEN (terminals.status='Asignado' AND or.status = 'A') THEN 'En Almacen - Sin Facturar'  WHEN (terminals.status='Asignado' AND or.status = 'F') THEN 'En Almacen - Facturado' WHEN (terminals.status='Asignado' AND or.status = 'D') THEN 'En Despacho'  WHEN (terminals.status='Entregado' AND or.status = 'C') THEN 'Entregado Cliente' ELSE '----' END) as status"),
            \DB::raw(" (CASE WHEN (assign.status = 'P') THEN CONCAT(us.name,' ', us.last_name) ELSE '----' END) as username"),
            \DB::raw("(CASE WHEN (cs.business_name IS NULL) THEN '-----' ELSE cs.business_name END) as business_name"),
            \DB::raw(" (CASE WHEN (assign.created_at IS NULL) THEN '----' ELSE assign.created_at END) as created_at_assign"),
            \DB::raw(" (CASE WHEN (assign.updated_at IS NULL) THEN '----' ELSE assign.updated_at END) as updated_at_assign")
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.terminal_id', '=', 'terminals.id');
                $join->whereIn('ct.status', ['Activo', 'Pendiente']);
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->leftjoin('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'ct.id');
                $join->where('or.status', '!=', 'X');
                $join->whereNull('or.deleted_at');
            })
            ->leftjoin('assignments as assign', function ($join) {
                $join->on('assign.terminal_id', '=', 'terminals.id');
                $join->whereNull('assign.deleted_at');
            })
            ->leftjoin('companies as cp', 'cp.id', '=', 'terminals.company_id')
            ->leftjoin('modelterminal as mt', 'mt.id', 'terminals.modelterminal_id')
            ->leftjoin('users as us', 'us.id', '=', 'assign.user_assign_id');

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('terminals.created_at', [$date[0] . '%', $date[1] . '%']);
            }
        }

        if ($request['statusc'] != '') {
            $query->where('terminals.status', '=', $request['statusc']);
        }

        $data = $query->orderBy('terminals.status', 'ASC')->orderBy('terminals.modelterminal_id', 'ASC')->get();

        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            'Fecha Ingreso',
            'Serial',
            'Modelo Terminal',
            'Almacén',
            'Status',
            'Canal Asignado',
            'Asignado A',
            'Nombre Comercio',
            'Fecha Asignación',
            'Fecha Actualización',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:I' . $this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');

                $event->sheet->getDelegate()->getStyle('A1:I' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:I' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
