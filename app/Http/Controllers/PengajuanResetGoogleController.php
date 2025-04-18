<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\PengajuanResetGoogle;
use App\Models\MasterSiswa;

class PengajuanResetGoogleController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanResetGoogle::with(['siswa', 'response']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('siswa', fn($s) => $s->where('nama', 'like', "%$q%"));
        }

        if ($request->filled('status_pengajuan')) {
            $query->where('status_pengajuan', $request->status_pengajuan);
        }

        if ($request->filled('status_wa')) {
            $statusWa = $request->status_wa;

            $query->whereHas('response', function ($q) use ($statusWa) {
                $q->where('sudah_kirim_wa', $statusWa);
            });
        }

        $data = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('pengajuan_google.index', compact('data'));
    }


    public function create()
    {
        $siswas = MasterSiswa::orderBy('nama')->get();
        return view('pengajuan_google.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:master_siswas,id',
            'keterangan' => 'required|string|max:255',
            'status_pengajuan' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            PengajuanResetGoogle::create([
                'id' => Str::uuid(),
                'siswa_id' => $request->siswa_id,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => $request->status_pengajuan,
                'status' => true,
            ]);
            return redirect()->route('pengajuan-google.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = PengajuanResetGoogle::findOrFail($id);
        $siswas = MasterSiswa::orderBy('nama')->get();
        return view('pengajuan_google.edit', compact('data', 'siswas'));
    }

    public function update(Request $request, $id)
    {
        $data = PengajuanResetGoogle::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:master_siswas,id',
            'keterangan' => 'required|string|max:255',
            'status_pengajuan' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data->update([
                'siswa_id' => $request->siswa_id,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => $request->status_pengajuan,
            ]);
            return redirect()->route('pengajuan-google.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            PengajuanResetGoogle::findOrFail($id)->delete();
            return redirect()->route('pengajuan-google.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function formReset($id)
    {
        $pengajuan = PengajuanResetGoogle::with('siswa')->findOrFail($id);
        return view('pengajuan_google.reset', compact('pengajuan'));
    }

    public function storeReset(Request $request, $id)
    {
        $request->validate([
            'email_baru' => 'required|email',
            'password_baru' => 'required|string|min:4|max:100',
        ]);

        try {
            $pengajuan = PengajuanResetGoogle::with('siswa')->findOrFail($id);

            // Simpan ke tabel response
            \App\Models\ResponsePengajuanResetGoogle::create([
                'id' => \Str::uuid(),
                'pengajuan_google_id' => $pengajuan->id,
                'email_baru' => $request->email_baru,
                'password_baru' => $request->password_baru,
                'status' => true,
            ]);

            // Update email siswa
            $pengajuan->siswa->update(['email' => $request->email_baru]);

            // Ubah status_pengajuan jadi false
            $pengajuan->update(['status_pengajuan' => false]);

            return redirect()->route('admin.pengajuan-google.index')->with('success', 'Response berhasil disimpan dan email siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan response: ' . $e->getMessage());
        }
    }

    public function markKirimWa($id)
    {
        try {
            $pengajuan = PengajuanResetGoogle::with('response')->findOrFail($id);

            if ($pengajuan->response) {
                $pengajuan->response->update([
                    'sudah_kirim_wa' => true,
                    'waktu_kirim_wa' => now(),
                ]);
            }

            return redirect()->route('admin.pengajuan-google.index')->with('success', 'Status kirim WA berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status kirim WA: ' . $e->getMessage());
        }
    }
}
