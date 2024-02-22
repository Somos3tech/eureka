<?php

namespace App\Modules\Sales\Repositories\Contract;

class ContractBasic implements ContractInterface
{
    private function dataBasic($request)
    {
        return  [
            'customer_id' => $request['customer_id'],
            'dcustomer_id' => $request['dcustomer_id'],
            'company_id' => $request['company_id'],
            'modelterminal_id' => $request['modelterminal_id'],
            'observation' => $request['observation'],
            'status' => 'Pendiente',
            'term_id' => $request['term_id'],
        ];
    }

    private function dataUpdate($request)
    {
        return  [
            'customer_id' => $request['customer_id'],
            'consultant_id' => $request['consultant_id'],
            'company_id' => $request['company_id'],
            'observation' => $request['observation'],
            'term_id' => $request['term_id'],
        ];
    }

    /****************************************************************************/
    public function create($request)
    {
        $data_user = [
            'user_created_id' => $request['user_id'],
        ];

        $data = array_merge($this->dataBasic($request), $data_user, $this->dataOperator($request), $this->dataConsultant($request), $this->dataIsDelivery($request));

        return $data;
    }

    /****************************************************************************/
    public function update($request)
    {
        $data_user = [
            'user_updated_id' => $request['user_id'],
        ];

        $data = array_merge($this->dataUpdate($request), $data_user, $this->dataOperator($request), $this->dataConsultant($request), $this->dataIsDelivery($request));

        return $data;
    }

    /****************************************************************************/
    private function dataConsultant($request)
    {
        if (isset($request['consultant_id'])) {
            return [
                'consultant_id' => $request['consultant_id'],
            ];
        } else {
            return [
                'consultant_id' => null,
            ];
        }
    }

    /****************************************************************************/
    private function dataOperator($request)
    {
        if (isset($request['checkbox'])) {
            return [
                'valid_simcard' => 1,
                'operator_id' => null,
            ];
        } else {
            return [
                'valid_simcard' => 0,
                'operator_id' => $request['operator_id'],
            ];
        }
    }

    /****************************************************************************/
    private function dataIsDelivery($request)
    {
        if (isset($request['is_delivery'])) {
            return [
                'is_delivery' => 1,
                'delivery_date' => date('Y-m-d'),
            ];
        } else {
            return [
                'is_delivery' => 0,
                'delivery_date' => null,
            ];
        }
    }
}
