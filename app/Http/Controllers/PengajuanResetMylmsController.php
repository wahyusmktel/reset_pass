<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanResetMylms;

class PengajuanResetMylmsController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanResetMylms::with(['siswa', 'response']);

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

        return view('pengajuan_mylms.index', compact('data'));
    }

    public function formReset($id)
    {
        $pengajuan = \App\Models\PengajuanResetMylms::with('siswa')->findOrFail($id);
        return view('pengajuan_mylms.reset', compact('pengajuan'));
    }

    public function storeReset(Request $request, $id)
    {
        $request->validate([
            'username_baru' => 'required|string|max:100',
            'password_baru' => 'required|string|min:4|max:100',
        ]);

        try {
            $pengajuan = \App\Models\PengajuanResetMylms::findOrFail($id);

            \App\Models\ResponsePengajuanResetMylms::create([
                'id' => \Str::uuid(),
                'pengajuan_mylms_id' => $pengajuan->id,
                'username_baru' => $request->username_baru,
                'password_baru' => $request->password_baru,
                'status' => true,
            ]);

            $pengajuan->update(['status_pengajuan' => false]);

            return redirect()->route('pengajuan-mylms.index')->with('success', 'Response berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function markKirimWa($id)
    {
        try {
            $pengajuan = \App\Models\PengajuanResetMylms::with('response')->findOrFail($id);

            if ($pengajuan->response) {
                $pengajuan->response->update([
                    'sudah_kirim_wa' => true,
                    'waktu_kirim_wa' => now(),
                ]);
            }

            return redirect()->route('pengajuan-mylms.index')->with('success', 'Status kirim WA diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
