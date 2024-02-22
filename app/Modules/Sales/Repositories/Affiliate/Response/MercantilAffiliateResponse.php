<?php

namespace App\Modules\Sales\Repositories\Affiliate\Response;

class MercantilAffiliateResponse implements AffiliateResponseInterface
{
    public function response($request)
    {
        $data = [];
        $array = explode("\n", file_get_contents(storage_path($request['file_response_bank']), true));
        foreach ($array as $key => $rows) {
            if ($key > 0) {
                $row = trim($rows);
                $data[$key - 1]['bank_id'] = $request['bank_id'];
                $data[$key - 1]['refere'] = (int) substr($row, 89, 17);
                $data[$key - 1]['terminal'] = (int) substr($row, 89, 17);
                $data[$key - 1]['response'] = substr($row, 143, 2);
                $data[$key - 1]['message'] = trim(substr($row, 145, 30));
            }
        }

        return $data;
    }
}
