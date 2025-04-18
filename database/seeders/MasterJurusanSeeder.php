<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\MasterJurusan;

class MasterJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = [
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak', 'kode_jurusan' => 'RPL'],
            ['nama_jurusan' => 'Teknik Jaringan Komputer', 'kode_jurusan' => 'TJK'],
            ['nama_jurusan' => 'Multimedia', 'kode_jurusan' => 'MM'],
            ['nama_jurusan' => 'Teknik Komputer dan Jaringan', 'kode_jurusan' => 'TKJ'],
        ];

        foreach ($jurusans as $jurusan) {
            MasterJurusan::create(array_merge($jurusan, [
                'id' => Str::uuid()->toString(),
                'status' => true,
            ]));
        }
    }
}
