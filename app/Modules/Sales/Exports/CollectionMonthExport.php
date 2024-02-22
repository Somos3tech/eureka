<?php

namespace App\Modules\Sales\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CollectionMonthExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $data = $this->data;
        $this->cont = count($data) + 1;

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Código',
            'Serial',
            'No. Terminal',
            'No. Contrato',
            'Fecha Contrato',
            'Nro. Afiliacion',
            'No. Cuenta',
            'Banco',
            'RIF',
            'Nombre Comercio',
            'Tipo Afiliación',
            'Tarifa',
            'Valor Tarifa',
            'Observaciones Venta',
            'Fecha Entrega',
            'Status Venta',
            'Status Servicio',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:Q'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:Q1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('M1:M'.$this->cont)->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('A1:Q'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:I'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('K1:Q'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
