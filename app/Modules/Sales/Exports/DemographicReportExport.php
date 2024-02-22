<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Customers\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class DemographicReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $query = Customer::query();

        $request = $this->data;
        $count = count($request['field']);

        $query->select(
            'customers.id as customer_id',
            \DB::raw("(CASE WHEN (customers.foreign_id IS NULL) THEN '----' ELSE LPAD(customers.foreign_id,6,'0') END) AS profit_id"),
            'customers.rif',
            'customers.business_name',
            'rc.document',
            \DB::raw("(CASE WHEN (rc.id IS NULL) THEN '---' ELSE rc.first_name END) AS name_rep"),
            'customers.telephone',
            'customers.mobile',
            'customers.email',
            'states.description as state',
            'cities.description as city',
            'customers.municipality as municipality',
            'customers.address as address',
            'customers.postal_code'
        )
            ->leftjoin('states', 'states.id', '=', 'customers.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'customers.city_id')
            ->leftjoin('rcustomers as rc', function ($join) {
                $join->on('rc.customer_id', '=', 'customers.id');
                $join->whereNull('rc.deleted_at')->limit(1);
            })
            ->leftjoin('cactivities as  ca', 'ca.id', '=', 'customers.cactivity_id');

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('customers.created_at', [$date[0].'%', $date[1].'%']);
            }
        }

        for ($i = 0; $i < $count; $i++) {
            if ($request['field'][$i] != null && $request['query'][$i] != null) {
                if ($request['operator'][$i] != null) {
                    $operator = $request['operator'][$i];
                } else {
                    $operator = '=';
                }

                if ($i == 0) {
                    $query->where('customers.'.$request['field'][$i], $operator, $request['query'][$i]);
                    $cond = $request['conditional'][$i];
                } else {
                    if ($cond == 'AND' || $cond == '') {
                        $query->where('customers.'.$request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    } else {
                        $query->OrWhere('customers.'.$request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    }
                }
            }
        }

        $data = $query->whereNull('customers.deleted_at')->groupBy('customers.rif')->distinct('customers.rif')->orderBy('customers.rif', 'ASC')->get();
        $this->cont = count($data) + 1;

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Código Cliente',
            'Código Profit',
            'RIF',
            'Nombre Comercio',
            'Documento Representante',
            'Nombre Representante',
            'Telefono',
            'Mobile',
            'Email',
            'Estado',
            'Ciudad',
            'Municipalidad',
            'Dirección',
            'Cod. Postal',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:N'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->setAutoFilter('A1:N1');
                $event->sheet->getDelegate()->getStyle('A1:N1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('J1:J'.$this->cont)->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('A1:N'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:C'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:E'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G1:H'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('N1:N'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
