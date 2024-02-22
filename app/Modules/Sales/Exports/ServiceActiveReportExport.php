<?php

namespace App\Modules\Sales\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ServiceActiveReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $data = [];
        $forecast = $this->data;
        foreach ($forecast as $key => $row) {
            $conceptc = unserialize($row['conceptc']);

            if (isset($conceptc['type_biweekly'])) {
                $type_biweekly = $conceptc['type_biweekly'];
            } else {
                $type_biweekly = $row['frec_invoice'];
            }

            $data[$key]['id'] = $row['id'];
            $data[$key]['fechpro'] = date_format(date_create($row['fechpro']), 'Y-m-d');
            $data[$key]['rif'] = $row['rif'];
            $data[$key]['business_name'] = $row['business_name'];
            $data[$key]['contract_id'] = str_pad($row['contract_id'], 8, '0', STR_PAD_LEFT);
            $data[$key]['bank_name'] = $row['bank_name'];
            $data[$key]['serial_terminal'] = $row['serial_terminal'];
            $data[$key]['nropos'] = $row['nropos'];
            $data[$key]['currency'] = $row['currency'];
            $data[$key]['amount'] = $row['amount'];
            $data[$key]['tipnot'] = $row['tipnot'];
            $data[$key]['refere'] = $row['refere'];
            $data[$key]['frec_invoice'] = $type_biweekly;
            $data[$key]['nrocta'] = $row['nrocta'];
            $data[$key]['affiliate_number'] = $row['affiliate_number'];
        }
        $this->cont = count($data) + 1;

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'ID Cobro',
            'Creado',
            'RIF',
            'Comercio',
            'No. Contrato',
            'Nombre Banco',
            'Serial Terminal',
            'No. Terminal',
            'Tipo Moneda',
            'Monto Cobro',
            'Tipo Cobro',
            'Referencia',
            'Frecuencia Cobro',
            'No. Cuenta',
            'Afiliación Bancaría',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:O'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->setAutoFilter('A1:O1');
                $event->sheet->getDelegate()->getStyle('A1:O1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('J1:J'.$this->cont)->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('A1:O'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:C'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:E'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G1:O'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
