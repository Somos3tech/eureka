<?php

namespace App\Modules\Sales\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ServiceDetailReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**************************************************************************/
    public function collection()
    {
        ini_set('memory_limit', '8096M');
        $this->cont = count($this->data) + 1;

        return collect($this->data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'No. Contrato',
            'No. Cobro',
            'Código Cliente',
            'Código Profit',
            'CI/RIF',
            'Nombre Cliente',
            'Banco',
            'No. Cuenta',
            'Fecha Generacion',
            'Fecha Aplicación',
            'Monto Cargo $',
            'Tasa Aplicada',
            'Monto Cargo Bs.',
            'Resultado',
            'Codigo Afiliacion',
            'Nro Pos',
            'Serial Equipo',
            'Plan Pago',
            'Frecuencia',
            'Codigo Compuesto',
            /**
             * ! Jorge Thomas
             * * Se agrega campo de referencia por solicitud de cobranza.
             */
            'Referencia',
            'Fecha Ingreso',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:U'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:V1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:V1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:V'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:E'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G1:V'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('K1:M'.$this->cont)->getNumberFormat()->setFormatCode('###0.00');
            },
        ];
    }
}
