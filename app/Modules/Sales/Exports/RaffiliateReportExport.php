<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Raffiliate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class RaffiliateReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
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
        $consec = 0;
        $request = $this->data;

        $model = Raffiliate::select(
            \DB::raw("LPAD(raffiliates.id,6,'0') AS raffiliate_id"),
            \DB::raw("DATE_FORMAT(raffiliates.created_at,'%Y-%m-%d')"),
            'raffiliates.contract_id',
            'customers.rif',
            'customers.business_name',
            'banks.description as bank',
            'dc.affiliate_number',
            'dc.account_number',
            \DB::raw("(CASE WHEN(raffiliates.observation_response IS NULL) THEN '----' ELSE raffiliates.observation_response END) as observation"),
            'raffiliates.status',
            \DB::raw("(CASE WHEN (raffiliates.updated_at IS NULL) THEN '----' ELSE DATE_FORMAT(raffiliates.updated_at,'%Y-%m-%d') END) AS updated")
        )
            ->join('contracts', 'contracts.id', '=', 'raffiliates.contract_id')
            ->leftjoin('aconsecutives', 'aconsecutives.contract_id', '=', 'raffiliates.contract_id')
            ->join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->leftjoin('dcustomers as dc', 'dc.id', '=', 'contracts.dcustomer_id')
            ->leftjoin('banks', 'banks.id', '=', 'dc.bank_id')
            ->orderBy('raffiliates.fechpro', 'ASC');

        if ($request['bank_id'] != null) {
            $model->where('raffiliates.bank_id', $request['bank_id']);
        }

        $data = $model->distinct()->get();

        $this->cont = count($data) + 1;

        return Collect($data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            '#',
            'Fecha',
            'No. Contrato',
            'RIF',
            'Nombre Comercio',
            'Banco',
            'No. Afiliado',
            'Cuenta Bancaria',
            'Observación',
            'Status',
            'Actualizado',
        ];
    }

    /**************************************************************************/
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:K'.$this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A1:K1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');
                $event->sheet->getDelegate()->getStyle('A1:K'.$this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:D'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F1:H'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('J1:K'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
