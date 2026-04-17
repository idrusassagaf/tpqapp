<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SantriController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruAlamatKontakController;
use App\Http\Controllers\OrangtuaController;
use App\Http\Controllers\RelasiSantriGuruController;
use App\Http\Controllers\RelasiSantriOrangtuaController;
use App\Http\Controllers\GenderUsiaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\GuruKelahiranUsiaController;
use App\Http\Controllers\PendaftaranSantriController;
use App\Http\Controllers\OrangtuaAlamatKontakController;
use App\Http\Controllers\PendaftaranGuruController;
use App\Http\Controllers\OrangtuaPekerjaanController;
use App\Http\Controllers\GuruPendidikanController;
use App\Http\Controllers\GuruStatusController;
use App\Http\Controllers\ProgresIqraController;
use App\Http\Controllers\ProgresAlquranController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ProfilController;
/*
|--------------------------------------------------------------------------
| Redirect Root ke Login
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home']);
Route::get('/profil', [PublicController::class, 'profil']);

Route::get('/jadwal', [JadwalController::class, 'indexPublic']);
Route::get('/pengumuman', [PengumumanController::class, 'publicIndex'])->name('pengumuman.public.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('kontak.store');
Route::get('/data-santri', [PublicController::class, 'dataSantri'])->name('public.data-santri');
Route::get('/kontak', [ContactController::class, 'index']);
Route::get('/berita', [App\Http\Controllers\BeritaController::class, 'publicIndex'])->name('berita.public.index');
Route::get('/berita/{slug}', [App\Http\Controllers\BeritaController::class, 'show'])->name('berita.public.show');

Route::prefix('admin/kontak')->middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::get('/', [ContactController::class, 'adminIndex'])->name('admin.kontak');
    Route::post('/{id}/read', [ContactController::class, 'markAsRead'])->name('kontak.read');
    Route::delete('/{id}', [ContactController::class, 'destroy'])->name('kontak.delete');
    Route::post('/{id}/reply', [ContactController::class, 'reply'])->name('kontak.reply');
});

Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::get('/admin/kontak', [ContactController::class, 'adminIndex'])->name('admin.kontak');
});

/*Route::get('/', function () {
    return redirect()->route('login');
});*/

