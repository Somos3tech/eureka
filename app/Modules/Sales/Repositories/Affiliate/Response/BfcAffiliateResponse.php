<?php

namespace App\Modules\Sales\Repositories\Affiliate\Response;

class BfcAffiliateResponse implements AffiliateResponseInterface
{
    public function response($request)
    {
        $data = [];
        $array = explode("\n", file_get_contents(storage_path($request['file_response_bank']), true));
        foreach ($array as $key => $rows) {
            $row = trim($rows);
            $data[$key]['bank_id'] = $request['bank_id'];
            $terminalcount = strspn(substr($row, 10, 30), '0');
            $terminal = substr($row, 10 + $terminalcount, 30 - $terminalcount);
            $data[$key]['refere'] = $terminal;
            $data[$key]['terminal'] = $terminal;
            $data[$key]['response'] = substr($row, 153, 3);
            $data[$key]['message'] = trim(substr($row, 98, 51));
        }

        return $data;
    }
}
