<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Root route - index page
Route::view('/', 'index')->name('index');

// Public routes (root level templates)
Route::view('/login', 'login')->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
Route::get('/register-success', [RegisterController::class, 'registerSuccess'])->name('register-success');
Route::get('/register/download-formulir', [RegisterController::class, 'downloadFormulir'])->name('register.download-formulir');
Route::view('/presensi', 'presensi')->name('presensi');

// QR Code scanning endpoint
Route::post('/presensi/scan', [PresensiController::class, 'scan'])->name('presensi.scan');

// Admin routes - grouped with prefix
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/absensi-siswa', [App\Http\Controllers\AdminController::class, 'absensiSiswa'])->name('absensi-siswa');
    Route::get('/data-guru', [App\Http\Controllers\AdminController::class, 'dataGuru'])->name('data-guru');
    Route::get('/data-guru/create', [App\Http\Controllers\AdminController::class, 'createGuru'])->name('data-guru.create');
    Route::post('/data-guru', [App\Http\Controllers\AdminController::class, 'storeGuru'])->name('data-guru.store');
    Route::get('/data-nilai', [App\Http\Controllers\AdminController::class, 'dataNilai'])->name('data-nilai');
    Route::get('/data-siswa', [App\Http\Controllers\AdminController::class, 'dataSiswa'])->name('data-siswa');
    Route::get('/data-siswa/create', [App\Http\Controllers\AdminController::class, 'createSiswaStep1'])->name('data-siswa.create');
    Route::get('/data-siswa/create/ortu', [App\Http\Controllers\AdminController::class, 'createSiswaStep2'])->name('data-siswa.create.ortu');
    Route::post('/data-siswa/create/ortu', [App\Http\Controllers\AdminController::class, 'storeSiswaOrtu'])->name('data-siswa.store.ortu');
    Route::get('/data-siswa/create/siswa/{ortuId}', [App\Http\Controllers\AdminController::class, 'createSiswaStep3'])->name('data-siswa.create.siswa');
    Route::post('/data-siswa/create/siswa/{ortuId}', [App\Http\Controllers\AdminController::class, 'storeSiswa'])->name('data-siswa.store');
    Route::get('/data-siswa/ortu/{id}', [App\Http\Controllers\AdminController::class, 'showOrtu'])->name('data-siswa.ortu');
    Route::get('/data-siswa/{id}', [App\Http\Controllers\AdminController::class, 'showSiswa'])->name('data-siswa.show');
    Route::get('/data-siswa/{id}/edit', [App\Http\Controllers\AdminController::class, 'editSiswa'])->name('data-siswa.edit');
    Route::put('/data-siswa/{id}', [App\Http\Controllers\AdminController::class, 'updateSiswa'])->name('data-siswa.update');
    Route::get('/data-siswa/{id}/delete', [App\Http\Controllers\AdminController::class, 'confirmDeleteSiswa'])->name('data-siswa.delete');
    Route::delete('/data-siswa/{id}', [App\Http\Controllers\AdminController::class, 'destroySiswa'])->name('data-siswa.destroy');
    Route::get('/data-user', [App\Http\Controllers\AdminController::class, 'dataUser'])->name('data-user');
    Route::get('/jadwal', [App\Http\Controllers\AdminController::class, 'jadwal'])->name('jadwal');
    Route::get('/laporan', [App\Http\Controllers\AdminController::class, 'laporan'])->name('laporan');
    Route::get('/pendaftaran', [App\Http\Controllers\AdminController::class, 'pendaftaran'])->name('pendaftaran');
    Route::get('/pendaftaran/{id}/approve', [App\Http\Controllers\AdminController::class, 'showApproveForm'])->name('pendaftaran.approve-form');
    Route::post('/pendaftaran/{id}/approve', [App\Http\Controllers\AdminController::class, 'approvePendaftaran'])->name('pendaftaran.approve');
    Route::post('/pendaftaran/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectPendaftaran'])->name('pendaftaran.reject');
    Route::delete('/pendaftaran/{id}', [App\Http\Controllers\AdminController::class, 'deletePendaftaran'])->name('pendaftaran.delete');
    
    // Kelas management routes
    Route::resource('kelas', KelasController::class);
    
    // Mapel management routes
    Route::resource('mapel', MapelController::class);
});

