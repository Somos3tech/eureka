<?php

namespace App\Modules\Sales\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ServiceFinancialReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**************************************************************************/
    public function collection()
    {
        $this->cont = count($this->data) + 1;

        return collect($this->data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'No. Identificador Cliente',
            'Código Profit',
            'Contrato',
            'Código Afiliación',
            'Serial Equipo',
            'Modelo Equipo',
            'Nombre Banco',
            'Cuenta Banco',
            'Plan VEPAGOS',
            'Frecuencia Uso',
            'Monto Pagar Diario',
            'Monto Pagar Mensual',
            'Fecha Inicio',
            'No. Terminal',
            'Código Usuario',
            'Status',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:P' . $this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:P1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('I1:J' . $this->cont)->getNumberFormat();
                $event->sheet->getDelegate()->getStyle('A1:P' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:P' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('I1:J' . $this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}
