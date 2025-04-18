<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\MasterJurusan;

class MasterJurusanController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterJurusan::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama_jurusan', 'like', "%$q%")
                ->orWhere('kode_jurusan', 'like', "%$q%");
        }

        $jurusans = $query->orderBy('nama_jurusan')->paginate(10)->withQueryString();

        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:50|unique:master_jurusans',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            MasterJurusan::create([
                'id' => Str::uuid(),
                'nama_jurusan' => $request->nama_jurusan,
                'kode_jurusan' => $request->kode_jurusan,
                'status' => true,
            ]);

            return redirect()->route('jurusan.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $jurusan = MasterJurusan::findOrFail($id);
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $jurusan = MasterJurusan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:50|unique:master_jurusans,kode_jurusan,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $jurusan->update([
                'nama_jurusan' => $request->nama_jurusan,
                'kode_jurusan' => $request->kode_jurusan,
            ]);

            return redirect()->route('jurusan.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            MasterJurusan::findOrFail($id)->delete();
            return redirect()->route('jurusan.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
