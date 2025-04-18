<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\MasterSiswa;
use App\Models\PengajuanResetMylms;

class PublicResetMyLmsController extends Controller
{
    public function create()
    {
        $siswas = MasterSiswa::orderBy('nama')->get();
        return view('public.pengajuan-mylms.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:master_siswas,id',
            'no_hp' => ['required', 'regex:/^(\+62|62|08)[0-9]{8,13}$/'],
            'keterangan' => 'required|string|max:255',
        ], [
            'siswa_id.required' => 'Nama siswa wajib dipilih.',
            'siswa_id.exists' => 'Siswa yang dipilih tidak ditemukan.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus menggunakan format Indonesia yang benar (08 atau +62 diikuti 8-13 digit).',
            'keterangan.required' => 'Alasan wajib diisi.',
            'keterangan.string' => 'Alasan harus berupa teks.',
            'keterangan.max' => 'Alasan maksimal 255 karakter.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Update nomor HP terbaru siswa
            $siswa = MasterSiswa::findOrFail($request->siswa_id);
            $siswa->update(['no_hp' => $request->no_hp]);

            // Simpan pengajuan
            $pengajuan = PengajuanResetMylms::create([
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => true,
                'status' => true,
            ]);

            return redirect()->route('pengajuan-mylms.resume', $pengajuan->id);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function resume($id)
    {
        $data = PengajuanResetMylms::with('siswa')->findOrFail($id);
        return view('public.pengajuan-mylms.resume', compact('data'));
    }
}
