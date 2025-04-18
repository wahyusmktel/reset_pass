<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\MasterKelas;
use App\Models\MasterJurusan;

class MasterKelasController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterKelas::with('jurusan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama_kelas', 'like', "%$q%")
                ->orWhere('tingkat_kelas', 'like', "%$q%");
        }

        $kelas = $query->orderBy('tingkat_kelas')->paginate(10)->withQueryString();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = MasterJurusan::orderBy('nama_jurusan')->get();
        return view('kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255',
            'tingkat_kelas' => 'required|string',
            'jurusan_id' => 'required|exists:master_jurusans,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            MasterKelas::create([
                'id' => Str::uuid(),
                'nama_kelas' => $request->nama_kelas,
                'tingkat_kelas' => $request->tingkat_kelas,
                'jurusan_id' => $request->jurusan_id,
                'status' => true,
            ]);

            return redirect()->route('kelas.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kelas = MasterKelas::findOrFail($id);
        $jurusans = MasterJurusan::orderBy('nama_jurusan')->get();
        return view('kelas.edit', compact('kelas', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $kelas = MasterKelas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255',
            'tingkat_kelas' => 'required|string',
            'jurusan_id' => 'required|exists:master_jurusans,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
                'tingkat_kelas' => $request->tingkat_kelas,
                'jurusan_id' => $request->jurusan_id,
            ]);

            return redirect()->route('kelas.index')->with('success', 'Data berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            MasterKelas::findOrFail($id)->delete();
            return redirect()->route('kelas.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
