<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Rombel;
use App\Models\MasterSiswa;
use App\Models\MasterKelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RombelController extends Controller
{
    public function index(Request $request)
    {
        $query = Rombel::with(['siswa', 'kelas']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('siswa', fn($s) => $s->where('nama', 'like', "%$q%"))
                ->orWhereHas('kelas', fn($k) => $k->where('nama_kelas', 'like', "%$q%"));
        }

        $rombels = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('rombel.index', compact('rombels'));
    }

    public function create()
    {
        // Ambil ID siswa yang sudah punya rombel
        $siswaSudahTerdaftar = Rombel::pluck('siswa_id')->toArray();

        // Ambil siswa yang belum punya rombel saja
        $siswas = MasterSiswa::whereNotIn('id', $siswaSudahTerdaftar)
            ->orderBy('nama')->get();

        $kelas = MasterKelas::orderBy('nama_kelas')->get();

        return view('rombel.create', compact('siswas', 'kelas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:master_siswas,id|unique:rombels,siswa_id',
            'kelas_id' => 'required|exists:master_kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Rombel::create([
                'id' => Str::uuid(),
                'siswa_id' => $request->siswa_id,
                'kelas_id' => $request->kelas_id,
                'status' => true,
            ]);

            return redirect()->route('rombel.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $rombel = Rombel::findOrFail($id);

        // Ambil semua siswa yang belum punya rombel
        $siswaSudahTerdaftar = Rombel::where('id', '!=', $id)->pluck('siswa_id')->toArray();

        // Ambil siswa yang belum punya rombel atau siswa yang sedang di-edit
        $siswas = MasterSiswa::whereNotIn('id', $siswaSudahTerdaftar)
            ->orWhere('id', $rombel->siswa_id)
            ->orderBy('nama')->get();

        $kelas = MasterKelas::orderBy('nama_kelas')->get();

        return view('rombel.edit', compact('rombel', 'siswas', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $rombel = Rombel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:master_siswas,id|unique:rombels,siswa_id,' . $rombel->id,
            'kelas_id' => 'required|exists:master_kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $rombel->update([
                'siswa_id' => $request->siswa_id,
                'kelas_id' => $request->kelas_id,
            ]);

            return redirect()->route('rombel.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Rombel::findOrFail($id)->delete();
            return redirect()->route('rombel.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function siswaPerRombel(Request $request)
    {
        $kelasList = MasterKelas::with('jurusan')->orderBy('tingkat_kelas')->get();
        $selectedKelasId = $request->kelas_id;

        $rombels = collect();
        $kelasTerpilih = null;

        if ($selectedKelasId) {
            $kelasTerpilih = MasterKelas::with(['jurusan', 'rombels.siswa'])->find($selectedKelasId);
            $rombels = $kelasTerpilih?->rombels ?? collect();
        }

        return view('rombel.per_kelas', compact('kelasList', 'rombels', 'kelasTerpilih', 'selectedKelasId'));
    }

    public function generate()
    {
        try {
            DB::beginTransaction();
            Log::info('[ROMBEL GENERATE] Mulai proses generate rombel');

            $siswas = MasterSiswa::whereNotNull('tmp_rombel')->get();
            Log::info('[ROMBEL GENERATE] Jumlah siswa ditemukan: ' . $siswas->count());

            $kelasMap = MasterKelas::pluck('id', 'nama_kelas');
            Log::info('[ROMBEL GENERATE] Data kelas terload', $kelasMap->toArray());

            $generated = 0;

            foreach ($siswas as $siswa) {
                $namaKelas = $siswa->tmp_rombel;
                Log::info("[ROMBEL GENERATE] Proses siswa: {$siswa->nama} | tmp_rombel: {$namaKelas}");

                if (isset($kelasMap[$namaKelas])) {
                    $kelasId = $kelasMap[$namaKelas];
                    Log::info("[ROMBEL GENERATE] Kelas cocok ditemukan: $namaKelas → $kelasId");

                    $exists = Rombel::where('siswa_id', $siswa->id)->exists();
                    if (!$exists) {
                        Rombel::create([
                            'id' => Str::uuid(),
                            'siswa_id' => $siswa->id,
                            'kelas_id' => $kelasId,
                            'status' => true
                        ]);
                        Log::info("[ROMBEL GENERATE] Rombel dibuat untuk siswa: {$siswa->nama}");
                        $generated++;
                    } else {
                        Log::info("[ROMBEL GENERATE] Rombel sudah ada untuk siswa: {$siswa->nama}, dilewati");
                    }
                } else {
                    Log::warning("[ROMBEL GENERATE] Tidak ditemukan nama_kelas untuk tmp_rombel: {$namaKelas}");
                }
            }

            DB::commit();
            Log::info("[ROMBEL GENERATE] Sukses generate {$generated} rombel");
            return redirect()->route('rombel.index')->with('success', "$generated rombel berhasil digenerate!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[ROMBEL GENERATE] Gagal: ' . $e->getMessage());
            return redirect()->route('rombel.index')->with('error', 'Gagal generate: ' . $e->getMessage());
        }
    }
}
