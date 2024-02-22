<?php

namespace App\Modules\Operations\Repositories\Exports;

use App\Modules\Operations\Models\Order;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportPlatcoExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function collection()
    {
        $q = Order::query();

        $q->select(\DB::raw("(REPLACE(cs.rif,'-','')) as rif"), 'dc.affiliate_number', 'cs.business_name', 'cs.address', \DB::raw(" (CASE WHEN (tm.serial IS NULL) THEN '----' ELSE tm.serial END) as serial_terminal"), 'mt.description as modelo', 'cp.description as almacen')
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->leftjoin('dcustomers as dc', function ($join) {
                $join->on('dc.id', '=', 'ct.dcustomer_id');
                $join->whereNull('dc.deleted_at');
            })
            ->leftjoin('terminals as tm', 'tm.id', '=', 'ct.terminal_id')->leftjoin('companies as cp', 'cp.id', '=', 'ct.company_id')
            ->whereIn('orders.status', ['P'])->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id');

        if (Auth::user()->company_id != null) {
            $q->where('ct.company_id', Auth::user()->company_id);
        }

        if (Auth::user()->banklist != null) {
            $q->whereIn('dc.bank_id', json_decode(Auth::user()->banklist, true));
        }

        $data = $q->where('dc.bank_id', 9)->whereNull('orders.credicard')->orderBy('orders.id', 'ASC')->whereNull('orders.deleted_at')->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    /****************************************************************************/
    public function headings(): array
    {
        return [
            'RIF',
            'Código Platco',
            'Nombre del Comercio',
            'Dirección',
            'Serial Asignado',
            'Modelo Serial',
            'Almacen',
            'Tipo de Comunicación',
            'No. Orden de Servicio',
        ];
    }

    /****************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:H'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri')->setSize(11);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('736941');

                $event->sheet->getDelegate()->getStyle('A1:I'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:B'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:G'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
    /****************************************************************************/
}
