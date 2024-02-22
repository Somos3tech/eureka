<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Operterminal;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class OperterminalReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    protected $data;

    /**************************************************************************/
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
        $query = Operterminal::query();

        $query->select(
            'operterminals.fechpro',
            DB::raw("LPAD(cs.id ,6,'0') as customer_id"),
            'cs.rif',
            'cs.business_name',
            DB::raw("LPAD(ct.id ,6,'0') as contract_id"),
            DB::raw("CONCAT(SUBSTRING(dc.account_number, 1, 4),LPAD(ct.id ,6,'0'),t.serial) AS account_number"),
            DB::raw('SUBSTRING(dc.account_number, 1, 4) AS code_bank'),
            \DB::raw("(CASE WHEN (operterminals.type_operation='activacion') THEN 'Activación' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='definitivo') THEN 'Cancelación' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='temporal') THEN 'Suspensión' WHEN (operterminals.type_operation='cambio') THEN 'Cambio Plan' ELSE '----' END) as type"),
            DB::raw("(CASE WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='definitivo') THEN 'Definitivo' WHEN (operterminals.type_operation='suspension' AND operterminals.type_service='temporal') THEN 'Temporal' ELSE '----' END) as type_operation"),
            \DB::raw("(CASE WHEN (operterminals.serial_terminal IS NULL) THEN '----'  ELSE operterminals.serial_terminal  END) as serial_terminal"),
            DB::raw("(CASE WHEN (trm.abrev IS NULL) THEN '----'  ELSE trm.abrev END) as term_change"),
            DB::raw("(CASE WHEN (operterminals.term_name IS NULL) THEN '----'  ELSE operterminals.term_name END) AS term_name"),
            DB::raw("(CASE WHEN (terms.abrev IS NULL) THEN '----'  ELSE terms.abrev END) as term_abrev"),
            \DB::raw("(CASE WHEN (operterminals.date_inactive IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.date_inactive, '%d-%m-%Y') END) as inactive"),
            DB::raw("(CASE WHEN (operterminals.date_reactive IS NULL) THEN '----'  ELSE DATE_FORMAT(operterminals.date_reactive, '%d-%m-%Y') END) as reactive"),
            'operterminals.observations',
            'ct.status as status_contract',
            \DB::raw("(CASE WHEN (CONCAT(us.name,' ', us.last_name) IS NULL) THEN '----' ELSE CONCAT(us.name,' ', us.last_name) END) as created_name")
        )
            ->leftjoin('contracts as ct', 'ct.id', '=', 'operterminals.contract_id')
            ->leftjoin('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'ct.dcustomer_id')
            ->leftjoin('terminals as t', 't.id', '=', 'ct.terminal_id')
            ->leftjoin('terms as trm', 'trm.id', '=', 'operterminals.term_id')
            ->leftjoin('terms', 'terms.id', '=', 'ct.term_id')
            ->leftjoin('users as us', 'us.id', '=', 'operterminals.user_created_id')
            ->leftjoin('users', 'users.id', '=', 'operterminals.user_updated_id');

        if ($request->has('status')) {
            $query->where('operterminals.status', 'LIKE', $request['statusc']);
        }

        if ($request->has('type_operation')) {
            $query->where('operterminals.type_operation', 'LIKE', $request['type_operation']);
        }

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('operterminals.fechpro', [$date[0].'%', $date[1].'%']);
            }
        }
        $data = $query->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'Fecha Operación',
            'Código',
            'RIF',
            'Nombre Comercio',
            'No. Contrato',
            'Cuenta',
            'Código Bancario',
            'Operación',
            'Tipo',
            'Serial Terminal',
            'Plan A Cambiar',
            'Plan Actual',
            'Plan Activo',
            'Suspensión',
            'Reactivación',
            'Observaciones',
            'Status Servicio',
            'Creado Por',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:R'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A1:R1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:R'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:C'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:O'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Q1:R'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