/*
|--------------------------------------------------------------------------
| Semua Backend Dilindungi Login
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Session;

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/profil', [ProfilController::class, 'index'])->name('admin.profil');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('admin.profil.update');
});

Route::middleware(['auth'])->group(function () {

    // LETAKKAN INI DULU
    Route::get('/santri/pdf', [SantriController::class, 'exportPdf'])
        ->name('santri.pdf');
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // SANTRI - hanya super admin , admin dan viewer
    Route::middleware(['role:super_admin,admin,viewer'])->group(function () {
        Route::resource('santri', SantriController::class);
    });

    // GURU - hanya super admin , admin  dan viewer
    Route::middleware(['role:super_admin,admin,viewer'])->group(function () {
        Route::resource('guru', GuruController::class)->except(['show']);

        // BERITA 🔒 ADMIN
        Route::middleware(['role:super_admin,admin_berita'])->group(function () {
            Route::resource('admin/berita', BeritaController::class);
        });

        // 🌍  HALAMAN BERITA PUBLIK

        Route::get('/pengumuman/{id}', [PengumumanController::class, 'showPublic'])
            ->name('pengumuman.public.show');
    });

    // PENGUMUMAN BACKEND
    Route::prefix('admin')
        ->middleware(['auth', 'role:admin,super_admin'])
        ->group(function () {

            Route::get('/pengumuman', [PengumumanController::class, 'index'])
                ->name('pengumuman.index');
            Route::get('/pengumuman/create', [PengumumanController::class, 'create'])
                ->name('pengumuman.create');
            Route::post('/pengumuman', [PengumumanController::class, 'store'])
                ->name('pengumuman.store');
            Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])
                ->name('pengumuman.edit');
            Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])
                ->name('pengumuman.update');
            Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])
                ->name('pengumuman.destroy');
        });

    Route::get('/guru/alamat-kontak', [GuruAlamatKontakController::class, 'index'])->name('guru.alamat-kontak');
    Route::patch('/guru/{guru}/update-alamat-kontak', [GuruAlamatKontakController::class, 'updateAlamatKontak'])->name('guru.update-alamat-kontak');
    Route::get('/guru/pendidikan', [GuruPendidikanController::class, 'index'])->name('guru.pendidikan');
    Route::post('/guru/{id}/update-pendidikan', [GuruPendidikanController::class, 'updatePendidikan'])->name('guru.update-pendidikan');
    Route::get('/guru/status', [GuruStatusController::class, 'index'])->name('guru.status');
    Route::post('/guru/{id}/update-status', [GuruStatusController::class, 'updateStatus'])->name('guru.update-status');
    Route::get('/orangtua', [OrangtuaController::class, 'index'])->name('orangtua.index');
    Route::patch('/orangtua/{id}', [OrangtuaController::class, 'update'])->name('orangtua.update');
    Route::get('/orangtua/alamat-kontak', [OrangtuaAlamatKontakController::class, 'index'])->name('orangtua.alamat-kontak');
    Route::post('/orangtua/{id}/update-alamat', [OrangtuaAlamatKontakController::class, 'updateAlamat']);
    Route::get('/relasi/santri-guru', [RelasiSantriGuruController::class, 'index'])->name('relasi.santri-guru');
    Route::post('/relasi/update-guru', [RelasiSantriGuruController::class, 'updateGuru'])->name('relasi.update-guru');
    Route::get('/relasi/santri-orangtua', [RelasiSantriOrangtuaController::class, 'index'])->name('relasi.santri_orangtua');
    Route::post('/relasi/santri-orangtua/{santri_id}', [RelasiSantriOrangtuaController::class, 'store'])->name('relasi.santri_orangtua.store');
    Route::get('/gender-usia', [GenderUsiaController::class, 'index'])->name('gender-usia.index');
    Route::put('/gender-usia/{santri}', [GenderUsiaController::class, 'update'])->name('gender-usia.update');
    Route::delete('/gender-usia/{santri}', [GenderUsiaController::class, 'destroy'])->name('gender-usia.destroy');
    Route::get('/status', [StatusController::class, 'index'])->name('status.index');
    Route::patch('/status/{id}', [StatusController::class, 'update'])->name('status.update');
    Route::get('/guru-kelahiran-usia', [GuruKelahiranUsiaController::class, 'index'])->name('guru-kelahiran-usia.index');
    Route::put('/guru-kelahiran-usia/{guru}', [GuruKelahiranUsiaController::class, 'update'])->name('guru-kelahiran-usia.update');
    Route::delete('/guru-kelahiran-usia/{guru}', [GuruKelahiranUsiaController::class, 'destroy'])->name('guru-kelahiran-usia.destroy');
    Route::get('/pendaftaran-santri', [PendaftaranSantriController::class, 'index'])->name('pendaftaran-santri.index');
    Route::post('/pendaftaran-santri', [PendaftaranSantriController::class, 'store'])->name('pendaftaran-santri.store');
    Route::get('/orangtua/pekerjaan', [OrangtuaPekerjaanController::class, 'index'])->name('orangtua.pekerjaan');
    Route::post('/orangtua/{id}/update-pekerjaan', [OrangtuaPekerjaanController::class, 'updatePekerjaan'])->name('orangtua.update-pekerjaan');
    Route::get('/pendaftaran-guru', [PendaftaranGuruController::class, 'index'])->name('pendaftaran-guru.index');
    Route::post('/pendaftaran-guru', [PendaftaranGuruController::class, 'store'])->name('pendaftaran-guru.store');
    Route::get('/laporan/progres-iqra', [ProgresIqraController::class, 'index'])->name('laporan.progres-iqra');
    Route::put('/laporan/progres-iqra/{santri}', [ProgresIqraController::class, 'update'])->name('laporan.progres-iqra.update');
    Route::get('/laporan/progres-alquran', [ProgresAlquranController::class, 'index'])->name('laporan.progres-alquran');
    Route::post('/laporan/progres-alquran/{id}/update', [ProgresAlquranController::class, 'update'])->name('laporan.progres-alquran.update');
    Route::get('/informasi/jadwal', [JadwalController::class, 'index'])->name('informasi.jadwal.index');
    Route::get('/informasi/jadwal/get', [JadwalController::class, 'getJadwal']);
    Route::post('/informasi/jadwal/update', [JadwalController::class, 'updateJadwal']);
    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
        Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
        Route::get('/galeri/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
    });

    // download PDF gender-usia//
    Route::get('/gender-usia/pdf', [GenderUsiaController::class, 'exportPdf'])
        ->name('gender-usia.pdf');

    // download PDF status//
    Route::get('/status/pdf', [StatusController::class, 'pdf'])->name('status.pdf');

    // download PDF guru//
    Route::get('/guru/pdf', [GuruController::class, 'exportPdf'])
        ->name('guru.export.pdf');

    // download PDF Kelahiran Guru//
    Route::get(
        '/guru-kelahiran-usia/pdf',
        [GuruKelahiranUsiaController::class, 'exportPdf']
    )->name('guru-kelahiran-usia.export.pdf');

    // download PDF alamat kontak guru//
    Route::get(
        '/guru/alamat-kontak/pdf',
        [GuruAlamatKontakController::class, 'exportAlamatKontakPdf']
    )->name('guru-alamat-kontak.export.pdf');

    // download PDF pendidikan guru//
    Route::get(
        '/guru/pendidikan/pdf',
        [GuruPendidikanController::class, 'exportPdf']
    )->name('guru.pendidikan.export');

    // download PDF status guru//
    Route::get(
        '/guru/status/pdf',
        [GuruStatusController::class, 'exportPdf']
    )->name('guru.status.export');

    // Test di route - super admin//

    Route::get('/test-role', function () {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && $user->isSuperAdmin()) {
            return "KAMU SUPER ADMIN 🔥";
        }

        return "KAMU BUKAN SUPER ADMIN ❌";
    });

    // LIKE
    Route::post('/berita/{id}/like', [BeritaController::class, 'like'])->name('berita.like');

    // KOMENTAR
    Route::post('/berita/{id}/komentar', [BeritaController::class, 'komentar'])->name('berita.komentar');

    // HAPUS KOMENTAR
    Route::delete('/komentar/{id}', [BeritaController::class, 'hapusKomentar'])
        ->name('komentar.hapus')
        ->middleware('role:super_admin,admin_berita');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
