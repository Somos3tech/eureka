<?php

namespace App\Modules\Operations\Repositories\Exports;

use App\Modules\Operations\Models\Order;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportCredicardExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    public function collection()
    {
        $q = Order::query();

        $q->select(
            'orders.id as order_id',
            'bk.description as bank',
            'mt.description as modelterminal',
            \DB::raw(" (CASE WHEN (orders.canceledOrder_id IS NULL) THEN 'GPRS' ELSE 'GPRS' END) as grps"),
            'op.description as operator',
            'cp.description as almacen',
            \DB::raw(" (CASE WHEN (tm.serial IS NULL) THEN '----' ELSE tm.serial END) as serial_terminal"),
            'cs.business_name',
            'dc.affiliate_number',
            \DB::raw(" (CASE WHEN (orders.canceledOrder_id IS NULL) THEN  '' ELSE '' END) as nroterm"),
            'cs.rif',
            \DB::raw(" (CASE WHEN (orders.canceledOrder_id IS NULL) THEN '' ELSE '' END) as nroterm"),
            \DB::raw(" (CASE WHEN (orders.canceledOrder_id IS NULL) THEN '' ELSE '' END) as version"),
            \DB::raw(" (CASE WHEN (orders.canceledOrder_id IS NULL) THEN 'INSTALACION' ELSE 'INSTALACION' END) as manager"),
            \DB::raw(" (CASE WHEN (orders.canceledOrder_id IS NULL) THEN '' ELSE '' END) as observation"),
            'cs.telephone',
            'cs.email'
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'ct.dcustomer_id')
            ->leftjoin('users as usr', 'usr.id', '=', 'orders.programmer_user_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('operators as op', 'op.id', '=', 'ct.operator_id')
            ->leftjoin('terminals as tm', 'tm.id', '=', 'ct.terminal_id')
            ->leftjoin('simcards as sr', 'sr.id', '=', 'ct.simcard_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'ct.company_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('invoices as inv', function ($join) {
                $join->on('inv.id', '=', 'orders.invoice_id');
                $join->whereNull('inv.deleted_at');
            })
            ->whereIn('orders.status', ['P']);

        if (Auth::user()->company_id != null) {
            $q->where('ct.company_id', Auth::user()->company_id);
        }
        if (Auth::user()->banklist != null) {
            $q->whereIn('dc.bank_id', json_decode(Auth::user()->banklist, true));
        }

        $data = $q->whereNull('orders.credicard')->orderBy('orders.id', 'ASC')->whereNull('orders.deleted_at')->distinct('inv.tipnot')->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            '#',
            'Banco',
            'Modelo POS',
            'Tipo Comunicación',
            'Operadora',
            'Almacen',
            'Serial Entrante',
            'Nombre Comercio',
            'Afiliado',
            'No. term.',
            'Rif',
            'Simcard',
            'Tipo de Gestión',
            'Observaciones',
            'Telefono',
            'Correo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:P' . $this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri')->setSize(11);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:P1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('736941');

                $event->sheet->getDelegate()->getStyle('A1:P' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:P1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:P' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
