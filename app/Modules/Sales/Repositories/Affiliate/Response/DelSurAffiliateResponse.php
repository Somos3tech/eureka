<?php

namespace App\Modules\Sales\Repositories\Affiliate\Response;

class DelSurAffiliateResponse implements AffiliateResponseInterface
{
    public function response($request)
    {
        $data = [];
        $array = explode("\r\n", file_get_contents(storage_path($request['file_response_bank']), true));
        foreach ($array as $key => $rows) {
            $row = trim($rows);
            $data[$key]['bank_id'] = $request['bank_id'];
            $data[$key]['refere'] = (int) substr($row, 0, 15);
            $data[$key]['contract_id'] = (int) substr($row, 15, 30);
            $data[$key]['response'] = substr($row, 45, 3);
            $data[$key]['message'] = trim(substr($row, 48, 80));
        }

        return $data;
    }
}
