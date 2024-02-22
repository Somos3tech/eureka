<?php

namespace App\Modules\Sales\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoiceActiveReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $data = [];
        $bucket = '----';
        $forecast = $this->data;
        foreach ($forecast as $key => $row) {
            if ($row['count_invoice'] == 0) {
                $bucket = 'Al día';
            } elseif ($row['count_invoice'] > 0 && $row['count_invoice'] < 16) {
                $bucket = '1 a 15 dias';
            } elseif ($row['count_invoice'] > 15 && $row['count_invoice'] < 31) {
                $bucket = '16 a 30 dias';
            } elseif ($row['count_invoice'] > 30 && $row['count_invoice'] < 61) {
                $bucket = '31 a 60 dias';
            } elseif ($row['count_invoice'] > 60 && $row['count_invoice'] < 91) {
                $bucket = '61 a 90 dias';
            } elseif ($row['count_invoice'] > 90) {
                $bucket = 'Mayor a 90 dias';
            }

            $data[$key]['number_account'] = $row['number_account'];
            $data[$key]['bank_name'] = $row['bank_name'];
            $data[$key]['customer_id'] = $row['customer_id'];
            $data[$key]['foreign_id'] = $row['foreign_id'];
            $data[$key]['contract_id'] = $row['contract_id'];
            $data[$key]['rif'] = $row['rif'];
            $data[$key]['business_name'] = $row['business_name'];
            $data[$key]['posted'] = $row['posted'];
            $data[$key]['amount_invoice'] = $row['amount_invoice'] != null ? $row['amount_invoice'] : '----';
            $data[$key]['fechpro_collection'] = $row['fechpro_collection'] != null ? $row['fechpro_collection'] : '----';
            $data[$key]['amount_collection'] = $row['amount_collection'] != null ? $row['amount_collection'] : '----';
            $data[$key]['amount_currency_collection'] = $row['amount_currency_collection'] != null ? $row['amount_currency_collection'] : '----';
            $data[$key]['serial_terminal'] = $row['serial_terminal'];

            $data[$key]['modelterminal'] = $row['modelterminal'];
            $data[$key]['term_abrev'] = $row['term_abrev'];
            $data[$key]['comission_flatrate'] = $row['comission_flatrate'];
            $data[$key]['count_invoice'] = $row['count_invoice'] != null ? $row['count_invoice'] : '----';
            $data[$key]['bucket'] = $bucket;
            $data[$key]['contract_status'] = $row['contract_status'];
        }
        $this->cont = count($data) + 1;

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Código Compuesto',
            'Banco',
            'Código Cliente',
            'Código Profit',
            'Contrato',
            'RIF',
            'Comercio',
            'Fecha Ingreso',
            'Saldo Mora',
            'Fecha Últ. Pago',
            'Monto Últ. Pago',
            'Monto Bs. Últ. Pago',
            'Serial',
            'Modelo',
            'Plan',
            'Cobro Diario',
            'Dias Mora',
            'Bucket Mora',
            'Status Servicio',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:S' . $this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->setAutoFilter('A1:S1');
                $event->sheet->getDelegate()->getStyle('A1:S1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('J1:K' . $this->cont)->getNumberFormat()->setFormatCode('###0.00');
                $event->sheet->getDelegate()->getStyle('M1:M' . $this->cont)->getNumberFormat()->setFormatCode('###0.00');
                $event->sheet->getDelegate()->getStyle('A1:S' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('B1:E' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G1:S' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
