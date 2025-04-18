<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\MasterJurusan;
use App\Models\MasterKelas;

class MasterKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tingkatan = ['X', 'XI', 'XII'];

        // Ambil semua jurusan
        $jurusans = MasterJurusan::all();

        foreach ($jurusans as $jurusan) {
            foreach ($tingkatan as $tingkat) {
                // Contoh nama kelas: X RPL 1, X RPL 2
                for ($i = 1; $i <= 2; $i++) {
                    MasterKelas::create([
                        'id' => Str::uuid(),
                        'nama_kelas' => "$tingkat {$jurusan->kode_jurusan} $i",
                        'tingkat_kelas' => $tingkat,
                        'jurusan_id' => $jurusan->id,
                        'status' => true,
                    ]);
                }
            }
        }
    }
}
