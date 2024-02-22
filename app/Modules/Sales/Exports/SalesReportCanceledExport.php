<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SalesReportCanceledExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
        $request = $this->data;
        $query = Contract::query();

        $table = 'cs.';

        $query->select(
            \DB::raw("LPAD(cs.id ,6,'0') as customer_id"),
            \DB::raw("LPAD(contracts.id ,6,'0') as contract_id"),
            \DB::raw(" (CASE WHEN (contracts.company_id IS NULL) THEN '----' ELSE cm.description END) as company"),
            \DB::raw('DATE_FORMAT(contracts.created_at, "%Y-%m-%d") as created_contract'),
            \DB::raw(" (CASE WHEN (dc.affiliate_number IS NULL) THEN '----' ELSE dc.affiliate_number END) as affiliate_number"),
            'dc.account_number',
            'bk.description as bank',
            'cs.rif',
            'cs.business_name',
            \DB::raw("CONCAT(usr.name,' ', usr.last_name) as asesor"),
            \DB::raw(" (CASE WHEN (CONCAT(cons.first_name,' ', cons.last_name) IS NULL) THEN '----'  ELSE CONCAT(cons.first_name,' ', cons.last_name) END) as consultant"),
            'usr.jobtitle',
            \DB::raw("CONCAT(terms.abrev,'-',terms.description)"),
            \DB::raw(" (CASE WHEN (terms.type_conditions='Tarifa' AND terms.type_conditions1='Fijo') THEN CONCAT('$ ',terms.comission_flatrate)  WHEN (terms.type_conditions='Porcentaje' AND terms.type_conditions1='Fijo') THEN CONCAT(terms.comission_percentage,' %') WHEN (com.type_conditions='Porcentaje') THEN CONCAT(com.value1,'-',com.value2,'-',com.value3,'-',com.value4,'-',com.value5,' %') WHEN (com.type_conditions='Tarifa') THEN CONCAT('$' , com.value1,'-',com.value2,'-',com.value3,'-',com.value4,'-',com.value5) ELSE '----' END) as rate_term"),
            \DB::raw(" (CASE WHEN (contracts.observation IS NULL) THEN '----' ELSE contracts.observation END) as obs_contract"),
            'contracts.status as status_contract'
        )
            ->leftjoin('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('simcards as s', 's.id', '=', 'contracts.simcard_id')
            ->leftjoin('operators as op', 'op.id', '=', 'contracts.operator_id')
            ->leftjoin('users as usr', 'usr.id', '=', 'contracts.user_created_id')
            ->leftjoin('consultants as cons', 'cons.id', '=', 'contracts.consultant_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('companies as cm', 'cm.id', '=', 'contracts.company_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->leftjoin('comissions as com', 'com.id', '=', 'terms.comission_id');

        if ($request['user_id'] != '') {
            $query->where('contracts.user_created_id', '=', $request['user_id']);
        }

        if ($request['consultant_id'] != '') {
            $query->where('contracts.consultant_id', '=', $request['consultant_id']);
        }

        if ($request['company_id'] != '') {
            $query->where('contracts.company_id', '=', $request['company_id']);
        }

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('contracts.created_at', [$date[0].'%', $date[1].'%']);
            }
        }

        if ($request['field'] != null) {
            $count = count($request['field']);

            for ($i = 0; $i < $count; $i++) {
                if ($request['field'][$i] != null && $request['query'][$i] != null) {
                    if ($request['operator'][$i] != null) {
                        $operator = $request['operator'][$i];
                    } else {
                        $operator = '=';
                    }

                    if ($i == 0) {
                        $query->where($table.$request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    } else {
                        if ($cond == 'AND' || $cond == '') {
                            $query->where($table.$request['field'][$i], $operator, $request['query'][$i]);
                            $cond = $request['conditional'][$i];
                        } else {
                            $query->OrWhere($table.$request['field'][$i], $operator, $request['query'][$i]);
                            $cond = $request['conditional'][$i];
                        }
                    }
                }
            }
        }

        $data = $query->orderBy('contract_id', 'ASC')->where('contracts.status', 'LIKE', 'Anulado')->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            'Código',
            '# Contrato',
            'Almacén Venta',
            'Fecha Contrato',
            'Nro. Afiliacion',
            'No. Cuenta',
            'Banco',
            'RIF',
            'Nombre Comercio',
            'Asesor Venta',
            'Aliado Comercial',
            'Cargo Vendedor',
            'Tarifa',
            'Monto',
            'Observaciones Venta',
            'Status Servicio',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:P'.$this->cont; // All headers
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

                $event->sheet->getDelegate()->getStyle('A1:P1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:P'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:H'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('J1:N'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
