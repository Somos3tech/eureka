<?php

namespace App\Modules\Operations\Repositories\Exports;

use App\Modules\Operations\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportOfficeExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
        $query = Order::query();

        $query->select(
            // 'orders.id as order_id',
            // \DB::raw("(CASE WHEN (orders.status='D') THEN 'Despacho' ELSE 'Entregado Cliente' END) as order_status"),
            // 'cp.description as company',
            // 'orders.contract_id',
            // 'cs.id as customer_id',
            'cs.business_name',
            'cs.rif',
            \DB::raw(" (CASE WHEN (t.serial IS NULL) THEN '----' ELSE t.serial END) as serial_terminal"),
            'states.description as state',
            'rc.first_name',
            'rc.document',
            'cs.mobile',
            \DB::raw("CONCAT(us.name,' ',us.last_name) as user_created"),
            // 'cs.address',
            // 'cs.email',
            // 'bk.description as bank',
            // 'mt.description as modelterminal',
            // 'ct.nropos',
            'ct.observation',
            'orders.programmer_finish_at',
            // \DB::raw("CONCAT(usp.name,'',usp.last_name) as user_programmer"),
            'orders.type_posted',
            'orders.date_send',
            'orders.number_control',
            'orders.observ_posted',
            'orders.posted_at'
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'orders.contract_id');
                $join->whereNull('ct.deleted_at');
                $join->limit(1);
            })
            ->leftjoin('customers as cs', 'cs.id', '=', 'ct.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'ct.dcustomer_id')
            ->leftjoin('rcustomers as rc', function ($join) {
                $join->on('rc.customer_id', '=', 'cs.id');
                $join->whereNull('rc.deleted_at');
            })
            ->leftjoin('users as us', 'us.id', '=', 'ct.user_created_id')
            ->leftjoin('users as usp', 'usp.id', '=', 'orders.programmer_user_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('terminals as t', 't.id', '=', 'ct.terminal_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'ct.company_id')
            ->leftjoin('states', 'states.id', '=', 'cs.state_id')
            ->whereIn('orders.status', ['D', 'C']);

        if ($request['company_id'] != null) {
            $query->where('ct.company_id', $request['company_id']);
        }

        if ($request['user_id'] != null) {
            $query->where('ct.user_created_id', $request['user_id']);
        }

        if ($request['orderstatus'] == 'Despacho') {
            $query->where('orders.status', 'D');
        } elseif ($request['orderstatus'] == 'Entregado') {
            $query->whereNotIn('orders.status', ['D']);
        }

        if ($request['type_posted'] != null) {
            $query->where('orders.type_posted', $request['type_posted']);
        }

        if ($request['type_date'] == 'month') {
            $query->where('orders.posted_at', 'LIKE', $request['date'].'-%');
        } elseif ($request['type_date'] == 'range') {
            $date = explode('|', $request['date_range']);
            $query->whereBetween('orders.posted_at', [$date[0], $date[1]]);
        }

        $data = $query->orderBy('orders.id', 'DESC')->get();
        $this->cont = count($data) + 1;

        return $data;
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            // 'No. Orden',
            // 'Status',
            // 'Compañia /Almacén',
            // 'No. Contrato',
            // 'Código',
            'Nombre Comercio',
            'RIF',
            'Serial Equipo',
            'Estado',
            'Nombre Representante',
            'Ident. Representante',
            'Móvil',
            'Asesor Venta',
            'Observaciones Venta',
            'Fecha Programación',
            // 'Dirección',
            // 'Email',
            // 'Banco',
            // 'Modelo Equipo',
            // 'No. Terminal',
            // 'Programado Por',
            'Tipo Entrega',
            'Fecha Envio',
            'No. Control',
            'Observación Entrega',
            'Fecha Entrega',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:O'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:O1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');

                $event->sheet->getDelegate()->getStyle('A1:O'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:I'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('J1:O'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
