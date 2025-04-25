<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama_guru', 'like', "%$q%")
                ->orWhere('email_guru', 'like', "%$q%")
                ->orWhere('nip', 'like', "%$q%");
        }

        $pegawais = $query->orderBy('nama_guru')->paginate(10)->withQueryString();

        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_guru' => 'required|string|max:255',
            'email_guru' => 'required|email|unique:pegawais',
            'nip' => 'required|unique:pegawais',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'email_guru.required' => 'Email guru wajib diisi.',
            'email_guru.email' => 'Format email tidak valid.',
            'email_guru.unique' => 'Email guru sudah terdaftar.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Pegawai::create([
                'nama_guru' => $request->nama_guru,
                'email_guru' => $request->email_guru,
                'nip' => $request->nip,
                'status' => true,
            ]);

            return redirect()->route('pegawai.index')->with('success', 'Data guru berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_guru' => 'required|string|max:255',
            'email_guru' => 'required|email|unique:pegawais,email_guru,' . $id,
            'nip' => 'required|unique:pegawais,nip,' . $id,
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'email_guru.required' => 'Email guru wajib diisi.',
            'email_guru.email' => 'Format email tidak valid.',
            'email_guru.unique' => 'Email guru sudah terdaftar.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $pegawai->update([
                'nama_guru' => $request->nama_guru,
                'email_guru' => $request->email_guru,
                'nip' => $request->nip,
            ]);

            return redirect()->route('pegawai.index')->with('success', 'Data guru berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Pegawai::findOrFail($id)->delete();
            return redirect()->route('pegawai.index')->with('success', 'Data guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
