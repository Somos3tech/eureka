<?php

namespace App\Modules\Sales\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class OperationResponseExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
        $this->cont = count($this->data) + 1;

        return Collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Gestión Operación',
            'No. Cobro',
            'Tipo Operación',
            'Fecha',
            'Tipo Pago',
            'Cuenta Contable',
            'Monto',
            'Tasa Cambio',
            'Monto Bs.',
            'Referencia',
            'Observaciones',
            'Respuesta Carga',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:L'.$this->cont; // All headers
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
                $event->sheet->getDelegate()->getStyle('A1:L'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:H'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F1:H'.$this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}
