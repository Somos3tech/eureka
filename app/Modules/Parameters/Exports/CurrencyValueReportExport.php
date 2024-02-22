<?php

namespace App\Modules\Parameters\Exports;

use App\Modules\Parameters\Models\Currencyvalue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CurrencyValueReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**************************************************************************/
    public function array(): array
    {
        return $this->data;
    }

    /**************************************************************************/
    public function collection()
    {
        $request = $this->data;

        $query = Currencyvalue::query();

        $query->select('currencyvalues.date_value', 'currencies.description as currency', 'currencyvalues.amount', 'currencyvalues.description')
            ->leftjoin('currencies', function ($join) {
                $join->on('currencies.id', '=', 'currencyvalues.currency_id');
            });

        if ($request['date_range'] != null) {
            $date = explode('|', $request['date_range']);
            $query->whereBetween('date_value', [$date[0], $date[1]]);
        }

        $data = $query->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'Fecha',
            'Divisa',
            'Valor Divisa',
            'Descripción',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:D'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->setAutoFilter($event->sheet->getDelegate()->calculateWorksheetDimension());

                $event->sheet->getDelegate()->getStyle('A1:D1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:D'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:D'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