// Guru routes
Route::prefix('guru')->name('guru.')->middleware(['auth', 'role.guru'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelas-saya', [App\Http\Controllers\GuruController::class, 'kelasSaya'])->name('kelas-saya');
    Route::get('/perwalian', [App\Http\Controllers\GuruController::class, 'perwalian'])->name('perwalian');
    Route::get('/laporan', [App\Http\Controllers\GuruController::class, 'laporan'])->name('laporan');
    Route::get('/nilai', [App\Http\Controllers\GuruController::class, 'nilai'])->name('nilai');
    Route::get('/notes', [App\Http\Controllers\GuruController::class, 'notes'])->name('notes');
    Route::get('/penilaian-harian', [App\Http\Controllers\GuruController::class, 'penilaianHarian'])->name('penilaian-harian');
    Route::post('/penilaian-harian', [App\Http\Controllers\GuruController::class, 'storePenilaianHarian'])->name('penilaian-harian.store');
    Route::get('/presensi', [App\Http\Controllers\GuruController::class, 'presensi'])->name('presensi');
    Route::post('/presensi', [App\Http\Controllers\GuruController::class, 'storePresensi'])->name('presensi.store');
    Route::post('/nilai', [App\Http\Controllers\GuruController::class, 'storeNilai'])->name('nilai.store');
});

// Kepala Sekolah routes
Route::prefix('kepalasekolah')->name('kepalasekolah.')->middleware(['auth', 'role.kepsek'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\KepalaSekolahController::class, 'dashboard'])->name('dashboard');
    Route::get('/evaluasi-pembelajaran', [App\Http\Controllers\KepalaSekolahController::class, 'evaluasiPembelajaran'])->name('evaluasi-pembelajaran');
    Route::get('/laporan-absensi-guru', [App\Http\Controllers\KepalaSekolahController::class, 'laporanAbsensiGuru'])->name('laporan-absensi-guru');
    Route::get('/laporan-absensi-siswa', [App\Http\Controllers\KepalaSekolahController::class, 'laporanAbsensiSiswa'])->name('laporan-absensi-siswa');
    Route::get('/laporan-absensi', [App\Http\Controllers\KepalaSekolahController::class, 'laporanAbsensi'])->name('laporan-absensi');
    Route::get('/laporan-akademik', [App\Http\Controllers\KepalaSekolahController::class, 'laporanAkademik'])->name('laporan-akademik');
    Route::get('/laporan', [App\Http\Controllers\KepalaSekolahController::class, 'laporan'])->name('laporan');
});

// Orangtua routes
Route::prefix('orangtua')->name('orangtua.')->middleware(['auth', 'role.orangtua'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\OrangtuaController::class, 'dashboard'])->name('dashboard');
    Route::get('/data-anak', [App\Http\Controllers\OrangtuaController::class, 'dataAnak'])->name('data-anak');
    Route::get('/penilaian-harian', [App\Http\Controllers\OrangtuaController::class, 'penilaianHarian'])->name('penilaian-harian');
    Route::get('/notes', [App\Http\Controllers\OrangtuaController::class, 'notes'])->name('notes');
    Route::get('/perkembangan', [App\Http\Controllers\OrangtuaController::class, 'perkembangan'])->name('perkembangan');
    Route::get('/cetak-kartu/{siswaId}', [App\Http\Controllers\OrangtuaController::class, 'cetakKartuSiswa'])->name('cetak-kartu');
    Route::get('/cetak-laporan/{siswaId}', [App\Http\Controllers\OrangtuaController::class, 'cetakLaporanPerkembangan'])->name('cetak-laporan');
});
