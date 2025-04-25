<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengajuanResetGoogle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Services\GoogleWorkspaceService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppService;
use App\Models\LogResetGoogle;
use Illuminate\Support\Carbon;

class PublicResetGooglePegawaiController extends Controller
{
    public function create()
    {
        return view('public.pengajuan-google-pegawai.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nip' => 'required|exists:pegawais,nip',
        ]);
        Log::info('Validasi NIP berhasil', ['nip' => $request->nip]);

        // Ambil data pegawai
        $pegawai = Pegawai::where('nip', $request->nip)->firstOrFail();
        Log::info('Data pegawai ditemukan', [
            'nama_guru' => $pegawai->nama_guru,
            'email_guru' => $pegawai->email_guru,
            'no_hp' => $pegawai->no_hp
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('nip', $pegawai->nip);
        Log::info('OTP berhasil dibuat dan disimpan ke session', ['otp' => $otp]);

        // Kirim OTP via WhatsApp
        $pesan = "Kode OTP reset akun Google Anda: $otp\nJangan berikan kode ini kepada siapa pun.";
        try {
            $this->kirimWA($pegawai->no_hp, $pesan);
            Log::info('OTP berhasil dikirim ke WhatsApp', ['no_hp' => $pegawai->no_hp]);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim OTP ke WhatsApp', ['error' => $e->getMessage()]);
        }

        return redirect()->route('pegawai.verifyOtp')->with([
            'no_hp' => $pegawai->no_hp
        ]);
    }

    public function verifyOtpForm()
    {
        $noHp = Session::get('no_hp');
        return view('public.pengajuan-google-pegawai.verify-otp', compact('noHp'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);
        if ($request->otp == Session::get('otp')) {
            return redirect()->route('pegawai.setPassword');
        }
        return back()->with('error', 'Kode OTP tidak valid.');
    }

    public function setPasswordForm()
    {
        return view('public.pengajuan-google-pegawai.set-password');
    }

    public function setPassword(Request $request, GoogleWorkspaceService $googleService, WhatsAppService $wa)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pegawai.setPassword')
                ->withErrors($validator)
                ->withInput();
        }

        $nip = Session::get('nip');
        $pegawai = \App\Models\Pegawai::where('nip', $nip)->firstOrFail();

        if (!$pegawai->email_guru) {
            Log::error('[Reset Pegawai] Email pegawai kosong', [
                'nip' => $pegawai->nip,
                'nama' => $pegawai->nama_guru,
            ]);

            return redirect()->route('pegawai.setPassword')
                ->with('error', 'Email pegawai belum tersedia. Tidak dapat melakukan reset password.');
        }

        try {
            // Reset password via Google Workspace
            $googleService->resetPasswordById($pegawai->email_guru, $request->password);

            // Kirim notifikasi WA ke pegawai
            $nomor = '62' . ltrim($pegawai->no_hp, '0');
            $pesan = "✅ Hai {$pegawai->nama_guru},\nPassword akun Google Anda berhasil direset:\n\n📧 Email: *{$pegawai->email_guru}*\n🔑 Password Baru: *{$request->password}*\n\nSilakan login dan jaga kerahasiaan akun Anda.\n\n*- IT SMK Telkom Lampung*";
            $wa->sendMessage($nomor, $pesan);

            // Simpan log berhasil
            LogResetGoogle::create([
                'pegawai_nip' => $pegawai->nip,
                'email' => $pegawai->email_guru,
                'password_baru' => $request->password,
                'status' => true,
                'pesan' => 'Berhasil reset password dan kirim WA',
                'waktu_reset' => Carbon::now(),
            ]);

            return redirect()->route('pegawai.resume')
                ->with('success', 'Password berhasil direset dan notifikasi WA dikirim.');
        } catch (\Exception $e) {
            Log::error('[Reset Pegawai] Gagal reset password', [
                'nip' => $pegawai->nip,
                'error' => $e->getMessage(),
            ]);

            // Simpan log gagal
            LogResetGoogle::create([
                'pegawai_nip' => $pegawai->nip,
                'email' => $pegawai->email_guru,
                'password_baru' => $request->password,
                'status' => false,
                'pesan' => $e->getMessage(),
                'waktu_reset' => Carbon::now(),
            ]);

            return redirect()->route('pegawai.setPassword')
                ->with('error', 'Gagal reset password: ' . $e->getMessage());
        }
    }

    // public function setPassword(Request $request, GoogleWorkspaceService $googleService, WhatsAppService $wa)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'password' => 'required|min:6|confirmed',
    //     ], [
    //         'password.required' => 'Password wajib diisi.',
    //         'password.min' => 'Password minimal 6 karakter.',
    //         'password.confirmed' => 'Konfirmasi password tidak cocok.',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('pegawai.setPassword')
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $nip = Session::get('nip');
    //     $pegawai = \App\Models\Pegawai::where('nip', $nip)->firstOrFail();

    //     if (!$pegawai->email_guru) {
    //         Log::error('[Reset Pegawai] Email pegawai kosong', [
    //             'nip' => $pegawai->nip,
    //             'nama' => $pegawai->nama_guru,
    //         ]);

    //         return redirect()->route('pegawai.setPassword')
    //             ->with('error', 'Email pegawai belum tersedia. Tidak dapat melakukan reset password.');
    //     }

    //     try {
    //         // Reset password via Google Workspace
    //         $googleService->resetPasswordById($pegawai->email_guru, $request->password);

    //         // Kirim notifikasi WA ke pegawai
    //         $nomor = '62' . ltrim($pegawai->no_hp, '0');
    //         $pesan = "✅ Hai {$pegawai->nama_guru},\nPassword akun Google Anda berhasil direset:\n\n📧 Email: *{$pegawai->email_guru}*\n🔑 Password Baru: *{$request->password}*\n\nSilakan login dan jaga kerahasiaan akun Anda.\n\n*- IT SMK Telkom Lampung*";

    //         $wa->sendMessage($nomor, $pesan);

    //         return redirect()->route('pegawai.resume')->with('success', 'Password berhasil direset dan notifikasi WA dikirim.');
    //     } catch (\Exception $e) {
    //         Log::error('[Reset Pegawai] Gagal reset password', [
    //             'nip' => $pegawai->nip,
    //             'error' => $e->getMessage(),
    //         ]);

    //         return redirect()->route('pegawai.setPassword')
    //             ->with('error', 'Gagal reset password: ' . $e->getMessage());
    //     }
    // }



    public function resume()
    {
        $pegawai = Pegawai::where('nip', Session::get('nip'))->first();
        return view('public.pengajuan-google-pegawai.resume', compact('pegawai'));
    }

    private function kirimWA($noHp, $pesan)
    {
        $wa = app(\App\Services\WhatsAppService::class);
        $nomor = '62' . ltrim($noHp, '0');

        try {
            $wa->sendMessage($nomor, $pesan);
            Log::info('Pesan WhatsApp berhasil dikirim.', [
                'tujuan' => $nomor,
                'pesan' => $pesan
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim pesan WhatsApp.', [
                'tujuan' => $nomor,
                'error' => $e->getMessage()
            ]);
        }
    }
}
