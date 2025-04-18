<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Rombel;
use App\Models\MasterSiswa;
use App\Models\MasterKelas;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = MasterSiswa::all();
        $kelasList = MasterKelas::pluck('id')->toArray();

        foreach ($siswas as $siswa) {
            // Pilih kelas random
            $kelas_id = $kelasList[array_rand($kelasList)];

            Rombel::create([
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'kelas_id' => $kelas_id,
                'status' => true,
            ]);
        }
    }
}
