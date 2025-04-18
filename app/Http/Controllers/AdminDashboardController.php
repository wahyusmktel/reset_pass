<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanResetGoogle;
use App\Models\PengajuanResetMylms;
use App\Models\PengajuanResetIgracias;
use Carbon\Carbon;
use App\Models\MasterKelas;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahGoogle = PengajuanResetGoogle::count();
        $jumlahMylms = PengajuanResetMylms::count();
        $jumlahIgracias = PengajuanResetIgracias::count();

        // Statistik 30 hari terakhir (pengajuan per hari)
        $tanggal = collect(range(0, 29))->map(function ($i) {
            return Carbon::now()->subDays($i)->format('Y-m-d');
        })->reverse();

        $dataGoogle = PengajuanResetGoogle::where('created_at', '>=', Carbon::now()->subDays(30))->get();
        $dataMylms = PengajuanResetMylms::where('created_at', '>=', Carbon::now()->subDays(30))->get();
        $dataIgracias = PengajuanResetIgracias::where('created_at', '>=', Carbon::now()->subDays(30))->get();

        $grafik = $tanggal->map(function ($tgl) use ($dataGoogle, $dataMylms, $dataIgracias) {
            return [
                'tanggal' => $tgl,
                'google' => $dataGoogle->whereBetween('created_at', [$tgl . ' 00:00:00', $tgl . ' 23:59:59'])->count(),
                'mylms' => $dataMylms->whereBetween('created_at', [$tgl . ' 00:00:00', $tgl . ' 23:59:59'])->count(),
                'igracias' => $dataIgracias->whereBetween('created_at', [$tgl . ' 00:00:00', $tgl . ' 23:59:59'])->count(),
            ];
        });

        // Ambil data pengajuan per kelas
        $kelasData = MasterKelas::withCount([
            'pengajuanResetGoogle',
            'pengajuanResetMylms',
            'pengajuanResetIgracias',
        ])->get();

        $belumResponGoogle = \App\Models\PengajuanResetGoogle::where('status_pengajuan', true)->count();
        $belumResponMylms = \App\Models\PengajuanResetMylms::where('status_pengajuan', true)->count();
        $belumResponIgracias = \App\Models\PengajuanResetIgracias::where('status_pengajuan', true)->count();

        $totalNotif = $belumResponGoogle + $belumResponMylms + $belumResponIgracias;

        return view('admin.dashboard', compact('jumlahGoogle', 'jumlahMylms', 'jumlahIgracias', 'grafik', 'kelasData', 'belumResponGoogle', 'belumResponMylms', 'belumResponIgracias', 'totalNotif'));
    }
}
