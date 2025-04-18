<?php

namespace App\Imports;

use App\Models\MasterSiswa;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterSiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MasterSiswa([
            'id' => Str::uuid(),
            'nama' => $row['nama'],
            'nis' => $row['nis'],
            'nisn' => $row['nisn'],
            'tmp_rombel' => $row['tmp_rombel'],
            'status' => true,
        ]);
    }
}
