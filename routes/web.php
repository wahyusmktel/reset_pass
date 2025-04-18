<?php

use App\Http\Controllers\Admin\GoogleUserController;
use App\Http\Controllers\Admin\MappingSiswaGoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterSiswaController;
use App\Http\Controllers\MasterJurusanController;
use App\Http\Controllers\MasterKelasController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\GenerateAkunSiswaController;
use App\Http\Controllers\PengajuanResetGoogleController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicResetGoogleController;
use App\Http\Controllers\PublicResetMyLmsController;
use App\Http\Controllers\PublicResetIgraciasController;
use App\Http\Controllers\PengajuanResetMylmsController;
use App\Http\Controllers\PengajuanResetIgraciasController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ImportSiswaController;
use App\Http\Controllers\Admin\ResetGooglePasswordController;
use Illuminate\Support\Facades\Http;

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/pengajuan-reset-google', [PublicResetGoogleController::class, 'create'])->name('pengajuan-google.create');
Route::post('/pengajuan-reset-google', [PublicResetGoogleController::class, 'store'])->name('pengajuan-google.store');
Route::get('/pengajuan-reset-google/resume/{id}', [PublicResetGoogleController::class, 'resume'])->name('pengajuan-google.resume');

Route::get('/pengajuan-reset-mylms', [PublicResetMyLmsController::class, 'create'])->name('pengajuan-mylms.create');
Route::post('/pengajuan-reset-mylms', [PublicResetMyLmsController::class, 'store'])->name('pengajuan-mylms.store');
Route::get('/pengajuan-reset-mylms/resume/{id}', [PublicResetMyLmsController::class, 'resume'])->name('pengajuan-mylms.resume');

Route::get('/pengajuan-reset-igracias', [PublicResetIgraciasController::class, 'create'])->name('pengajuan-igracias.create');
Route::post('/pengajuan-reset-igracias', [PublicResetIgraciasController::class, 'store'])->name('pengajuan-igracias.store');
Route::get('/pengajuan-reset-igracias/resume/{id}', [PublicResetIgraciasController::class, 'resume'])->name('pengajuan-igracias.resume');

Route::get('/ajax/siswa', function (\Illuminate\Http\Request $request) {
    $search = $request->q;
    return \App\Models\MasterSiswa::where('nama', 'like', "%$search%")
        ->orWhere('nis', 'like', "%$search%")
        ->select('id', 'nama', 'nis')
        ->limit(20)
        ->get()
        ->map(function ($siswa) {
            return [
                'id' => $siswa->id,
                'text' => $siswa->nama . ' (' . $siswa->nis . ')',
            ];
        });
})->name('ajax.siswa');

