<?php

namespace App\Modules\Warehouses\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class FileImport implements ToModel
{
    use Importable;

    public function model(array $array)
    {
    }
}
