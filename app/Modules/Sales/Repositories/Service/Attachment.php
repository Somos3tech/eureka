<?php

namespace App\Modules\Sales\Repositories\Service;

use Storage;

class Attachment implements SupportInvoiceInterface
{
    public function support($request)
    {
        $data = ['conciliation_doc' => $this->hasFileCustomer($request)];

        return $data;
    }

    private function hasFileCustomer($request)
    {
        $type_document = 'payment_contract_'.rand();
        $path = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // generar un nombre con la extension
            $path = $request['rif'].'_'.$type_document.'.'.$file->getClientOriginalExtension();
            $path_modify = $request['rif'].'_payment.'.$file->getClientOriginalExtension();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path().'/customers/'.$request['rif'].'/'.$path_modify)) {
                $result = Storage::disk('base')->delete('customers/'.$request['rif'].'/'.$path_modify);
            }
            $result = Storage::disk('base')->put('customers/'.$request['rif'].'/'.$path, \File::get($file));
        }
        if ($result) {
            return $path;
        }

        return false;
    }
}
