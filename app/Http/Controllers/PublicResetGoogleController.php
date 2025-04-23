<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\MasterSiswa;
use App\Models\PengajuanResetGoogle;
use Illuminate\Support\Facades\Log;
use App\Services\GoogleWorkspaceService;
use App\Services\WhatsAppService;
use App\Models\ResponsePengajuanResetGoogle;
use App\Models\OtpRequest;

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
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@(student\\.smktelkom-lpg\\.sch\\.id|smktelkom-lpg\\.sch\\.id)$/i'],
            'keterangan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::warning('Validasi gagal', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $siswa = MasterSiswa::findOrFail($request->siswa_id);

            if ($siswa->email && strtolower($siswa->email) !== strtolower($request->email)) {
                return back()->withErrors(['email' => 'Email tidak sesuai dengan data siswa terdaftar.'])->withInput();
            }

            $otp = OtpRequest::where('siswa_id', $siswa->id)
                ->where('is_verified', true)
                ->latest()
                ->first();

            if (!$otp || $otp->isExpired()) {
                $otpCode = rand(100000, 999999);
                OtpRequest::create([
                    'siswa_id' => $siswa->id,
                    'otp_code' => $otpCode,
                    'expires_at' => now()->addMinutes(5),
                ]);

                $wa = app(WhatsAppService::class);
                $nomor = '62' . ltrim($request->no_hp, '0');
                $pesan = "Kode OTP untuk reset akun Google Anda adalah: *$otpCode*\nBerlaku 5 menit.\n\n- SMK Telkom Lampung";
                $wa->sendMessage($nomor, $pesan);

                session([
                    'otp_siswa_id' => $siswa->id,
                    'otp_no_hp' => $request->no_hp,
                    'otp_email' => $request->email,
                    'otp_keterangan' => $request->keterangan,
                ]);

                return redirect()->route('pengajuan-google.verify-otp-form')
                    ->with('success', 'OTP telah dikirim ke WhatsApp Anda.');
            }

            return redirect()->route('pengajuan-google.set-password', $siswa->id);
        } catch (\Exception $e) {
            Log::error('Terjadi exception saat store pengajuan', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function verifyOtpForm(Request $request)
    {
        $siswaId = session('otp_siswa_id') ?? $request->get('siswa_id');
        $siswa = MasterSiswa::findOrFail($siswaId);
        return view('public.pengajuan-google.verify-otp', compact('siswa'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:master_siswas,id',
            'otp_code' => 'required'
        ]);

        $siswa = MasterSiswa::findOrFail($request->siswa_id);

        $otp = OtpRequest::where('siswa_id', $siswa->id)
            ->where('otp_code', $request->otp_code)
            ->where('is_verified', false)
            ->latest()
            ->first();

        if (!$otp || $otp->isExpired()) {
            return redirect()
                ->route('pengajuan-google.verify-otp-form', ['siswa_id' => $siswa->id])
                ->withErrors(['otp_code' => 'Kode OTP tidak valid atau sudah kadaluarsa.'])
                ->withInput();
        }

        $otp->update(['is_verified' => true]);

        $siswa->update([
            'no_hp' => session('otp_no_hp'),
            'email' => session('otp_email'),
        ]);

        $pengajuan = PengajuanResetGoogle::create([
            'id' => Str::uuid(),
            'siswa_id' => $siswa->id,
            'keterangan' => session('otp_keterangan', 'Permintaan reset akun Google'),
            'status_pengajuan' => true,
            'status' => true,
        ]);

        session()->forget(['otp_siswa_id', 'otp_email', 'otp_no_hp', 'otp_keterangan']);

        return view('public.pengajuan-google.set-password', compact('siswa', 'pengajuan'));
    }

    public function setPasswordForm($id)
    {
        $pengajuan = PengajuanResetGoogle::with('siswa')->findOrFail($id);
        $siswa = $pengajuan->siswa;
        return view('public.pengajuan-google.set-password', compact('siswa', 'pengajuan'));
    }

    public function updatePassword($id, Request $request, WhatsAppService $wa)
    {
        Log::info('[Reset Password] Masuk ke updatePassword', [
            'pengajuan_id' => $id,
            'request' => $request->only('password', 'password_confirmation')
        ]);

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('pengajuan-google.set-password', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $pengajuan = PengajuanResetGoogle::with('siswa')->findOrFail($id);
        $siswa = $pengajuan->siswa;

        if (!$siswa->email) {
            Log::error('[Reset Password] Email siswa kosong', [
                'siswa_id' => $siswa->id,
                'nama' => $siswa->nama,
            ]);

            return redirect()
                ->route('pengajuan-google.set-password', $id)
                ->with('error', 'Email siswa belum tersedia. Tidak dapat melakukan reset password.');
        }

        try {
            $googleService = new GoogleWorkspaceService();
            $googleService->resetPasswordById($siswa->email, $request->password);

            $pengajuan->update(['status_pengajuan' => false]);

            ResponsePengajuanResetGoogle::create([
                'pengajuan_google_id' => $pengajuan->id,
                'email_baru' => $siswa->email,
                'password_baru' => $request->password,
                'status' => true,
                'sudah_kirim_wa' => true,
                'waktu_kirim_wa' => now(),
            ]);

            $noHp = ltrim($siswa->no_hp, '0');
            $nomor = '62' . $noHp;
            $pesan = "✅ Hai {$siswa->nama},\nPassword akun Google-mu berhasil direset:\n\n📧 Email: *{$siswa->email}*\n🔑 Password Baru: *{$request->password}*\n\nSilakan login dan selalu menjaga keamanan akun. Terima kasih! 🙌\n\n *-IT SMK Telkom Lampung*";

            $wa->sendMessage($nomor, $pesan);

            return redirect()->route('pengajuan-google.resume', $pengajuan->id)
                ->with('success', 'Password berhasil direset dan notifikasi WA dikirim.')
                ->with('new_password', $request->password);
        } catch (\Exception $e) {
            Log::error('[Reset Password] Gagal', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('pengajuan-google.set-password', $id)
                ->with('error', 'Gagal mereset password: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function resume($id)
    {
        $data = PengajuanResetGoogle::with('siswa')->findOrFail($id);
        return view('public.pengajuan-google.resume', compact('data'));
    }
}
