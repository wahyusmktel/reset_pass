<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Pegawai([
            'id' => Str::uuid(),
            'nama_guru' => $row['nama_guru'],
            'nip' => $row['nip'],
            'jabatan' => $row['jabatan'],
            'email_guru' => $row['email_guru'],
            'no_hp' => $row['no_hp'],
        ]);
    }
}
