<?php

namespace App\Services\Dashboard;

use App\Models\PengajuanResetGoogle;
use App\Models\PengajuanResetMylms;
use App\Models\PengajuanResetIgracias;
use App\Models\MasterKelas;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    /**
     * Mengambil semua data yang dibutuhkan untuk dashboard admin.
     */
    public function getDashboardData(): array
    {
        try {
            // Total pengajuan masing-masing
            $jumlahGoogle = PengajuanResetGoogle::count();
            $jumlahMylms = PengajuanResetMylms::count();
            $jumlahIgracias = PengajuanResetIgracias::count();

            // Statistik harian 30 hari terakhir
            $tanggal = collect(range(0, 29))->map(function ($i) {
                return Carbon::now()->subDays($i)->format('Y-m-d');
            })->reverse();

            $dataGoogle = PengajuanResetGoogle::where('created_at', '>=', Carbon::now()->subDays(30))->get();
            $dataMylms = PengajuanResetMylms::where('created_at', '>=', Carbon::now()->subDays(30))->get();
            $dataIgracias = PengajuanResetIgracias::where('created_at', '>=', Carbon::now()->subDays(30))->get();

            // Pemetaan grafik berdasarkan tanggal
            $grafik = $tanggal->map(function ($tgl) use ($dataGoogle, $dataMylms, $dataIgracias) {
                return [
                    'tanggal' => $tgl,
                    'google' => $dataGoogle->whereBetween('created_at', [$tgl . ' 00:00:00', $tgl . ' 23:59:59'])->count(),
                    'mylms' => $dataMylms->whereBetween('created_at', [$tgl . ' 00:00:00', $tgl . ' 23:59:59'])->count(),
                    'igracias' => $dataIgracias->whereBetween('created_at', [$tgl . ' 00:00:00', $tgl . ' 23:59:59'])->count(),
                ];
            });

            // Ambil data per kelas beserta jumlah pengajuannya
            $kelasData = MasterKelas::withCount([
                'pengajuanResetGoogle',
                'pengajuanResetMylms',
                'pengajuanResetIgracias',
            ])->get();

            // Jumlah pengajuan belum direspon
            $belumResponGoogle = PengajuanResetGoogle::where('status_pengajuan', true)->count();
            $belumResponMylms = PengajuanResetMylms::where('status_pengajuan', true)->count();
            $belumResponIgracias = PengajuanResetIgracias::where('status_pengajuan', true)->count();

            $totalNotif = $belumResponGoogle + $belumResponMylms + $belumResponIgracias;

            // Return semua data dalam array
            return compact(
                'jumlahGoogle',
                'jumlahMylms',
                'jumlahIgracias',
                'grafik',
                'kelasData',
                'belumResponGoogle',
                'belumResponMylms',
                'belumResponIgracias',
                'totalNotif'
            );
        } catch (\Exception $e) {
            // Logging kesalahan untuk keperluan audit dan debugging
            Log::error('[DashboardService] Gagal memuat data dashboard', ['error' => $e->getMessage()]);
            return [];
        }
    }
}
