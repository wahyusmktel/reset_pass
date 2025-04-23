<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        // Injeksi service dengan dependency injection
        $this->dashboardService = $dashboardService;

        // Middleware auth dan rate limit harusnya diatur di routes/middleware
    }

    public function index()
    {
        try {
            // Ambil data dari service
            $data = $this->dashboardService->getDashboardData();

            // Validasi jika data kosong akibat error
            if (empty($data)) {
                abort(500, 'Terjadi kesalahan saat memuat dashboard');
            }

            // Tampilkan halaman dashboard
            return view('admin.dashboard', $data);

        } catch (\Throwable $th) {
            // Log error dan redirect dengan pesan aman (tanpa bocorkan internal error ke user)
            Log::critical('[AdminDashboard] Gagal menampilkan dashboard', ['error' => $th->getMessage()]);
            return redirect()->back()->withErrors('Terjadi kesalahan internal saat memuat dashboard.');
        }
    }
}
