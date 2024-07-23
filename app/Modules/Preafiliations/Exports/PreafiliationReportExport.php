<?php

namespace App\Modules\Preafiliations\Exports;

use App\Modules\Parameters\Models\Bank;
use App\Modules\Parameters\Models\Cactivity;
use App\Modules\Parameters\Models\City;
use App\Modules\Parameters\Models\Company;
use App\Modules\Parameters\Models\Currency;
use App\Modules\Parameters\Models\Mterminal;
use App\Modules\Parameters\Models\Operator;
use App\Modules\Parameters\Models\Pmethod;
use App\Modules\Parameters\Models\State;
use App\Modules\Parameters\Models\Term;
use App\Modules\Preafiliations\Models\Preafiliation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PreafiliationReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
        $data = [];
        $request = $this->data;

        $query = Preafiliation::query();
        $count = count($request['field']);

        $query->select('preafiliations.*', 'cp.description as company', \DB::raw("CONCAT(usc.name,' ',usc.last_name) user_created"), \DB::raw("CONCAT(usu.name,' ',usu.last_name) user_updated"))
            ->leftjoin('companies as cp', function ($join) {
                $join->on('cp.id', '=', 'preafiliations.id');
                $join->whereNull('cp.deleted_at')->limit(1);
            })
            ->leftjoin('users as usc', function ($join) {
                $join->on('usc.id', '=', 'preafiliations.user_created_id');
            })
            ->leftjoin('users as usu', function ($join) {
                $join->on('usu.id', '=', 'preafiliations.user_updated_id');
            });

        if ($request->has('date_range')) {
            $date = explode('|', $request['date_range']);
            if (count($date) > 1) {
                $query->whereBetween('preafiliations.created_at', [$date[0] . '%', $date[1] . '%']);
            }
        }

        for ($i = 0; $i < $count; $i++) {
            if ($request['field'][$i] != null && $request['query'][$i] != null) {
                if ($request['operator'][$i] != null) {
                    $operator = $request['operator'][$i];
                } else {
                    $operator = '=';
                }

                if ($i == 0) {
                    $query->where('preafiliations.' . $request['field'][$i], $operator, $request['query'][$i]);
                    $cond = $request['conditional'][$i];
                } else {
                    if ($cond == 'AND' || $cond == '') {
                        $query->where('preafiliations.' . $request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    } else {
                        $query->OrWhere('preafiliations.' . $request['field'][$i], $operator, $request['query'][$i]);
                        $cond = $request['conditional'][$i];
                    }
                }
            }
        }

        if ($request['company_id'] != '') {
            $query->where('preafiliations.company_id', 'LIKE', $request['company_id']);
        }

        if ($request['statusc'] != '') {
            $query->where('preafiliations.status', 'LIKE', $request['statusc']);
        }

        if ($request['user_created_id']) {
            $query->where('preafiliations.user_created_id', $request['user_created_id']);
        }

        $preafiliation = $query->orderBy('preafiliations.id', 'ASC')->whereNull('preafiliations.deleted_at')->get();

        foreach ($preafiliation as $key => $row) {
            $data[$key]['id'] = $row['id'];
            $data[$key]['rif'] = $row['rif'];
            $customer = unserialize($row['data_customer']);
            $data[$key]['business_name'] = $customer['business_name'];

            $cactivity = Cactivity::query()->select('description')->where('id', $customer['cactivity_id'])->first();
            if (isset($cactivity)) {
                $data[$key]['cactivity'] = $cactivity->description;
            } else {
                $data[$key]['cactivity'] = '----';
            }
            $data[$key]['email'] = $customer['email'];
            $data[$key]['telephone'] = $customer['telephone'] != null ? $customer['telephone'] : '----';
            $data[$key]['mobile'] = $customer['mobile'];
            $data[$key]['mobile2'] = $customer['mobile2'];

            $state = State::query()->select('description')->where('id', $customer['state_id'])->first();
            $data[$key]['state'] = $state->description;

            if (array_key_exists('city_id', $customer) && $customer['city_id'] != null) {
                $city = City::query()->select('description')->where('id', $customer['city_id'])->first();
                $data[$key]['city'] = $city->description;
            } else {
                $data[$key]['city'] = '---';
            }

            $data[$key]['municipality'] = $customer['municipality'];
            $data[$key]['address'] = $customer['address'];
            $data[$key]['postal_code'] = $customer['postal_code'];
            /********************************************************************/

            if (array_key_exists('state_fiscal_id', $customer) && $customer['state_fiscal_id'] != null) {
                $state_fiscal = State::query()->select('description')->where('id', $customer['state_fiscal_id'])->first();
                if (isset($state_fiscal)) {
                    $data[$key]['state_fiscal'] = $state_fiscal->description;
                } else {
                    $data[$key]['state_fiscal'] = '----';
                }
            } else {
                $data[$key]['state_fiscal'] = '----';
            }

            if (array_key_exists('city_fiscal_id', $customer) && $customer['city_fiscal_id'] != null) {
                $city_fiscal = City::query()->select('description')->where('id', $customer['city_fiscal_id'])->first();
                if (isset($city_fiscal)) {
                    $data[$key]['city_fiscal'] = $city_fiscal->description;
                } else {
                    $data[$key]['city_fiscal'] = '----';
                }
            } else {
                $data[$key]['city_fiscal'] = '----';
            }

            if (array_key_exists('municipality_fiscal', $customer)) {
                $data[$key]['municipality_fiscal'] = $customer['municipality_fiscal'];
            } else {
                $data[$key]['municipality_fiscal'] = '----';
            }

            $data[$key]['address_fiscal'] = array_key_exists('address_fiscal', $customer) && $customer['address_fiscal'] != null ? $customer['address_fiscal'] : '----';
            $data[$key]['postal_code_fiscal'] = array_key_exists('postal_code_fiscal', $customer) && $customer['postal_code_fiscal'] != null ? $customer['postal_code_fiscal'] : '----';

            $mercantil = unserialize($row['data_mercantil']);

            $data[$key]['type_cont'] = $mercantil['type_cont'] > 1 ? 'Contribuyente' : 'Ordinario';
            $data[$key]['tax'] = $mercantil['type_cont'] > 1 ? $mercantil['tax'] : '----';

            $rcustomer = unserialize($row['data_rcustomer']);

            if (array_key_exists('ident_number', $rcustomer) && $rcustomer['ident_number'] != null) {
                $ident_number = unserialize($rcustomer['ident_number']);
            } else {
                $ident_number = null;
            }

            if (array_key_exists('fullname', $rcustomer) && $rcustomer['fullname'] != null) {
                $fullname = unserialize($rcustomer['fullname']);
            } else {
                $fullname = null;
            }

            for ($i = 0; $i < 1; $i++) {
                if (isset($ident_number) && $ident_number != null) {
                    $data[$key]['ident_number'] = $ident_number[$i] != null ? $ident_number[$i] : '----';
                } else {
                    $data[$key]['ident_number'] = '----';
                }

                if (isset($fullname) && $fullname != null) {
                    $data[$key]['fullname'] = $fullname[$i] != null ? $fullname[$i] : '----';
                } else {
                    $data[$key]['fullname'] = '----';
                }
            }

            if (array_key_exists('date_register', $mercantil)) {
                $data[$key]['date_register'] = $mercantil['date_register'];
            } else {
                $data[$key]['date_register'] = '----';
            }

            if (array_key_exists('comercial_register', $mercantil)) {
                $data[$key]['comercial_register'] = $mercantil['comercial_register'];
            } else {
                $data[$key]['comercial_register'] = '----';
            }

            if (array_key_exists('city_register', $mercantil)) {
                $data[$key]['city_register'] = $mercantil['city_register'];
            } else {
                $data[$key]['city_register'] = '----';
            }

            if (array_key_exists('clause_register', $mercantil)) {
                $data[$key]['clause_register'] = $mercantil['clause_register'];
            } else {
                $data[$key]['clause_register'] = '----';
            }

            if (array_key_exists('took_register', $mercantil)) {
                $data[$key]['took_register'] = $mercantil['took_register'];
            } else {
                $data[$key]['took_register'] = '----';
            }

            if (array_key_exists('number_register', $mercantil)) {
                $data[$key]['number_register'] = $mercantil['number_register'];
            } else {
                $data[$key]['number_register'] = '----';
            }

            $data_bank = unserialize($row['data_bank']);
            $bank = Bank::query()->select('description')->where('id', $data_bank['bank_id'])->first();
            $data[$key]['bank'] = $bank->description;
            $data[$key]['account_number'] = $data_bank['bank_code'] . $data_bank['account_bank'];
            $data[$key]['affiliate_number'] = $data_bank['affiliate_number'];

            $data_contract = unserialize($row['data_contract']);

            $company = Company::query()->select('description')->where('id', $customer['company_id'])->first();
            //if (!empty($company->description)) {
            $data[$key]['company'] = $company->description;
            //} else {
            //    $data[$key]['company'] = "";
            //}

            $modelterminal = Mterminal::query()->select('description')->where('id', $data_contract['modelterminal_id'])->first();
            $data[$key]['modelterminal'] = $modelterminal->description;

            $operator = Operator::query()->select('description')->where('id', $data_contract['operator_id'])->first();
            $data[$key]['operator'] = $operator->description;

            $term = Term::query()->select('description')->where('id', $data_contract['term_id'])->first();
            $data[$key]['term'] = $term->description;

            $payment = unserialize($row['data_payment']);

            $pmethod = Pmethod::query()->select('description')->where('id', $payment['pmethod_id'])->first();

            if (isset($pmethod)) {
                $data[$key]['pmethod'] = $pmethod->description;
            } else {
                $data[$key]['pmethod'] = '----';
            }

            $currency = Currency::query()->select('description')->where('id', $payment['currency_id'])->first();
            $data[$key]['currency'] = $currency->description;

            $data[$key]['change_currency'] = $payment['dicom'] != 1 || $payment['dicom'] == null ? $payment['dicom'] : '---';
            $data[$key]['amount'] = $payment['amount'];
            $data[$key]['amount_currency'] = $payment['currency_id'] > 1 ? ($payment['dicom'] * $payment['amount']) : $payment['amount'];
            $data[$key]['refere'] = ' ' . $payment['refere'];
            $data[$key]['document_payment'] = $row['document_payment'] ? 'Si' : 'No';

            $data[$key]['observation_initial'] = $row['observation_initial'] != null ? $row['observation_initial'] : '----';
            $data[$key]['observation_assistent'] = $row['observations'] != null ? $row['observations'] : '----';
            $data[$key]['observation_sale'] = $row['observations_sale'] != null ? $row['observations_sale'] : '----';
            $data[$key]['status'] = $row['status'];

            $data[$key]['is_rif'] = $row['is_rif'] ? 'Si' : 'No';
            $data[$key]['is_mercantil'] = $row['is_mercantil'] ? 'Si' : 'No';
            $data[$key]['is_bank'] = $row['is_bank'] ? 'Si' : 'No';
            $data[$key]['is_auth_bank'] = $row['is_auth_bank'] ? 'Si' : 'No';

            $data[$key]['document_rif'] = $row['document_rif'] ? 'Si' : 'No';
            $data[$key]['document_mercantil'] = $row['document_mercantil'] ? 'Si' : 'No';
            $data[$key]['document_bank'] = $row['document_bank'] ? 'Si' : 'No';
            $data[$key]['autorization_bank'] = $row['autorization_bank'] ? 'Si' : 'No';

            $data[$key]['user_created'] = ucwords(strtolower($row['user_created']));
            $created_at = $row['created_at'];
            $data[$key]['created_at'] = $created_at->format('d-m-Y');

            $data[$key]['user_updated'] = ucwords($row['user_updated']);
            $updated_at = $row['updated_at'];
            $data[$key]['updated_at'] = $updated_at->format('d-m-Y');
        }

        $this->cont = count($data) + 1;

        return Collect($data);
    }

    /**************************************************************************/
    public function headings(): array
    {
        return [
            'No. Preafiliación',
            'RIF',
            'Nombre Comercio',
            'Actividad Comercial',
            'Email',
            'Telefono',
            'Mobile',
            'Mobile2',
            'Estado',
            'Ciudad',
            'Municipalidad',
            'Dirección',
            'Cod. Postal',
            'Estado Fiscal',
            'Ciudad Fiscal',
            'Municipalidad Fiscal',
            'Dirección Fiscal',
            'Cod. Postal Fiscal',
            'Contribuyente',
            'Porcentaje',
            'Documento Representante',
            'Nombre Representante',
            'Fecha Registro',
            'Registro Mercantil',
            'Ciudad Registro',
            'Clausula Registro',
            'Tomo',
            'No.',
            'Banco',
            'No. Cuenta',
            'No. Afiliado',
            'Almacén',
            'Modelo Equipo',
            'Operador',
            'Plan Vepagos',
            'Método Pago',
            'Divisa',
            'Valor Divisa',
            'Valor Equipo',
            'Valor Cambio',
            'Referencia',
            'Documento Soporte',
            'Observ. Inicial',
            'Observ. Asistente',
            'Observ. Vendedor',
            'Status',
            'Doc. RIF',
            'Doc. Mercantil',
            'Doc. Banco',
            'Doc. Débito',
            'Checklist RIF',
            'Checklist Mercant.',
            'Checklist Banco',
            'Checklist Débito',
            'Creado Por',
            'Creado',
            'Actualizado Por',
            'Actualizado',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:BE' . $this->cont; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(9);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:BF1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:BF1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1c235a');

                $event->sheet->getDelegate()->getStyle('A1:BF' . $this->cont)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:BF1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A2:B' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F2:J' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('M2:O' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('R2:U' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('W2:W' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Y2:AM' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AO2:AO' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AS2:BF' . $this->cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
