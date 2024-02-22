<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SalesReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
            \DB::raw("cs.id as customer_id"),
            \DB::raw(" (CASE WHEN (LPAD(cs.foreign_id ,6,'0') IS NULL) THEN '----' ELSE LPAD(cs.foreign_id,6,'0') END) as foreign_id"),
            \DB::raw("LPAD(contracts.id ,6,'0') as contract_id"),
            \DB::raw(" (CASE WHEN (contracts.company_id IS NULL) THEN '----' ELSE cm.description END) as company"),
            \DB::raw('DATE_FORMAT(contracts.created_at, "%Y-%m-%d") as created_contract'),
            \DB::raw(" (CASE WHEN (dc.affiliate_number IS NULL) THEN '----' ELSE dc.affiliate_number END) as affiliate_number"),
            'dc.account_number',
            'bk.description as bank',
            'cs.rif',
            'states.description AS estado',
            'cities.description AS ciudad',
            'cs.municipality',
            'cs.address',
            \DB::raw(" (CASE WHEN (dc.personal_signature IS NULL) THEN 'Persona Natural - RIF' WHEN (dc.personal_signature = 0) THEN 'Persona Natural - RIF' ELSE 'Firma Personal' END) as personal_signature"),
            'cs.business_name',
            \DB::raw("CONCAT(usr.name,' ', usr.last_name) as asesor"),
            \DB::raw(" (CASE WHEN (CONCAT(cons.first_name,' ', cons.last_name) IS NULL) THEN '----'  ELSE CONCAT(cons.first_name,' ', cons.last_name) END) as consultant"),
            'usr.jobtitle',
            \DB::raw("CONCAT(terms.abrev,'-',terms.description)"),
            \DB::raw(" (CASE WHEN (contracts.observation IS NULL) THEN '----' ELSE contracts.observation END) as obs_contract"),
            'inv.id',
            'inv.tipnot',
            'cu.abrev as currency',
            'inv.amount',
            // Descuento
            // \DB::raw(" (CASE WHEN (inv.free IS NULL) THEN '----' ELSE inv.free END) as free"),
            \DB::raw(" (CASE WHEN (inv.amount_currency IS NULL) THEN '----' ELSE  FORMAT(inv.amount_currency,2) END) as amount_currency"),
            \DB::raw('(CASE WHEN (inv.currency_id = 1) THEN FORMAT(inv.amount,2) ELSE FORMAT((inv.amount * inv.amount_currency),2) END) as amount_total'),
            // Total Descuento
            // \DB::raw(" (CASE WHEN (inv.currency_id = 1) THEN FORMAT((inv.amount-inv.free),2) ELSE FORMAT(((inv.amount * inv.amount_currency)-inv.free),2) END) as amount_total_free"),
            \DB::raw(" (CASE WHEN (inv.status != 'C' AND inv.status != 'P') THEN '----'  ELSE DATE_FORMAT(inv.updated_at, '%Y-%m-%d') END) as updated_invoice"),
            \DB::raw(" (CASE WHEN (inv.status = 'P') THEN 'Por Pagar' WHEN (inv.status = 'C') THEN 'Conciliado' WHEN (inv.status = 'G') THEN 'Sin Conciliar' ELSE '----' END) as status_invoice"),
            \DB::raw(" (CASE WHEN (inv.status != 'C' AND inv.status != 'P') THEN '----'  ELSE CONCAT(us.name,' ', us.last_name) END) as name"),
            'mt.description as modelterminal',
            \DB::raw(" (CASE WHEN (t.serial IS NULL) THEN '----' ELSE t.serial END) as serial"),
            \DB::raw(" (CASE WHEN (contracts.nropos IS NULL) THEN '----' ELSE contracts.nropos END) as nropos"),
            'op.description as operator',
            \DB::raw(" (CASE WHEN (contracts.simcard_id IS NULL) THEN '----' ELSE CONCAT(' ', s.serial_sim) END) as serial_sim"),
            \DB::raw(" (CASE WHEN (CONCAT(userp.name,' ', userp.last_name) IS NULL) THEN '----' ELSE CONCAT(userp.name,' ', userp.last_name) END) as programmer"),
            \DB::raw(" (CASE WHEN (or.programmer_at IS NULL) THEN '----' ELSE DATE_FORMAT(or.programmer_at, '%Y-%m-%d') END) as programmer_date"),
            \DB::raw(" (CASE WHEN (CONCAT(usero.name,' ', usero.last_name) IS NULL) THEN '----'  ELSE CONCAT(usero.name,' ', usero.last_name) END) as nameo"),
            \DB::raw(" (CASE WHEN (or.posted_at IS NULL) THEN '----' ELSE DATE_FORMAT(or.posted_at, '%Y-%m-%d') END) as posted_date"),
            \DB::raw(" (CASE WHEN (or.status = 'P') THEN 'En Programación' WHEN (or.status = 'PF') THEN 'Programación - Finalizada' WHEN (or.status = 'A') THEN 'Almacén - Por Facturar' WHEN (or.status = 'F') THEN 'Almacén - Facturado' WHEN (or.status = 'D') THEN 'En Despacho' WHEN (or.status = 'C') THEN 'Entregado Cliente' ELSE '----' END) as order_status"),
            'contracts.status as contract_status'
        )
            ->leftjoin('customers as cs', 'cs.id', '=', 'contracts.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('invoices as inv', function ($join) {
                $join->on('inv.contract_id', '=', 'contracts.id');
                $join->where('inv.concept_id', 1);
                //	$join->whereIn('inv.tipnot',['Efectivo','Transferencia','Deposito','DTE','Convenio','Postpago','Estandar','Financiamiento','Custodia']);
                $join->whereNull('inv.deleted_at');
            })
            ->leftjoin('orders as or', function ($join) {
                $join->on('or.contract_id', '=', 'contracts.id');
                $join->whereNull('or.deleted_at');
            })
            ->leftjoin('users as us', 'us.id', '=', 'inv.user_updated_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'contracts.modelterminal_id')
            ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
            ->leftjoin('simcards as s', 's.id', '=', 'contracts.simcard_id')
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
            ->leftjoin('currencies as cu', 'cu.id', '=', 'inv.currency_id')
            ->leftjoin('states as states', 'cs.state_id', '=', 'states.id')
            ->leftjoin('cities as cities', 'cs.city_id', '=', 'cities.id');

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
                $query->whereBetween('contracts.created_at', [$date[0] . '%', $date[1] . '%']);
            }
        }

        if ($request['bank_id'] != '') {
            $query->where('dc.bank_id', '=', $request['bank_id']);
        }

        $data = $query->orderBy('contract_id', 'ASC')->whereNull('cs.deleted_at')->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            'Código',
            'Código Profit',
            '# Contrato',
            'Almacén Venta',
            'Fecha Contrato',
            'Nro. Afiliacion',
            'No. Cuenta',
            'Banco',
            'RIF',
            'Estado',
            'Ciudad',
            'Municipio',
            'Direccion',
            'Tipo de Registro',
            'Nombre Comercio',
            'Asesor Venta',
            'Aliado Comercial',
            'Cargo Vendedor',
            'Tarifa',
            'Observaciones Venta',
            'No. Cobro',
            'Método Pago',
            'Divisa',
            'Monto',
            // 'Descuento',
            'Tarifa Cambio',
            'Total',
            //'Total (Descuento)',
            'Fecha Conciliación',
            'Status Conciliación',
            'Usuario Conciliación',
            'Modelo Terminal',
            'Serial Terminal',
            'No. Terminal',
            'Operador',
            'Serial SIM',
            'Usuario Programador',
            'Fecha Programación',
            'Usuario Entrega',
            'Fecha Entrega',
            'Status Venta',
            'Status Servicio',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:AN' . $this->cont; // All headers
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

                $event->sheet->getDelegate()->getStyle('A1:AN1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:AN1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:AN' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:I' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('L1:O' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Q1:AN' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
