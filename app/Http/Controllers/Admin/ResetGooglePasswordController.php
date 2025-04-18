<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoogleWorkspaceService;
use App\Services\WhatsAppService;

class ResetGooglePasswordController extends Controller
{
    public function showForm()
    {
        return view('admin.reset-password-google');
    }

    // public function reset(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);

    //     $googleService = new GoogleWorkspaceService();

    //     $result = $googleService->resetPassword($request->email, $request->password);

    //     if ($result) {
    //         return back()->with('success', 'Password berhasil direset untuk akun: ' . $request->email);
    //     } else {
    //         return back()->with('error', 'Gagal mereset password. Periksa log atau koneksi ke Google API.');
    //     }
    // }

    public function reset(Request $request, WhatsAppService $wa)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $googleService = new GoogleWorkspaceService();
        $result = $googleService->resetPassword($request->email, $request->password);

        if ($result) {
            // 💬 Kirim notifikasi WhatsApp
            // Ganti nomor sesuai dengan sistemmu (bisa ambil dari DB atau input request)
            $nomorWhatsapp = '6282185903635'; // 👈 ganti dengan dinamis nanti
            $pesan = "✅ Hai! Password akun Google-mu dengan email *{$request->email}* telah berhasil direset.\nPassword baru: *{$request->password}*\n\n- Admin SMK Telkom";

            $wa->sendMessage($nomorWhatsapp, $pesan);

            return back()->with('success', 'Password berhasil direset dan notifikasi WhatsApp dikirim.');
        } else {
            return back()->with('error', 'Gagal mereset password. Periksa log atau koneksi ke Google API.');
        }
    }
}