// Prefix admin + middleware role:admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');

    // Master Siswa
    Route::get('/siswa', [MasterSiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [MasterSiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [MasterSiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [MasterSiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [MasterSiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [MasterSiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/siswa/generate-akun-masal', [MasterSiswaController::class, 'generateAkunMasal'])->name('siswa.generate-akun-masal');
    Route::post('/siswa/{id}/reset-password', [MasterSiswaController::class, 'resetPassword'])->name('siswa.reset-password');
    Route::get('/siswa/import', [ImportSiswaController::class, 'form'])->name('siswa.import.form');
    Route::post('/siswa/import', [ImportSiswaController::class, 'import'])->name('siswa.import.store');


    // Jurusan
    Route::get('/jurusan', [MasterJurusanController::class, 'index'])->name('jurusan.index');
    Route::get('/jurusan/create', [MasterJurusanController::class, 'create'])->name('jurusan.create');
    Route::post('/jurusan', [MasterJurusanController::class, 'store'])->name('jurusan.store');
    Route::get('/jurusan/{id}/edit', [MasterJurusanController::class, 'edit'])->name('jurusan.edit');
    Route::put('/jurusan/{id}', [MasterJurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{id}', [MasterJurusanController::class, 'destroy'])->name('jurusan.destroy');

    // Kelas
    Route::get('/kelas', [MasterKelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [MasterKelasController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [MasterKelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{id}/edit', [MasterKelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [MasterKelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [MasterKelasController::class, 'destroy'])->name('kelas.destroy');

    // Rombel
    Route::get('/rombel', [RombelController::class, 'index'])->name('rombel.index');
    Route::get('/rombel/create', [RombelController::class, 'create'])->name('rombel.create');
    Route::post('/rombel', [RombelController::class, 'store'])->name('rombel.store');
    Route::get('/rombel/{id}/edit', [RombelController::class, 'edit'])->name('rombel.edit');
    Route::put('/rombel/{id}', [RombelController::class, 'update'])->name('rombel.update');
    Route::delete('/rombel/{id}', [RombelController::class, 'destroy'])->name('rombel.destroy');
    Route::get('/rombel/per-kelas', [RombelController::class, 'siswaPerRombel'])->name('rombel.per-kelas');
    Route::get('/rombel/generate', [RombelController::class, 'generate'])->name('rombel.generate');

    // Generate Akun Siswa Manual
    Route::get('/generate-akun-siswa', [GenerateAkunSiswaController::class, 'index'])->name('akun-siswa.index');
    Route::post('/generate-akun-siswa', [GenerateAkunSiswaController::class, 'generate'])->name('akun-siswa.generate');

    // Pengajuan Reset Google
    Route::get('/pengajuan-google', [PengajuanResetGoogleController::class, 'index'])->name('admin.pengajuan-google.index');
    Route::get('/pengajuan-google/create', [PengajuanResetGoogleController::class, 'create'])->name('admin.pengajuan-google.create');
    Route::post('/pengajuan-google', [PengajuanResetGoogleController::class, 'store'])->name('admin.pengajuan-google.store');
    Route::get('/pengajuan-google/{id}/edit', [PengajuanResetGoogleController::class, 'edit'])->name('pengajuan-google.edit');
    Route::put('/pengajuan-google/{id}', [PengajuanResetGoogleController::class, 'update'])->name('pengajuan-google.update');
    Route::delete('/pengajuan-google/{id}', [PengajuanResetGoogleController::class, 'destroy'])->name('pengajuan-google.destroy');
    Route::get('/pengajuan-google/{id}/reset', [PengajuanResetGoogleController::class, 'formReset'])->name('pengajuan-google.response.form');
    Route::post('/pengajuan-google/{id}/reset', [PengajuanResetGoogleController::class, 'storeReset'])->name('pengajuan-google.response.store');
    Route::post('/pengajuan-google/{id}/kirim-wa', [PengajuanResetGoogleController::class, 'markKirimWa'])->name('pengajuan-google.kirim-wa');

    Route::get('/pengajuan-mylms', [PengajuanResetMylmsController::class, 'index'])->name('pengajuan-mylms.index');
    Route::get('/pengajuan-mylms/{id}/reset', [PengajuanResetMylmsController::class, 'formReset'])->name('pengajuan-mylms.response.form');
    Route::post('/pengajuan-mylms/{id}/reset', [PengajuanResetMylmsController::class, 'storeReset'])->name('pengajuan-mylms.response.store');
    Route::post('/pengajuan-mylms/{id}/kirim-wa', [PengajuanResetMylmsController::class, 'markKirimWa'])->name('pengajuan-mylms.kirim-wa');

    Route::get('/pengajuan-igracias', [PengajuanResetIgraciasController::class, 'index'])->name('pengajuan-igracias.index');
    Route::get('/pengajuan-igracias/{id}/reset', [PengajuanResetIgraciasController::class, 'formReset'])->name('pengajuan-igracias.response.form');
    Route::post('/pengajuan-igracias/{id}/reset', [PengajuanResetIgraciasController::class, 'storeReset'])->name('pengajuan-igracias.response.store');
    Route::post('/pengajuan-igracias/{id}/kirim-wa', [PengajuanResetIgraciasController::class, 'markKirimWa'])->name('pengajuan-igracias.kirim-wa');

    Route::get('/reset-password-google', [ResetGooglePasswordController::class, 'showForm'])->name('admin.reset-google-form');
    Route::post('/reset-password-google', [ResetGooglePasswordController::class, 'reset'])->name('admin.reset-google-password');

    Route::get('/google-users', [GoogleUserController::class, 'index'])->name('admin.google.users');
    Route::get('/google-users/{id}', [GoogleUserController::class, 'show'])->name('admin.google-users.show');
    Route::post('/google-users/{id}/reset', [GoogleUserController::class, 'reset'])->name('admin.google-users.reset');

    Route::get('/mapping-siswa', [MappingSiswaGoogleController::class, 'index'])->name('admin.mapping-siswa.index');
    Route::post('/mapping-siswa', [MappingSiswaGoogleController::class, 'store'])->name('admin.mapping-siswa.store');

    // Route::get('/test-whapify', function () {
    //     $response = Http::asForm()->post('https://whapify.id/api/send/whatsapp', [
    //         'secret' => env('WHAPIFY_SECRET'),
    //         'account' => env('WHAPIFY_ACCOUNT_ID'),
    //         'recipient' => '6282185903635', // Ganti ke nomor tujuan
    //         'type' => 'text',
    //         'message' => 'Halo! Ini uji coba dari Laravel ke Whapify 🚀'
    //     ]);

    //     return $response->successful()
    //         ? 'Pesan berhasil dikirim! Respons: ' . $response->body()
    //         : 'Gagal kirim pesan. HTTP ' . $response->status() . ': ' . $response->body();
    // });
});
