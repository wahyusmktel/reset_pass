<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanResetIgracias;
use App\Models\ResponsePengajuanResetIgracias;
use Illuminate\Support\Str;

class PengajuanResetIgraciasController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanResetIgracias::with(['siswa', 'response']);

        if ($request->filled('q')) {
            $query->whereHas(
                'siswa',
                fn($q) =>
                $q->where('nama', 'like', '%' . $request->q . '%')
            );
        }

        if ($request->filled('status_pengajuan')) {
            $query->where('status_pengajuan', $request->status_pengajuan);
        }

        if ($request->filled('status_wa')) {
            $query->whereHas(
                'response',
                fn($q) =>
                $q->where('sudah_kirim_wa', $request->status_wa)
            );
        }

        $data = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('pengajuan_igracias.index', compact('data'));
    }

    public function formReset($id)
    {
        $pengajuan = PengajuanResetIgracias::with('siswa')->findOrFail($id);
        return view('pengajuan_igracias.reset', compact('pengajuan'));
    }

    public function storeReset(Request $request, $id)
    {
        $request->validate([
            'username_baru' => 'required|string|max:100',
            'password_baru' => 'required|string|min:4|max:100',
        ]);

        $pengajuan = PengajuanResetIgracias::findOrFail($id);

        ResponsePengajuanResetIgracias::create([
            'id' => Str::uuid(),
            'pengajuan_igracias_id' => $pengajuan->id,
            'username_baru' => $request->username_baru,
            'password_baru' => $request->password_baru,
            'status' => true,
        ]);

        $pengajuan->update(['status_pengajuan' => false]);

        return redirect()->route('pengajuan-igracias.index')->with('success', 'Reset akun berhasil disimpan.');
    }

    public function markKirimWa($id)
    {
        $pengajuan = PengajuanResetIgracias::with('response')->findOrFail($id);

        if ($pengajuan->response) {
            $pengajuan->response->update([
                'sudah_kirim_wa' => true,
                'waktu_kirim_wa' => now(),
            ]);
        }

        return redirect()->route('pengajuan-igracias.index')->with('success', 'Status kirim WA diperbarui.');
    }
}
