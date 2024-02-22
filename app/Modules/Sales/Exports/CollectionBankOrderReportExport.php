<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CollectionBankOrderReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    protected $data;

    public $cont;

    public function __construct($data, $request)
    {
        $this->data = $data;
        $this->request = $request;
    }

    /**************************************************************************/
    public function array(): array
    {
        return $this->data;
    }

    /**************************************************************************/
    public function collection()
    {
        $data = [];
        $consec = 0;
        $array = $this->data;
        $request = $this->request;
        foreach ($array as $key => $value) {
            $customer = unserialize($value['data']);
            $collection = Invoice::select(
                'invoices.id as invoice_id',
                'invoices.fechpro',
                'invoices.rif',
                'invoices.business_name',
                'contracts.id as contract_id',
                'banks.description as bank',
                'dc.affiliate_number',
                'contracts.nropos',
                'collections.id as collection_id',
                'collections.fechpro as fechpro_collection',
                'collections.amount'
            )
                ->leftjoin('consecutives', 'consecutives.invoice_id', '=', 'invoices.id')
                ->leftjoin('collections', 'collections.invoice_id', '=', 'invoices.id')
                ->leftjoin('contracts', 'contracts.id', '=', 'invoices.contract_id')
                ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
                ->leftjoin('banks', 'banks.id', '=', 'dc.bank_id')
                ->where('consecutives.consecutive', 'LIKE', (int) $value['refere'])
                ->where('consecutives.bank_id', 'LIKE', (int) $request['bank_id'])
                ->first();

            if (isset($collection)) {
                $data[$consec]['invoice_id'] = $collection->invoice_id;
                $data[$consec]['fechpro'] = $collection->fechpro;
                $data[$consec]['rif'] = $collection->rif;
                $data[$consec]['business_name'] = $collection->business_name;
                $data[$consec]['contract_id'] = $collection->contract_id;
                $data[$consec]['bank'] = $collection->bank;
                $data[$consec]['affiliate_number'] = (int) $collection->affiliate_number;
                $data[$consec]['order'] = (int) $value['refere'];
                $data[$consec]['descripcion_cliente'] = $customer['descripcion_cliente'];
                $data[$consec]['status_bank'] = $customer['status_bank'];
                $data[$consec]['motivo_del_fallido'] = $customer['motivo_del_fallido'];
                $data[$consec]['collection_id'] = $collection->collection_id != null ? $collection->collection_id : '----';
                $data[$consec]['fechpro_collection'] = $collection->fechpro_collection != null ? $collection->fechpro_collection : '----';
                $data[$consec]['amount'] = $collection->amount != null ? $collection->amount : '----';
                $data[$consec]['resultado'] = $value['resultado'];
            }
            $consec++;
        }

        $this->cont = count($data) + 1;

        return Collect($data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'No. Cobro',
            'Fecha Cobro',
            'RIF',
            'Nombre Comercio',
            'No. Contrato',
            'Banco',
            'No. Afiliado',
            'No. Ordenante',
            'Descripción',
            'Resultado',
            'Motivo Falla',
            'No. Pago',
            'Fecha Pago',
            'Total',
            'Status Cobro',
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
                $event->sheet->getDelegate()->getStyle('M1:M'.$this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->getDelegate()->getStyle('A1:C'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:H'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('J1:J'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('L1:O'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
