<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterSiswa;
use App\Services\GoogleWorkspaceService;
use Illuminate\Support\Str;

class MappingSiswaGoogleController extends Controller
{
    public function index(GoogleWorkspaceService $google)
    {
        $siswas = MasterSiswa::whereNull('email')->get(); // hanya yang belum punya email
        $googleUsers = collect($google->listUsers());

        $results = [];

        foreach ($siswas as $siswa) {
            $match = $googleUsers->first(function ($user) use ($siswa) {
                return Str::contains(Str::lower($user['name']), Str::lower($siswa->nama));
            });

            $results[] = [
                'siswa' => $siswa,
                'google' => $match,
            ];
        }

        return view('admin.mapping-siswa.index', compact('results', 'googleUsers'));
    }

    public function store(Request $request)
    {
        $data = $request->input('mapping', []);

        foreach ($data as $siswaId => $email) {
            MasterSiswa::where('id', $siswaId)->update([
                'email' => $email
            ]);
        }

        return back()->with('success', 'Berhasil update email untuk siswa yang dipilih.');
    }
}
