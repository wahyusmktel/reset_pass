<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\MasterSiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MasterSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterSiswa::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama', 'like', "%$q%")
                ->orWhere('nis', 'like', "%$q%")
                ->orWhere('nisn', 'like', "%$q%")
                ->orWhere('email', 'like', "%$q%");
        }

        $siswas = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('siswa.index', compact('siswas'));
    }


    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nis' => 'required|unique:master_siswas',
            'nisn' => 'required|unique:master_siswas',
            'email' => 'required|email|unique:master_siswas',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            MasterSiswa::create([
                'id' => Str::uuid(),
                'nama' => $request->nama,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'status' => true,
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $siswa = MasterSiswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = MasterSiswa::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nis' => 'required|unique:master_siswas,nis,' . $id,
            'nisn' => 'required|unique:master_siswas,nisn,' . $id,
            'email' => 'required|email|unique:master_siswas,email,' . $id,
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $siswa->update([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            MasterSiswa::findOrFail($id)->delete();
            return redirect()->route('siswa.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data. ' . $e->getMessage());
        }
    }

    public function generateAkunMasal()
    {
        $siswas = MasterSiswa::whereNotIn('id', User::pluck('siswa_id'))->get();

        foreach ($siswas as $siswa) {
            $password = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // 4 digit

            $user = User::create([
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'name' => $siswa->nama,
                'email' => $siswa->email,
                'password' => Hash::make($password),
            ]);

            $user->assignRole('siswa');

            $siswa->update([
                'password' => $password,
            ]);
        }

        return redirect()->route('siswa.index')->with('success', 'Akun masal berhasil dibuat.');
    }

    public function resetPassword($id)
    {
        $siswa = MasterSiswa::findOrFail($id);
        $user = User::where('siswa_id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Akun belum dibuat.');
        }

        $password = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // default reset 4 digit

        $user->update(['password' => Hash::make($password)]);
        $siswa->update(['password' => $password]);

        return redirect()->back()->with('success', 'Password berhasil direset. Password baru: ' . $password);
    }
}
