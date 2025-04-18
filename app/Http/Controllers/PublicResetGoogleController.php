<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\MasterSiswa;
use App\Models\PengajuanResetGoogle;
use Illuminate\Support\Facades\Log;

class PublicResetGoogleController extends Controller
{
    public function create()
    {
        $siswas = MasterSiswa::orderBy('nama')->get();
        return view('public.pengajuan-google.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        Log::info('Masuk ke store() pengajuan-reset-google', $request->all());

        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:master_siswas,id',
            'no_hp' => ['required', 'regex:/^(\+62|62|08)[0-9]{8,13}$/'],
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@(student\.smktelkom-lpg\.sch\.id|smktelkom-lpg\.sch\.id)$/i'],
            'keterangan' => 'required|string|max:255',
        ], [
            'siswa_id.required' => 'Nama siswa wajib dipilih.',
            'siswa_id.exists' => 'Siswa yang dipilih tidak ditemukan.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus menggunakan format Indonesia yang benar (08 atau +62 diikuti 8-13 digit).',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.regex' => 'Email harus menggunakan domain sekolah (@student.smktelkom-lpg.sch.id atau @smktelkom-lpg.sch.id).',
            'keterangan.required' => 'Alasan wajib diisi.',
            'keterangan.string' => 'Alasan harus berupa teks.',
            'keterangan.max' => 'Alasan maksimal 255 karakter.'
        ]);

        if ($validator->fails()) {
            Log::warning('Validasi gagal', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Log::info('Validasi sukses. Coba cari siswa', ['siswa_id' => $request->siswa_id]);

            $siswa = MasterSiswa::findOrFail($request->siswa_id);
            Log::info('Siswa ditemukan', ['nama' => $siswa->nama]);

            $siswa->update([
                'no_hp' => $request->no_hp,
                'email' => $request->email
            ]);
            Log::info('No HP siswa diperbarui', ['no_hp' => $request->no_hp]);

            $pengajuan = PengajuanResetGoogle::create([
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => true,
                'status' => true,
            ]);
            Log::info('Pengajuan berhasil disimpan', ['id_pengajuan' => $pengajuan->id]);

            return redirect()->route('pengajuan-google.resume', $pengajuan->id);
        } catch (\Exception $e) {
            Log::error('Terjadi exception saat store pengajuan', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function resume($id)
    {
        $data = PengajuanResetGoogle::with('siswa')->findOrFail($id);
        return view('public.pengajuan-google.resume', compact('data'));
    }
}
