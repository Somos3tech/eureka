<?php

namespace App\Modules\Sales\Repositories\Affiliate;

use App\Traits\TaskTrait;

class fileBancrecer implements downloadAffiliateInterface
{
    use TaskTrait;

    public function download($data)
    {
        $document = storage_path().'/'.'AF_0010_'.date_format(now(), 'dmy').'.txt';

        $file = fopen($document, 'w'); // Abrir

        foreach ($data as $final) {
            fwrite($file, $final['code_company'].$final['refere'].$final['bank_code'].$final['type_operation'].$final['type_ident'].
                $final['letter_rif'].$final['rif'].$final['number_account'].$this->str_pad_unicode($final['business_name'], 30, ' ', STR_PAD_RIGHT).$final['contract_id'].PHP_EOL);
        }

        fclose($file); // Cerrar

        // Define headersctext/plain
        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename='.basename($document));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

        ob_clean();
        flush();
        readfile($document);
        @unlink($document);
        exit;
    }
}
