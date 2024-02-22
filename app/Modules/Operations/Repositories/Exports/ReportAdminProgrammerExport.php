<?php

namespace App\Modules\Operations\Repositories\Exports;

use App\Modules\Operations\Models\Order;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportAdminProgrammerExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    protected $data;

    /***************************************************************************/
    public function __construct($data)
    {
        $this->data = $data;
    }

    /***************************************************************************/
    public function array(): array
    {
        return $this->data;
    }

    /***************************************************************************/
    public function collection()
    {
        $request = $this->data;

        if (Auth::user()->other_bank == '[null]') {
            $bank = json_decode(Auth::user()->other_bank, true);
            $bank = implode(';', $bank);
        } else {
            $bank = json_decode(Auth::user()->other_bank, true);
        }

        $query = Order::query();

        $query->select('orders.id as order_id', 'dc.affiliate_number as affiliate_number', 'bk.description as bank', \DB::raw("SUBSTRING_INDEX(cs.rif, '-', 1) as indicator"), \DB::raw("SUBSTRING_INDEX(cs.rif, '-', -2) as indicator2"), 'cs.business_name', 'cactivities.description as cactivity', 'states.description as state', 'cities.description as city', 'cs.address', 'cs.email', 'cs.mobile', 'inv.tipnot', 'op.description as operator', \DB::raw("(CASE WHEN (sr.serial_sim IS NULL) THEN '----' ELSE CONCAT(' ', sr.serial_sim) END) as serial_sim"), \DB::raw(" (CASE WHEN (ct.company_id IS NULL) THEN '----' ELSE cp.description END) as company"), 'mt.description as modelterminal', \DB::raw(" (CASE WHEN (tm.serial IS NULL) THEN '----' ELSE tm.serial END) as serial_terminal"), \DB::raw(" (CASE WHEN (CONCAT(us.name,' ', us.last_name) IS NULL) THEN '----' ELSE CONCAT(us.name,' ', us.last_name) END) as user_name"), \DB::raw(" (CASE WHEN (CONCAT(cn.first_name,' ', cn.last_name) IS NULL) THEN '----' ELSE CONCAT(cn.first_name,' ', cn.last_name) END) as consultant_name"), 'inv.updated_at as updated_invoice', \DB::raw(" (CASE WHEN (orders.status = 'P' && ct.terminal_id IS NULL) THEN 'Programación Sin Gestión' WHEN (orders.status = 'P' && ct.terminal_id IS NOT NULL) THEN 'Programación Inicial' WHEN (orders.status = 'D') THEN 'Despacho' WHEN (orders.status = 'C') THEN 'Entregado Cliente' WHEN (orders.status = 'S') THEN 'Soporte' ELSE '----' END) as order_status"), \DB::raw(" (CASE WHEN (CONCAT(usr.name,' ', usr.last_name) IS NULL) THEN '----' ELSE CONCAT(usr.name,' ', usr.last_name) END) as programmer_user"), 'orders.created_at as created_at', 'orders.updated_at as updated_at')
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'ct.dcustomer_id')
            ->leftjoin('cactivities', 'cactivities.id', '=', 'cs.cactivity_id')
            ->leftjoin('users as us', 'us.id', '=', 'ct.user_created_id')
            ->leftjoin('consultants as cn', 'cn.id', '=', 'ct.consultant_id')
            ->leftjoin('users as usr', 'usr.id', '=', 'orders.programmer_user_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('operators as op', 'op.id', '=', 'ct.operator_id')
            ->leftjoin('terminals as tm', 'tm.id', '=', 'ct.terminal_id')
            ->leftjoin('simcards as sr', 'sr.id', '=', 'ct.simcard_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'ct.company_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'cs.city_id')
            ->leftjoin('invoices as inv', function ($join) {
                $join->on('inv.id', '=', 'orders.invoice_id');
                $join->whereNull('inv.deleted_at');
            });

        if ($request['company_id'] != null) {
            $query->where('ct.company_id', $request['company_id']);
        }

        if ($request['user_id'] != null) {
            $query->where('ct.user_created_id', $request['user_id']);
        }

        if ($request['type_date'] == 'month') {
            $query->where('orders.posted_at', 'LIKE', $request['date'].'-%');
        } elseif ($request['type_date'] == 'range') {
            $date = explode('|', $request['date_range']);
            $query->whereBetween('orders.posted_at', [$date[0], $date[1]]);
        }

        $data = $query->whereNull('orders.deleted_at')->orderBy('order_status', 'DESC')->orderBy('programmer_user', 'DESC')->orderBy('updated_at', 'ASC')->distinct('inv.tipnot')->get();

        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nro Afiliación',
            'Banco',
            '',
            'RIF',
            'Nombre Comercio',
            'Actividad',
            'Estado',
            'Ciudad',
            'Dirección',
            'Email',
            'Telefono',
            'Método Pago',
            'Operador',
            'Serial SIM',
            'Proveedor Terminal',
            'Modelo Terminal',
            'Serial Terminal',
            'Asesor Venta / Asistente Venta',
            'Aliado Comercial',
            'Fecha Conciliado',
            'Status',
            'Programador',
            'Creado',
            'Actualizado',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:Y'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:Y1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:Y1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');

                $event->sheet->getDelegate()->getStyle('A1:Y'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:Y1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:E'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('L1:Y'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
