<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Contract;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BusinessSalesReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents, WithColumnFormatting, WithMapping
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

        $query->select(
            \DB::raw("LPAD(cs.id ,6,'0') as customer_id"), // Codigo Cliente
            \DB::raw(" (CASE WHEN (LPAD(cs.foreign_id ,6,'0') IS NULL) THEN '----' ELSE LPAD(cs.foreign_id,6,'0') END) as foreign_id"), //Codigo Profit
            \DB::raw("LPAD(contracts.id ,6,'0') as contract_id"), // Numero Contrato
            \DB::raw(" (CASE WHEN (contracts.company_id IS NULL) THEN '----' ELSE cm.description END) as company"), //almacen
            \DB::raw(' contracts.created_at as created_contract'), //Fecha Contrato
            'bk.description as bank', //Banco
            \DB::raw(" (CASE WHEN (dc.personal_signature IS NULL) THEN 'Persona Natural - RIF' WHEN (dc.personal_signature = 0) THEN 'Persona Natural - RIF' ELSE 'Firma Personal' END) as personal_signature"), //Tipo de registro
            \DB::raw(" (CASE WHEN (cs.type_cont IS NULL) THEN '----' WHEN (cs.type_cont = 2) THEN CONCAT('Especial') ELSE CONCAT('Ordinario') END) as contribuyente"), //Tipo de Contribuyente
            'cs.business_name', //nombre comercio
            \DB::raw(" (CASE WHEN (CONCAT(cons.first_name,' ', cons.last_name) IS NULL) THEN '----'  ELSE CONCAT(cons.first_name,' ', cons.last_name) END) as consultant"), //Aliado Comercial
            \DB::raw("CONCAT(usr.name,' ', usr.last_name) as asesor"), //Asesor de Venta
            'usr.jobtitle', //Canal de Ventas / Cargo de Vendedor
            'states.description as state', //Estado
            'cities.description as city', //Ciudad
            'cact.description as activity', //Actividad Comercial
            \DB::raw("CONCAT(terms.abrev,'-',terms.description) as tarifa"), // Tarifa
            'inv.tipnot', //Metodo de Pago
            'cu.abrev as currency', //Divisa
            'inv.amount', // Monto
            \DB::raw(" (CASE WHEN (inv.amount_currency IS NULL) THEN '----' ELSE  FORMAT(inv.amount_currency,2) END) as amount_currency"), //Tarifa Cambio
            \DB::raw('(CASE WHEN (inv.currency_id = 1) THEN FORMAT(inv.amount,2) ELSE FORMAT((inv.amount * inv.amount_currency),2) END) as amount_total'), //Total
            \DB::raw(' inv.updated_at as updated_invoice'), //Fecha Conciliación
            \DB::raw(" (CASE WHEN (inv.status = 'P') THEN 'Por Pagar' WHEN (inv.status = 'C') THEN 'Conciliado' WHEN (inv.status = 'G') THEN 'Sin Conciliar' ELSE '----' END) as status_invoice"), // Status Conciliación
            'mt.description as modelterminal', //Modelo Terminal
            'op.description as operator', //Operadora
            \DB::raw(' or.programmer_at as programmer_date'), // Fecha de Programación
            \DB::raw(' or.posted_at as posted_date'), // Fecha de Entrega
            \DB::raw(" (CASE WHEN (or.status = 'P') THEN 'En Programación' WHEN (or.status = 'PF') THEN 'Programación - Finalizada' WHEN (or.status = 'A') THEN 'Almacén - Por Facturar' WHEN (or.status = 'F') THEN 'Almacén - Facturado' WHEN (or.status = 'D') THEN 'En Despacho' WHEN (or.status = 'C') THEN 'Entregado Cliente' ELSE '----' END) as order_status"),
            'contracts.status as contract_status'
        )
            ->leftjoin('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('cactivities as cact', 'cact.id', '=', 'cs.cactivity_id')
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')->leftjoin('cities', 'cities.id', '=', 'cs.city_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('invoices as inv', function ($join) {
                $join->on('inv.contract_id', '=', 'contracts.id');
                $join->where('inv.concept_id', 1);
                $join->whereNull('inv.deleted_at');
            })
            ->leftjoin('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'contracts.id');
                $join->whereNull('or.deleted_at');
            })
            ->leftjoin('users as us', 'us.id', '=', 'inv.user_updated_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('operators as op', 'op.id', '=', 'contracts.operator_id')
            ->leftjoin('users as usr', 'usr.id', '=', 'contracts.user_created_id')
            ->leftjoin('users as user', 'user.id', '=', 'or.user_updated_id')
            ->leftjoin('users as userp', 'userp.id', '=', 'or.programmer_user_id')
            ->leftjoin('users as usero', 'usero.id', '=', 'or.posted_user_id')
            ->leftjoin('consultants as cons', 'cons.id', '=', 'contracts.consultant_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('concepts as cp', 'cp.id', '=', 'inv.concept_id')
            ->leftjoin('companies as cm', 'cm.id', '=', 'contracts.company_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->leftjoin('comissions as com', 'com.id', '=', 'terms.comission_id')
            ->leftjoin('currencies as cu', 'cu.id', '=', 'inv.currency_id');

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

        if ($request['bank_id'] != '') {
            $query->where('dc.bank_id', '=', $request['bank_id']);
        }

        $data = $query->orderBy('contract_id', 'ASC')->whereNull('cs.deleted_at')->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    public function map($row): array
    {
        if ($row->created_contract == null) {
            $row->created_contract = 0;
        }
        if ($row->updated_invoice == null) {
            $row->updated_invoice = 0;
        }
        if ($row->programmer_date == null) {
            $row->programmer_date = 0;
        }
        if ($row->posted_date == null) {
            $row->posted_date = 0;
        }

        return [
            $row->customer_id,
            $row->foreign_id,
            $row->contract_id,
            $row->company,
            Date::dateTimeToExcel(Carbon::parse($row->created_contract)),
            $row->bank,
            $row->personal_signature,
            $row->contribuyente,
            $row->business_name,
            $row->asesor,
            $row->consultant,
            $row->jobtitle,
            $row->state,
            $row->city,
            $row->activity,
            $row->tarifa,
            $row->tipnot,
            $row->currency,
            $row->amount,
            $row->amount_currency,
            $row->amount_total,
            Date::dateTimeToExcel(Carbon::parse($row->updated_invoice)),
            $row->status_invoice,
            $row->modelterminal,
            $row->operator,
            Date::dateTimeToExcel(Carbon::parse($row->programmer_date)),
            Date::dateTimeToExcel(Carbon::parse($row->posted_date)),
            $row->order_status,
            $row->contract_status,
        ];
    }

    public function headings(): array
    {
        return [
            'Código',
            'Código Profit',
            '# Contrato',
            'Almacén Venta',
            'Fecha Contrato',
            'Banco',
            'Tipo de Registro',
            'Tipo de Contribuyente',
            'Nombre Comercio',
            'Persona de Carga',
            'Vendedor',
            'Canal Venta',
            'Estado',
            'Ciudad',
            'Actividad Comercial',
            'Tarifa',
            'Método Pago',
            'Divisa',
            'Monto',
            'Tarifa Cambio',
            'Total',
            'Fecha Conciliación',
            'Status Conciliación',
            'Modelo Terminal',
            'Operadora',
            'Fecha Programación',
            'Fecha Entrega',
            'Status Venta',
            'Status Servicio',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'V' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Z' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'AA' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:AC'.$this->cont; // All headers
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
                $event->sheet->getDelegate()->getStyle('A1:AC1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:AC1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:AC'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:I'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('L1:O'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Q1:AC'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
