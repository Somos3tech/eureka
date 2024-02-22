<?php

namespace App\Modules\Customers\Exports;

use App\Modules\Customers\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CustomerReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
        ini_set('memory_limit', '2000M');
        $data = [];
        $request = $this->data;

        $query = Customer::query();

        $query->select(
            'customers.id as customer_id',
            \DB::raw("(CASE WHEN (customers.foreign_id IS NULL) THEN '----' ELSE LPAD(customers.foreign_id,6,'0') END) AS profit_id"),
            'customers.rif',
            'customers.business_name',
            'ca.description as cactivity',
            \DB::raw("(CASE WHEN (customers.type_cont = '1') THEN 'Contribuyente Ordinario' WHEN (customers.type_cont = '2') THEN 'Contribuyente Especial' ELSE '---' END) AS type_cont"),
            \DB::raw("(CASE WHEN (customers.tax IS NULL) THEN '---' ELSE customers.tax END) AS taxes"),
            'rc.document',
            \DB::raw("(CASE WHEN (rc.id IS NULL) THEN '---' ELSE rc.first_name END) AS name_rep"),
            'states.description as state',
            'cities.description as city',
            'customers.municipality as municipality',
            'customers.address as address',
            'customers.postal_code',
            'customers.email',
            'customers.telephone',
            'customers.mobile',
            'customers.city_register',
            'customers.comercial_register',
            'customers.date_register',
            'customers.number_register',
            'customers.took_register',
            \DB::raw("(CASE WHEN (rc.id IS NULL) THEN '---' ELSE 'Si' END) AS representant"),
            'customers.file_document'
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

        $customers = $query->whereNull('customers.deleted_at')->distinct('customers.rif')->orderBy('customers.rif', 'ASC')->get();

        foreach ($customers as $key => $row) {
            $data[$key]['customer_id'] = $row['customer_id'];
            $data[$key]['profit_id'] = $row['profit_id'];
            $data[$key]['rif'] = $row['rif'];
            $data[$key]['business_name'] = $row['business_name'];
            $data[$key]['cactivity'] = $row['cactivity'];
            $data[$key]['type_cont'] = $row['type_cont'];
            $data[$key]['taxes'] = $row['taxes'];
            $data[$key]['document'] = $row['document'];
            $data[$key]['name_rep'] = $row['name_rep'];
            $data[$key]['state'] = $row['state'];
            $data[$key]['city'] = $row['city'];
            $data[$key]['municipality'] = $row['municipality'];
            $data[$key]['address'] = $row['address'];
            $data[$key]['postal_code'] = $row['postal_code'];
            $data[$key]['email'] = $row['email'];
            $data[$key]['telephone'] = $row['telephone'];
            $data[$key]['mobile'] = $row['mobile'];
            $data[$key]['city_register'] = $row['city_register'];
            $data[$key]['comercial_register'] = $row['comercial_register'];
            $data[$key]['date_register'] = $row['date_register'];
            $data[$key]['number_register'] = $row['number_register'];
            $data[$key]['took_register'] = $row['took_register'];
            $data[$key]['representant'] = $row['representant'];

            if ($row->file_document == null) {
                $data[$key]['document_rif'] = 'No';
                $data[$key]['document_mercantil'] = 'No';
                $data[$key]['document_bank'] = 'No';
                $data[$key]['auth_bank'] = 'No';

                $data[$key]['is_rif'] = 'No';
                $data[$key]['is_mercantil'] = 'No';
                $data[$key]['is_bank'] = 'No';
                $data[$key]['is_auth_bank'] = 'No';
            } else {
                $aditional = unserialize($row->file_document);
                $data[$key]['document_rif'] = array_key_exists('document_rif', $aditional) && $aditional['document_rif'] != '' ? 'Si' : 'No';
                $data[$key]['document_mercantil'] = array_key_exists('document_mercantil', $aditional) && $aditional['document_mercantil'] != '' ? 'Si' : 'No';
                $data[$key]['document_bank'] = array_key_exists('document_bank', $aditional) && $aditional['document_bank'] != '' ? 'Si' : 'No';
                $data[$key]['autorization_bank'] = array_key_exists('autorization_bank', $aditional) && $aditional['autorization_bank'] != '' ? 'Si' : 'No';

                $data[$key]['is_rif'] = array_key_exists('is_rif', $aditional) && $aditional['is_rif'] != '' ? 'Si' : 'No';
                $data[$key]['is_mercantil'] = array_key_exists('is_mercantil', $aditional) && $aditional['is_mercantil'] != '' ? 'Si' : 'No';
                $data[$key]['is_bank'] = array_key_exists('is_bank', $aditional) && $aditional['is_bank'] != '' ? 'Si' : 'No';
                $data[$key]['is_auth_bank'] = array_key_exists('is_auth_bank', $aditional) && $aditional['is_auth_bank'] != '' ? 'Si' : 'No';
            }
        }

        $this->cont = count($data) + 1;

        return Collect($data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'Código Cliente',
            'Código Profit',
            'RIF',
            'Nombre Comercio',
            'Actividad Comercial',
            'Contribuyente',
            'Valor',
            'Documento Representante',
            'Nombre Representante',
            'Estado',
            'Ciudad',
            'Municipalidad',
            'Dirección',
            'Cod. Postal',
            'Email',
            'Telefono',
            'Mobile',
            'Ciudad Registro',
            'Registro Mercantil',
            'Fecha Registro',
            'No.',
            'Tomo',
            'Representante',
            'Doc. RIF',
            'Doc. Mercantil',
            'Doc. Banco',
            'Doc. Débito',
            'Checklist RIF',
            'Checklist Mercant.',
            'Checklist Banco',
            'Checklist Débito',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:AE'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:AE1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:AE1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');

                $event->sheet->getDelegate()->getStyle('A1:AE'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:AE1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A2:C'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F2:H'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('J2:K'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('N2:N'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('P2:Q'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('T2:AE'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
