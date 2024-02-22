<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Rcollection;
use App\Traits\TaskTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class RcollectionReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    use TaskTrait;

    protected $data;

    public $cont;

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
        $data = [];
        $consec = 0;
        $request = $this->data;

        $model = Rcollection::select(
            \DB::raw("LPAD(rcollections.id,6,'0') AS rcollection_id"),
            'rcollections.fechpro',
            'invoices.id as invoice_id',
            'invoices.fechpro as fechpro_invoice',
            'invoices.rif',
            'invoices.business_name',
            'contracts.id as contract_id',
            'banks.description as bank',
            'dc.account_number',
            'dc.affiliate_number',
            'terminals.serial as terminal',
            \DB::raw("LPAD(contracts.nropos,4,'0') AS nropos"),
            'terms.abrev as term',
            'collections.id as collection_id',
            'collections.fechpro as fechpro_collection',
            'invoices.amount as amount_invoice',
            'collections.amount',
            'collections.amount_currency',
            'collections.dicom as currency',
            'rcollections.data',
            'rcollections.status',
            'customers.id as customer_id',
            'customers.foreign_id'
        );

        if ($this->bankValidConsecutive($request['bank_id'], 'domiciliation')) {
            $model->join('consecutives', function ($join) use ($request) {
                $join->on('consecutives.consecutive', '=', 'rcollections.refere');
                $join->where('consecutives.bank_id', $request['bank_id']);
            })
                ->leftjoin('invoices', 'invoices.id', '=', 'consecutives.invoice_id');
        } else {
            $model->leftjoin('invoices', 'invoices.id', '=', 'rcollections.refere');
        }

        $model->leftjoin('contracts', 'contracts.id', '=', 'invoices.contract_id')
            ->leftjoin('customers', 'customers.id', '=', 'contracts.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('banks', 'banks.id', '=', 'dc.bank_id')
            ->leftjoin('collections', 'collections.invoice_id', '=', 'invoices.id')
            ->leftjoin('terminals', 'terminals.id', '=', 'contracts.terminal_id')
            ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
            ->orderBy('rcollections.refere', 'ASC')->orderBy('rcollections.fechpro', 'ASC');

        if ($request['type_date'] == 'range') {
            $date = explode('|', $request['date_range']);
            $model->where('rcollections.fechpro', '>=', $date[0])
                ->where('rcollections.fechpro', '<=', $date[1]);
        } elseif ($request['type_date'] == 'date') {
            $model->where('rcollections.fechpro', 'LIKE', $request['fechpro'].'%');
        }

        $array = $model->where('rcollections.bank_id', $request['bank_id'])->get();

        foreach ($array as $key => $value) {
            $data_array = unserialize($value['data']);
            $data[$consec]['rcollection_id'] = $value['rcollection_id'];
            $data[$consec]['fechpro_rcollection'] = $value['fechpro'];
            $data[$consec]['invoice_id'] = $value['invoice_id'];
            $date = date_create($value['fechpro_invoice']);
            $data[$consec]['fechpro'] = date_format($date, 'Y-m-d');
            $data[$consec]['customer_id'] = $value['customer_id'];
            $data[$consec]['foreign_id'] = $value['foreign_id'];
            $data[$consec]['rif'] = $value['rif'];
            $data[$consec]['business_name'] = $value['business_name'];
            $data[$consec]['contract_id'] = $value['contract_id'];
            $data[$consec]['bank'] = $value['bank'];
            $data[$consec]['account_number'] = $value['account_number'];
            $data[$consec]['affiliate_number'] = trim($value['affiliate_number']);
            $data[$consec]['terminal'] = $value['terminal'];
            $data[$consec]['nropos'] = $value['nropos'];
            $data[$consec]['term'] = $value['term'];
            $data[$consec]['descripcion_cliente'] = $data_array['descripcion_cliente'];
            $data[$consec]['status_bank'] = $data_array['status_bank'];
            $data[$consec]['motivo_del_fallido'] = $data_array['motivo_del_fallido'] != '' || $data_array['motivo_del_fallido'] != null ? $data_array['motivo_del_fallido'] : '-----';
            $data[$consec]['collection_id'] = $value['status'] != 'X' ? $value['collection_id'] : '----';
            $data[$consec]['fechpro_collection'] = $value['status'] != 'X' ? $value['fechpro_collection'] : '----';
            $data[$consec]['amount'] = $value['amount_invoice'];
            $data[$consec]['currency'] = $value['status'] != 'X' ? $value['currency'] : '----';
            $data[$consec]['amount_currency'] = $value['status'] != 'X' ? $value['amount_currency'] : '----';
            $data[$consec]['status'] = $value['status'];

            $consec++;
        }

        $this->cont = count($data) + 1;

        return Collect($data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            '#',
            'Fecha Registro',
            'No. Cobro',
            'Fecha Cobro',
            'Código Cliente',
            'Códifo Profit',
            'RIF',
            'Nombre Comercio',
            'No. Contrato',
            'Banco',
            'No. Cuenta Bancaría',
            'No. Afiliado',
            'Serial',
            'No. Terminal',
            'Plan Servicio',
            'Descripción',
            'Resultado Bancario',
            'Motivo Falla',
            'No. Pago',
            'Fecha Pago',
            'Monto',
            'Tarifa Cambio',
            'Monto Bs.',
            'Status Gestión',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:X'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A1:X1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:X1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:X'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('U1:W'.$this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->getDelegate()->getStyle('A1:G'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('I1:O'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('U1:X'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
