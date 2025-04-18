<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\MasterSiswa;

class MasterSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Rezza Alvionita',
                'nis' => '12345',
                'nisn' => '9876543210',
                'email' => 'rezza@example.com',
                'no_hp' => '081234567890',
                'status' => true,
            ],
            [
                'nama' => 'Andi Nugroho',
                'nis' => '54321',
                'nisn' => '1234567890',
                'email' => 'andi@example.com',
                'no_hp' => '081298765432',
                'status' => true,
            ],
            [
                'nama' => 'Dina Salsabila',
                'nis' => '67890',
                'nisn' => '1122334455',
                'email' => 'dina@example.com',
                'no_hp' => '089912345678',
                'status' => true,
            ],
        ];

        foreach ($data as $siswa) {
            MasterSiswa::create(array_merge($siswa, [
                'id' => Str::uuid()->toString(),
            ]));
        }
    }
}
