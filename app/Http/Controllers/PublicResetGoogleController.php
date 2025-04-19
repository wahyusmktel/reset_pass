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
use Illuminate\Support\Facades\Cache;


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

            // Validasi bahwa email cocok
            if ($siswa->email && strtolower($siswa->email) !== strtolower($request->email)) {
                return back()->withErrors(['email' => 'Email tidak sesuai dengan data siswa terdaftar.'])->withInput();
            }

            // ✅ Cek OTP terakhir (harus ada dan valid)
            $otp = OtpRequest::where('siswa_id', $siswa->id)
                ->where('is_verified', true)
                ->latest()
                ->first();

            if (!$otp || $otp->isExpired()) {
                // Generate dan kirim OTP jika belum ada atau kadaluarsa
                $otpCode = rand(100000, 999999);
                OtpRequest::create([
                    'siswa_id' => $siswa->id,
                    'otp_code' => $otpCode,
                    'expires_at' => now()->addMinutes(5),
                ]);

                $wa = app(WhatsAppService::class); // Panggil service secara manual
                $nomor = '62' . ltrim($siswa->no_hp, '0');
                $pesan = "Kode OTP untuk reset akun Google Anda adalah: *$otpCode*\nBerlaku 5 menit.\n\n- SMK Telkom Lampung";
                $wa->sendMessage($nomor, $pesan);

                return redirect()->route('pengajuan-google.verify-otp-form')
                    ->with('otp_siswa_id', $siswa->id)
                    ->with('success', 'OTP berhasil dikirim ke WhatsApp Anda. Silakan verifikasi.');
            }

            // Update data siswa
            $siswa->update([
                'no_hp' => $request->no_hp
                // 'email' => $request->email
            ]);
            Log::info('No HP siswa diperbarui', ['no_hp' => $request->no_hp]);

            // Simpan pengajuan
            $pengajuan = PengajuanResetGoogle::create([
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => true,
                'status' => true,
            ]);
            Log::info('Pengajuan berhasil disimpan', ['id_pengajuan' => $pengajuan->id]);

            // Arahkan ke halaman set password
            return view('public.pengajuan-google.set-password', compact('siswa', 'pengajuan'));
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

    public function setPasswordForm($id)
    {
        $pengajuan = PengajuanResetGoogle::with('siswa')->findOrFail($id);
        $siswa = $pengajuan->siswa;

        return view('public.pengajuan-google.set-password', compact('siswa', 'pengajuan'));
    }

    public function updatePassword($id, Request $request, WhatsAppService $wa)
    {
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

        try {
            // ✅ Reset password di Google Workspace
            $googleService = new GoogleWorkspaceService();
            $googleService->resetPasswordById($siswa->email, $request->password);

            // ✅ Update status pengajuan
            $pengajuan->update(['status_pengajuan' => false]);

            // ✅ Simpan response
            ResponsePengajuanResetGoogle::create([
                'pengajuan_google_id' => $pengajuan->id,
                'email_baru' => $siswa->email,
                'password_baru' => $request->password,
                'status' => true,
                'sudah_kirim_wa' => true,
                'waktu_kirim_wa' => now(),
            ]);

            // ✅ Kirim notifikasi WhatsApp
            $noHp = ltrim($siswa->no_hp, '0');
            $nomor = '62' . $noHp;

            $pesan = "✅ Hai {$siswa->nama},\nPassword akun Google-mu berhasil direset:\n\n📧 Email: *{$siswa->email}*\n🔑 Password Baru: *{$request->password}*\n\nSilakan login dan selalu menjaga keamanan akun. Terima kasih! 🙌\n\n *-IT SMK Telkom Lampung*";

            $wa->sendMessage($nomor, $pesan);

            return redirect()->route('pengajuan-google.resume', $pengajuan->id)
                ->with('success', 'Password berhasil direset dan notifikasi WA dikirim.')
                ->with('new_password', $request->password);
        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->route('pengajuan-google.set-password', $id)
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function requestOtp(Request $request, WhatsAppService $wa)
    {
        $request->validate([
            'siswa_id' => 'required|exists:master_siswas,id',
            'no_hp' => 'required|regex:/^(\+62|62|08)[0-9]{8,13}$/'
        ]);

        $siswa = MasterSiswa::findOrFail($request->siswa_id);

        $otp = rand(100000, 999999);

        // Simpan OTP ke DB
        OtpRequest::create([
            'siswa_id' => $siswa->id,
            'otp_code' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Kirim ke WhatsApp
        $nomor = '62' . ltrim($request->no_hp, '0');
        $pesan = "Kode OTP untuk reset akun Google Anda adalah: *$otp*\nBerlaku 5 menit.\n\n- SMK Telkom Lampung";
        $wa->sendMessage($nomor, $pesan);

        // Redirect ke form verifikasi OTP
        return redirect()->route('pengajuan-google.verify-otp-form')
            ->with('otp_siswa_id', $siswa->id);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:master_siswas,id',
            'otp_code' => 'required'
        ]);

        $otp = OtpRequest::where('siswa_id', $request->siswa_id)
            ->where('otp_code', $request->otp_code)
            ->where('is_verified', false)
            ->latest()
            ->first();

        if (!$otp || $otp->isExpired()) {
            return redirect()
                ->route('pengajuan-google.verify-otp-form', ['siswa_id' => $request->siswa_id])
                ->withErrors(['otp_code' => 'Kode OTP tidak valid atau sudah kadaluarsa.'])
                ->withInput();
        }

        // Tandai OTP terverifikasi
        $otp->update(['is_verified' => true]);

        $siswa = MasterSiswa::find($request->siswa_id);
        return view('public.pengajuan-google.create', compact('siswa'));
    }

    public function verifyOtpForm(Request $request)
    {
        $siswaId = session('otp_siswa_id') ?? $request->get('siswa_id');
        $siswa = MasterSiswa::findOrFail($siswaId);

        return view('public.pengajuan-google.verify-otp', compact('siswa'));
    }
}
