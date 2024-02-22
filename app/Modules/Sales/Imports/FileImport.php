<?php

namespace App\Modules\Sales\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FileImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $array)
    {
    }
}
