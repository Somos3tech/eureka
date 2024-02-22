<?php

namespace App\Modules\Sales\Exports;

use App\Modules\Sales\Models\Contract;
use App\Modules\Sales\Models\Operation;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class OperationReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    public $cont;

    protected $data;

    /**************************************************************************/
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
        $sum = 0;
        $request = $this->data;

        $query = Operation::query();
        $query->select(\DB::raw("LPAD(operations.id ,6,'0') as operation_id"), 'operations.*');

        if ($request['type_service'] != '') {
            $query->where('operations.type_service', '=', $request['type_service']);
        } else {
            $query->whereNotNull('operations.type_service');
        }

        if ($request['type_operation'] != '') {
            $query->where('operations.type_operation', '=', $request['type_operation']);
        }

        if ($request['type_date'] == 'range') {
            $date = explode('|', $request['date_range']);
            $query->whereBetween('operations.created_at', [$date[0].'%', $date[1].'%']);
        } elseif ($request['type_date'] == 'month') {
            $query->where('operations.created_at', 'LIKE', $request['date'].'%');
        }

        $operation = $query->orderBy('operations.type_service', 'ASC')->orderBy('operations.type_operation', 'ASC')->orderBy('operations.id', 'ASC')->get();

        if (isset($operation)) {
            foreach ($operation as $key => $row) {
                $array_query = unserialize($row->data);

                if (array_key_exists('invoice_id', $array_query)) {
                    $array_data[0] = $array_query;
                } else {
                    $array_data = $array_query;
                }

                foreach ($array_data as $key => $array) {
                    if ($array['invoice_id'] != '' || $array['contract_id'] != '') {
                        $model = Contract::select('contracts.id as contract_id', \DB::raw("LPAD(cs.id ,6,'0') as customer_id"), DB::raw("(CASE WHEN (cs.foreign_id IS NULL) THEN '----' ELSE LPAD(cs.foreign_id ,6,'0') END) AS foreign_id"), 'contracts.id as contract_id', 'cs.business_name', DB::raw("CONCAT(SUBSTRING(dc.account_number, 1, 4),LPAD(contracts.id ,6,'0'),t.serial) AS account_number"))
                            ->leftjoin('customers as cs', function ($join) {
                                $join->on('cs.id', '=', 'contracts.customer_id');
                                $join->whereNull('cs.deleted_at');
                            })
                            ->leftjoin('dcustomers as dc', function ($join) {
                                $join->on('dc.id', '=', 'contracts.dcustomer_id');
                                $join->whereNull('dc.deleted_at');
                            })
                            ->leftjoin('terminals as t', function ($join) {
                                $join->on('t.id', '=', 'contracts.terminal_id');
                                $join->whereNull('t.deleted_at');
                            });

                        if ($array['invoice_id'] != '' && $array['invoice_id'] != null) {
                            $model->join('invoices', function ($join) {
                                $join->on('invoices.contract_id', '=', 'contracts.id');
                                $join->whereNull('invoices.deleted_at');
                            })->where('invoices.id', (int) $array['invoice_id'])->addSelect(DB::raw("DATE_FORMAT(invoices.fechpro, '%Y-%m-%d') as fechpro, invoices.id as invoice_id"));
                        } else {
                            $model->where('contracts.id', (int) $array['contract_id']);
                        }
                        $contract = $model->first();
                        if (isset($contract)) {
                            $data[$sum]['created_operation'] = $row->created_at->format('Y-m-d');
                            $data[$sum]['operation_id'] = $row->operation_id;

                            $data[$sum]['customer_id'] = $contract->customer_id;
                            $data[$sum]['profit_id'] = $contract->foreign_id;
                            $data[$sum]['business_name'] = $contract->business_name;
                            $data[$sum]['account_number'] = $contract->account_number;

                            if ($row['type_service'] == 'masivo') {
                                $type_service = 'Másivo';
                            } elseif ($row['type_service'] == 'basico') {
                                $type_service = 'Básico';
                            }

                            if ($row['type_operation'] == 'credito') {
                                $type_operation = 'Abono Cobro';
                                $type_moviment = 'Abono';
                            } elseif ($row['type_operation'] == 'debito') {
                                $type_operation = 'Cobro Generado';
                                $type_moviment = 'Cargo';
                            } elseif ($row['type_operation'] == 'exoneracion') {
                                $type_operation = 'Cobro Exonerado';
                                $type_moviment = 'Exonerado';
                            } elseif ($row['type_operation'] == 'reverso') {
                                $type_moviment = 'Reverso';
                                $type_operation = 'Reverso Pago';
                            } else {
                                $type_operation = '----';
                                $type_moviment = 'Anulación';
                            }
                            $data[$sum]['type_service'] = $type_service;
                            $data[$sum]['type_moviment'] = $type_moviment;
                            $data[$sum]['type_operation'] = $type_operation;

                            if (array_key_exists('invoice_id', $contract->toArray())) {
                                $data[$sum]['contract_id'] = $contract->contract_id;
                                $data[$sum]['fechpro'] = $contract->fechpro;
                                $data[$sum]['invoice_id'] = $contract->invoice_id;
                            } else {
                                $data[$sum]['contract_id'] = $contract->contract_id;
                                $data[$sum]['fechpro'] = '----';
                                $data[$sum]['invoice_id'] = '----';
                            }
                            $data[$sum]['amount'] = $array['amount'];
                            $data[$sum]['refere'] = $array['refere'];
                            $data[$sum]['observation'] = array_key_exists('observations_response', $array) && $array['observations_response'] != null ? $array['observations_response'] : '----';

                            $sum++;
                        }
                    }
                }
            }
        }
        $this->cont = count($data) + 1;

        return Collect($data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'Fecha Operación',
            'No. Operación',
            'Código Cliente',
            'Código Profit',
            'Nombre Comercio',
            'Nro. Cuenta',
            'Tipo Servicio',
            'Tipo Movimiento',
            'Operación',
            'No.Contrato',
            'Fecha Cobro',
            'No.Cobro',
            'Monto Pago',
            'Observaciones Carga',
            'Observaciones Operación',
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
                $event->sheet->getDelegate()->getStyle('A1:D'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F1:M'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('O1:O'.$this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('M1:M'.$this->cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}
