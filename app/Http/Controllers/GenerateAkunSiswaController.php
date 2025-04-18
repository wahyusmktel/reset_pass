<?php

namespace App\Http\Controllers;

use App\Models\MasterSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GenerateAkunSiswaController extends Controller
{
    public function index()
    {
        // Hanya tampilkan siswa yang belum punya akun di tabel users
        $siswas = MasterSiswa::whereNotIn('id', User::pluck('siswa_id'))->orderBy('nama')->get();
        return view('akun_siswa.index', compact('siswas'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:master_siswas,id',
            'password' => 'required|min:6',
        ]);

        $siswa = MasterSiswa::findOrFail($request->siswa_id);

        // Cek apakah sudah ada akun
        if (User::where('siswa_id', $siswa->id)->exists()) {
            return redirect()->back()->with('error', 'Akun untuk siswa ini sudah ada.');
        }

        // Buat user dan assign role 'siswa'
        $user = User::create([
            'id' => Str::uuid(),
            'siswa_id' => $siswa->id,
            'name' => $siswa->nama,
            'email' => $siswa->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role spatie
        $user->assignRole('siswa');

        return redirect()->route('akun-siswa.index')->with('success', 'Akun siswa berhasil dibuat dan role sudah diterapkan.');
    }
}
