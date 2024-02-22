<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Invoice;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CollectionServiceReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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

        $query = Invoice::query();

        $query->select(
            \DB::raw("LPAD(cs.id ,6,'0') as customer_id"),
            \DB::raw("(CASE WHEN (cs.foreign_id IS NULL) THEN '----' ELSE LPAD(cs.foreign_id ,6,'0') END) AS foreign_id"),
            'cs.business_name',
            'bk.description as bank',
            DB::raw("CONCAT(SUBSTRING(dc.account_number, 1, 4),LPAD(cs.foreign_id ,6,'0'),t.serial) AS account_number"),
            \DB::raw("LPAD(invoices.id ,6,'0') as invoice_id"),
            \DB::raw("DATE_FORMAT(invoices.fechpro, '%Y-%m-%d') AS fechpro_invoice"),
            'cl.fechpro',
            \DB::raw("LPAD(cl.id ,6,'0') as collection_id"),
            'cu.abrev as currency',
            'invoices.amount',
            'cl.amount_currency',
            \DB::raw("(CASE WHEN (cl.id IS NOT NULL) THEN (invoices.amount*cl.amount_currency) ELSE '----' END) AS total_amount"),
            \DB::raw("(SELECT COUNT(invoices.id) FROM invoices WHERE invoices.contract_id=ct.id  AND invoices.concept_id=2 AND invoices.status IN ('G','P','R') AND invoices.deleted_at IS NULL) AS count_invoice")
        )
            ->leftjoin('contracts as ct', function ($join) {
                $join->on('ct.id', '=', 'invoices.contract_id');
                $join->whereNull('ct.deleted_at');
            })
            ->leftjoin('customers as cs', function ($join) {
                $join->on('cs.id', '=', 'ct.customer_id');
                $join->whereNull('cs.deleted_at');
            })
            ->join('collections as cl', function ($join) {
                $join->on('cl.invoice_id', '=', 'invoices.id');
                $join->whereNull('cl.deleted_at');
            })
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'ct.dcustomer_id')
            ->leftjoin('banks as bk', 'bk.id', '=', 'dc.bank_id')
            ->leftjoin('terminals as t', 't.id', '=', 'ct.terminal_id')
            ->leftjoin('currencies as cu', 'cu.id', '=', 'cl.currency_id');

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('cl.fechpro', [$date[0].'%', $date[1].'%']);
            }
        }

        $data = $query->where('invoices.concept_id', 2)->orderBy('cl.fechpro', 'ASC')->get();

        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            'Código Cliente',
            'Código Profit',
            'Nombre Comercio',
            'Banco',
            'No. Cuenta Compuesta',
            'No. Cobro',
            'Fecha Cobro',
            'Fecha Pago',
            'No. Pago',
            'Divisa',
            'Monto',
            'Cambio Divisa',
            'Monto Bs.',
            'Mora Actual',
        ];
    }

    /**************************************************************************/
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

                $event->sheet->getDelegate()->getStyle('A1:N1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:N'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('I1:K'.$this->cont)->getNumberFormat()->setFormatCode('###0.00');
                $event->sheet->getDelegate()->getStyle('A1:B'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('D1:N'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
