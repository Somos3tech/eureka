<?php

namespace App\Modules\Sales\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class StatementExcelReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $data = [];
        $contract = $this->data['data'];
        $customer = $this->data['customer'];
        $previousinvoice = $this->data['previousinvoice'];
        $previousmonth = $this->data['previousmonth'];
        $request = $this->data['request'];
        $data[0]['concepto'] = 'Balance Anterior';
        $data[0]['fecha'] = $previousmonth;
        $data[0]['cargos'] = $previousinvoice['cargos'];
        $data[0]['descripcion'] = '';
        $data[0]['pagofecha'] = '';
        $data[0]['abonos'] = $previousinvoice['abonos'] == null ? '0.00' : $previousinvoice['abonos'];
        $data[0]['balance'] = $previousinvoice['cargos'] - $previousinvoice['abonos'];
        $balance = 0;
        $abonos = 0;
        $cargos = 0;
        foreach ($contract as $key => $row) {
            if ($row['amount_currency'] == '----') {
                $amount_currency = '0,00';
            } else {
                $amount_currency = number_format($row['amount_currency'], 2, '.', ',');
            }
            $abono_individual = 0;
            $data[$key + 1]['concepto'] = $row['type'];
            $data[$key + 1]['fecha'] = $row['date'];
            $data[$key + 1]['cargos'] = $row['amount'];
            $data[$key + 1]['descripcion'] = $row['refere'];
            $data[$key + 1]['pagofecha'] = strtotime($row['payment_date']) > 0 ? date('d-m-Y', strtotime($row['payment_date'])) : '----';

            if ($row['type_abrev'] == 'C' || $row['type_abrev'] == 'E' || $row['type_abrev'] == 'N') {
                $cargos += $row['amount'];
                $abono_individual = $row['amount'].' (Bs. '.$amount_currency.')';
                $abonos = $abonos + $row['amount'];

                $data[$key + 1]['abonos'] = $abonos.' (Bs. '.$amount_currency.')';
                $data[$key + 1]['balance'] = number_format($balance, 2, '.', ',');
            } elseif ($row['type_abrev'] == 'P' || $row['type_abrev'] == 'G' || $row['type_abrev'] == 'R') {
                $cargos += $row['amount'];
                $balance += $row['amount'];
                $abono_individual = '----';

                $data[$key + 1]['abonos'] = $abono_individual;
                $data[$key + 1]['balance'] = number_format($balance, 2, '.', ',');
            }
        }
        $last = count($data) + 1;
        $data[$last]['concepto'] = 'Totales';
        $data[$last]['fecha'] = '';
        $data[$last]['cargos'] = number_format($cargos, 2, '.', ',');
        $data[$last]['descripcion'] = '';
        $data[$last]['pagofecha'] = '';
        $data[$last]['abonos'] = number_format($abonos, 2, '.', ',');
        $data[$last]['balance'] = number_format($balance, 2, '.', ',');
        $this->cont = count($data) + 1;

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Concepto',
            'Fecha',
            'Cargos',
            'Descripción de Pago',
            'Fecha de Pago',
            'Abonos',
            'Balance',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:G'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('I1:J'.$this->cont)->getNumberFormat();
                $event->sheet->getDelegate()->getStyle('A1:G'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:G'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // $event->sheet->getDelegate()->getStyle('I1:J' . $this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}
