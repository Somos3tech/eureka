<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CollectionReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
            //\DB::raw("LPAD(invoices.id ,12,'0') as invoice_id"),
            \DB::raw("invoices.id as invoice_id"),
            \DB::raw("(CASE WHEN (cl.invoiceitem_id IS NOT NULL) THEN LPAD(cl.invoiceitem_id ,6,'0') ELSE '----' END) as invoiceitem_id"),
            'cs.rif',
            'cs.business_name',
            \DB::raw(" (CASE WHEN (dc.affiliate_number IS NULL) THEN '----' ELSE dc.affiliate_number END) as affiliate_number"),
            \DB::raw("LPAD(ct.id ,6,'0') as contract_id"),
            \DB::raw(" (CASE WHEN (ct.company_id IS NULL) THEN '-----' ELSE cp.description END) as company"),
            'mt.description as modelterminal',
            \DB::raw(" (CASE WHEN (ct.observation IS NULL) THEN '----' ELSE ct.observation END) as obs_contract"),
            \DB::raw('DATE_FORMAT(ct.created_at, "%Y-%m-%d") as created_contract'),
            \DB::raw("CONCAT(user.name,' ', user.last_name) as asesor"),
            'invoices.tipnot',
            'cu.abrev as currency',
            'invoices.amount as amount_invoice',
            \DB::raw(" (CASE WHEN (invoices.free IS NULL) THEN '----' ELSE invoices.free END) as free"),
            \DB::raw(" (CASE WHEN (invoices.amount_currency IS NULL) THEN '----' ELSE invoices.amount_currency END) as amount_currency"),
            \DB::raw(' (CASE WHEN (invoices.currency_id = 1) THEN invoices.amount ELSE (invoices.amount * invoices.amount_currency) END) as amount_total'),
            \DB::raw(' (CASE WHEN (invoices.currency_id = 1) THEN (invoices.amount-invoices.free) ELSE ((invoices.amount * invoices.amount_currency)-invoices.free) END) as amount_total_free'),
            \DB::raw("cl.id as collection_id"),
            'cl.fechpro',
            'ac.name as acconcept',
            \DB::raw("CONCAT(' ',cl.refere) as refere"),
            'cu2.abrev as currency_collect',
            \DB::raw("(CASE WHEN (invoices.currency_id = 1) THEN '0,00' ELSE (cl.amount/cl.amount_currency) END) as dicom"),
            \DB::raw("(CASE WHEN (cl.amount_currency IS NULL) THEN '0,00' ELSE cl.amount_currency END) as amount_currency_collection"),
            'cl.amount as amount_collect',
            'cl.description as description_collect',
            \DB::raw(" (CASE WHEN (invoices.status = 'P') THEN 'Por Pagar' WHEN (invoices.status = 'C') THEN 'Conciliado' WHEN (invoices.status = 'G') THEN 'Sin Conciliar' ELSE '----' END) as status_invoice"),
            \DB::raw(" (CASE WHEN (CONCAT(us.name,' ', us.last_name) IS NULL) THEN '----'  ELSE CONCAT(us.name,' ', us.last_name) END) as name")
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
            ->leftjoin('acconcepts as ac', 'ac.id', '=', 'cl.acconcept_id')
            ->leftjoin('modelterminal as mt', 'mt.id', '=', 'ct.modelterminal_id')
            ->leftjoin('companies as cp', 'cp.id', '=', 'ct.company_id')
            ->leftjoin('currencies as cu', 'cu.id', '=', 'invoices.currency_id')
            ->leftjoin('currencies as cu2', 'cu2.id', '=', 'cl.currency_id')
            ->leftjoin('users as user', 'user.id', '=', 'ct.user_created_id')
            ->leftjoin('users as us', 'us.id', '=', 'invoices.user_updated_id');

        if ($request['company_id'] != '') {
            $query->where('ct.company_id', '=', $request['company_id']);
        }

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('cl.fechpro', [$date[0] . '%', $date[1] . '%']);
            }
        }

        $data = $query->where('invoices.concept_id', 1)->orderBy('receipt_journey', 'ASC')->get();

        $this->cont = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return [
            'No. Cobro',
            'No.Item Cobro',
            'RIF',
            'Nombre Comercio',
            'Nro. Afiliacion',
            'No. Contrato',
            'Almacén Venta',
            'Modelo Terminal',
            'Observaciones Venta',
            'Fecha Venta',
            'Asesor Venta',
            'Método Pago',
            'Divisa',
            'Monto',
            'Descuento',
            'Tasa Cambio',
            'Total (Descuento)',
            'Total',
            'No. Pago',
            'Fecha Pago',
            'Cuenta Contable',
            'Referencia Pago',
            'Divisa',
            'Tasa Cambio',
            'Monto Divisa',
            'Monto Pago',
            'Observación Pago',
            'Status Cobro',
            'Conciliado Por',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:AC' . $this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A1:AC1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:AC1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:AC' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('N1:R' . $this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->getDelegate()->getStyle('X1:Z' . $this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->getDelegate()->getStyle('A1:C' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:H' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('J1:T' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('W1:AC' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
