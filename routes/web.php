<?php

use Illuminate\Support\Facades\Route;

/* Deklarasi Auth */
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/* Deklarasi Controller Siswa */
use App\Http\Controllers\Siswa\ProfilController as SiswaProfilController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\RuangbelajarController as SiswaRuangbelajarController;
use App\Http\Controllers\Siswa\TahapanController as SiswaTahapanController;
use App\Http\Controllers\Siswa\MateriController as SiswaMateriController;
use App\Http\Controllers\Siswa\DashboardBelajarController as SiswaDashboardBelajarController;
use App\Http\Controllers\Siswa\UjianController as SiswaUjianController;
use App\Http\Controllers\Siswa\LeaderboardController;



/* Deklarasi Controller Guru */
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\LeaderboardController as GuruLeaderboardController;

/* controller ruang belajar */
use App\Http\Controllers\Guru\RuangbelajarController as GuruRuangBelajarController;
use App\Http\Controllers\Guru\ProfilController as GuruProfilController;
use App\Http\Controllers\Guru\TahapanRuangBelajarController as GuruTahapanRuangBelajarController;
use App\Http\Controllers\Guru\AktivitasTahapanController as GuruAktivitasTahapanController;
use App\Http\Controllers\Guru\TahapanKontenController as GuruTahapanKontenController;
use App\Http\Controllers\Guru\RuangBelajarMonitoringController as GuruRuangBelajarMonitoringController;

/* controller materi guru */
use App\Http\Controllers\Guru\MateriController as GuruMateriController;
/* submateri */
use App\Http\Controllers\Guru\SubmateriController as GuruSubMateriController;
/* aktivitas-sub-materi */
use App\Http\Controllers\Guru\AktivitasSubMateriController as GuruAktivitasSubMateriController;

use App\Http\Controllers\Guru\RuangUjianController as GuruRuangUjianController;
use App\Http\Controllers\Guru\SoalUjianController as GuruSoalUjianController;

/* Deklarasi Controller Admin */ 
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ManajemenPenggunaController as AdminManajemenPenggunaController;
use App\Http\Controllers\Admin\RuangbelajarController as AdminRuangBelajarController;
use App\Http\Controllers\Admin\LaporanStatistikController as AdminLaporanStatistikController;


Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        }

        return redirect()->route('siswa.dashboard');
    }

    return view('landingpage.home.index');
})->name('home');


Route::middleware('guest')->group(function () {
    // Registrasi
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

    // Login
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
});


Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('siswa')->name('siswa.')->group(function () {
        /* Dashboard Siswa */
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
       
        /* Profil Siswa */
        Route::get('/profil', [SiswaProfilController::class, 'index'])->name('profil');
        Route::put('/profil/update-profil', [SiswaProfilController::class, 'updateProfil'])->name('profil.update-profil');
        Route::put('/profil/update-password', [SiswaProfilController::class, 'updatePassword'])->name('profil.update-password');
        Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');


        /* Ruang Belajar */
        Route::prefix('ruang-belajar')->name('ruang-belajar.')->group(function () {
            // Route Dashboard Saya
            Route::get('/dashboard', [SiswaRuangbelajarController::class, 'dashboard'])->name('dashboard');

            /* Route Tahapan Ruang Belajar */
            Route::get('/tahapan/{id}', [SiswaTahapanController::class, 'index'])->name('tahapan');
            Route::get('/tahapan/{ruang_belajar_id}/{tahapan_id}', [SiswaTahapanController::class, 'show'])->name('tahapan.show');
            Route::post('/tahapan/{ruang_belajar_id}/{tahapan_id}/selesaikan', [SiswaTahapanController::class, 'selesaikan'])->name('tahapan.selesaikan');
            Route::post('/tahapan/{ruang_belajar_id}/{tahapan_id}/jawaban-apersepsi',[SiswaTahapanController::class, 'simpanJawabanApersepsi'])->name('tahapan.apersepsi.jawab');
            // Route Eksplorasi Ruang Belajar
            Route::get('/eksplorasi', [SiswaRuangbelajarController::class, 'eksplorasi'])->name('eksplorasi');
            
            // Halaman Detail Ruang Belajar
            Route::get('/{id}', [SiswaRuangBelajarController::class, 'show'])->name('show');
            
            // POST Action: Siswa mengambil / bergabung ke Ruang Belajar
            Route::post('/{id}/enroll', [SiswaRuangBelajarController::class, 'enroll'])->name('enroll');

            

        });


        /* Ruang Materi */
        Route::prefix('ruang-materi')->name('ruang-materi.')->group(function () {
            // Route Dashboard Saya
            Route::get('/dashboard', [SiswaMateriController::class, 'index'])->name('index');

            
            // Route Eksplorasi Ruang Materi
            Route::get('/eksplorasi', [SiswaMateriController::class, 'eksplorasi'])->name('eksplorasi');
            
            
            // POST Action: Siswa mengambil / bergabung ke Ruang Materi
            Route::post('/{id}/enroll', [SiswaMateriController::class, 'ambilMateri'])->name('ambil');

              /*
            |--------------------------------------------------------------------------
            | PEMBELAJARAN MANDIRI
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard-belajar/{materi}',
                [SiswaDashboardBelajarController::class, 'index']
            )->name('dashboard-belajar');

            Route::get('/dashboard-belajar/{materi}/submateri/{submateri}',
                [SiswaDashboardBelajarController::class, 'showSubmateri']
            )->name('dashboard-belajar.submateri.show');

            Route::post('/dashboard-belajar/{materi}/submateri/{submateri}/complete',
                [SiswaDashboardBelajarController::class, 'completeSubmateri']
            )->name('dashboard-belajar.submateri.complete');

            /*
            |--------------------------------------------------------------------------
            | PEMBELAJARAN MELALUI RUANG BELAJAR
            |--------------------------------------------------------------------------
            */

            Route::get('/ruang-belajar/{ruangBelajar}/tahapan/{tahapan}/dashboard',
                [SiswaDashboardBelajarController::class, 'indexRuangBelajar']
            )->name('ruang-belajar.dashboard');

            Route::get('/ruang-belajar/{ruangBelajar}/tahapan/{tahapan}/materi/{materi}/submateri/{submateri}',
                [SiswaDashboardBelajarController::class, 'showSubmateriRuangBelajar']
            )->name('ruang-belajar.submateri.show');

            Route::post('/ruang-belajar/{ruangBelajar}/tahapan/{tahapan}/materi/{materi}/submateri/{submateri}/complete',
                [SiswaDashboardBelajarController::class, 'completeSubmateriRuangBelajar']
            )->name('ruang-belajar.submateri.complete');
        });

        Route::prefix('ujian')->name('ujian.')->group(function () {
            Route::get('/', [SiswaUjianController::class, 'index'])->name('index');
            Route::get('/detail/{ruang_ujian_id}', [SiswaUjianController::class, 'detailMandiri'])->name('detail');
            Route::post('/mulai/{ruang_ujian_id}', [SiswaUjianController::class, 'mulaiMandiri'])->name('mulai-mandiri');
            Route::get('/kerjakan/{hasil_id}', [SiswaUjianController::class, 'kerjakan'])->name('kerjakan');
            Route::post('/selesaikan/{hasil_id}', [SiswaUjianController::class, 'selesaikan'])->name('selesaikan');
            Route::get('/hasil/{hasil_id}', [SiswaUjianController::class, 'hasil'])->name('hasil');
            Route::get('/kerjakan/{hasil_id}', [SiswaUjianController::class, 'kerjakan'])->name('kerjakan');
            Route::post('/selesaikan/{hasil_id}', [SiswaUjianController::class, 'selesaikan'])->name('selesaikan');
            Route::post('/ujian/mulai-tahapan/{ruang_ujian_id}/{tahapan_id}',[SiswaUjianController::class, 'mulaiDariTahapan'])->name('ujian.mulai-tahapan');

        });

        /* Profil Siswa - Update mood */
        Route::post('/profil/update-mood', [SiswaProfilController::class, 'updateMood'])->name('profil.update-mood');
    });

    /* Route Guru */
    Route::prefix('guru')->name('guru.')->group(function () {

        /* Dashboard Guru */
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
        Route::get('/leaderboard', [GuruLeaderboardController::class, 'index'])
            ->name('leaderboard.index');

        /* Ruang Belajar Guru */
        Route::prefix('ruang-belajar')->name('ruang-belajar.')->group(function () {
            Route::get('/dashboard', [GuruRuangBelajarController::class, 'index'])->name('index');
            Route::get('/create', [GuruRuangBelajarController::class, 'create'])->name('create');
            Route::post('/store', [GuruRuangBelajarController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GuruRuangBelajarController::class, 'edit'])->name('edit');
            Route::put('/{id}', [GuruRuangBelajarController::class, 'update'])->name('update');
            Route::delete('/{id}', [GuruRuangBelajarController::class, 'destroy'])->name('destroy');

            Route::get('/eksplorasi', [GuruRuangBelajarController::class, 'eksplorasi'])->name('eksplorasi');

            Route::get('/{ruang_belajar}/monitoring',[GuruRuangBelajarMonitoringController::class, 'index'])->name('monitoring');
            Route::get('/{ruang_belajar}/tahapan/{tahapan}/monitoring',[GuruRuangBelajarMonitoringController::class, 'showTahapan'])->name('tahapan.monitoring');

            /* Tahapan Ruang Belajar */
            Route::get('/{id}/tahapan', [GuruTahapanRuangBelajarController::class, 'index'])->name('tahapan.index');
            Route::get('/{ruang_belajar_id}/tahapan/create', [GuruTahapanRuangBelajarController::class, 'create'])->name('tahapan.create');
            Route::post('/{ruang_belajar_id}/tahapan/store', [GuruTahapanRuangBelajarController::class, 'store'])->name('tahapan.store');
            Route::get('/{ruang_belajar_id}/tahapan/{tahapan_id}/edit', [GuruTahapanRuangBelajarController::class, 'edit'])->name('tahapan.edit');
            Route::put('/{ruang_belajar_id}/tahapan/{tahapan_id}', [GuruTahapanRuangBelajarController::class, 'update'])->name('tahapan.update');
            Route::delete('/{ruang_belajar_id}/tahapan/{tahapan_id}', [GuruTahapanRuangBelajarController::class, 'destroy'])->name('tahapan.destroy');

            /* Konten Tahapan Ruang Belajar */
            Route::get('/{ruang_belajar}/tahapan/{tahapan}/konten', [GuruTahapanKontenController::class, 'create'])->name('tahapan.konten.edit');
            Route::post('/{ruang_belajar}/tahapan/{tahapan}/konten', [GuruTahapanKontenController::class, 'store'])->name('tahapan.konten.store');
            Route::get('/{ruang_belajar}/tahapan/{tahapan}/konten/edit', [GuruTahapanKontenController::class, 'edit'])->name('tahapan.konten.edit');
            Route::post('/{ruang_belajar_id}/tahapan/{tahapan_id}/upload-gambar',[GuruTahapanKontenController::class, 'uploadGambar'])->name('tahapan.upload-gambar');
            
            Route::put('/{ruang_belajar}/tahapan/{tahapan}/konten', [GuruTahapanKontenController::class, 'update'])->name('tahapan.konten.update');

            /* Aktivitas Ruang Belajar */
            Route::get('/{ruang_belajar_id}/tahapan/{tahapan_id}/Aktivitastahapan', [GuruAktivitasTahapanController::class, 'index'])
                ->name('aktivitas.index');
        });

        /* Materi */
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/dashboard', [GuruMateriController::class, 'index'])->name('index');
            Route::get('/create', [GuruMateriController::class, 'create'])->name('create');
            Route::post('/store', [GuruMateriController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GuruMateriController::class, 'edit'])->name('edit');
            Route::put('/{id}', [GuruMateriController::class, 'update'])->name('update');
            Route::delete('/{id}', [GuruMateriController::class, 'delete'])->name('destroy');

            Route::prefix('sub-materi')->name('submateri.')->group(function () {
                Route::get('/{id}', [GuruSubMateriController::class, 'index'])->name('index');
                Route::get('/{materi_id}/create', [GuruSubMateriController::class, 'create'])->name('create');
                Route::post('/{materi_id}/store', [GuruSubMateriController::class, 'store'])->name('store');
                Route::delete('/{materi_id}/{id}', [GuruSubMateriController::class, 'destroy'])->name('destroy');
                Route::get('/{materi_id}/{id}/edit', [GuruSubMateriController::class, 'edit'])->name('edit');
                Route::put('/{materi_id}/{id}', [GuruSubMateriController::class, 'update'])->name('update');
                Route::delete('/{materi_id}/{id}', [GuruSubMateriController::class, 'destroy'])->name('destroy');

                /* Aktivitas Materi */
                Route::get('/{materi_id}/{submateri_id}/aktivitas/create', [GuruAktivitasSubMateriController::class, 'create'])->name('aktivitas.create');
                Route::post('/{materi_id}/{submateri_id}/aktivitas/store', [GuruAktivitasSubMateriController::class, 'store'])->name('aktivitas.store');
                Route::get('/{materi_id}/{submateri_id}/aktivitas/edit', [GuruAktivitasSubMateriController::class, 'edit'])->name('aktivitas.edit');
                Route::put('/{materi_id}/{submateri_id}/aktivitas/update', [GuruAktivitasSubMateriController::class, 'update'])->name('aktivitas.update');
                Route::get('/{materi_id}/{submateri_id}/aktivitas/show', [GuruAktivitasSubMateriController::class, 'show'])->name('aktivitas.show');
                Route::post('/materi/upload-image', [GuruAktivitasSubMateriController::class, 'upload'])->name('aktivitas.image');
            });
        });

        Route::prefix('ruang-ujian')->name('ruang-ujian.')->group(function () {
            Route::get('/', [GuruRuangUjianController::class, 'index'])->name('index');
            Route::get('/create', [GuruRuangUjianController::class, 'create'])->name('create');
            Route::post('/store', [GuruRuangUjianController::class, 'store'])->name('store');
            Route::get('/{id}', [GuruRuangUjianController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [GuruRuangUjianController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [GuruRuangUjianController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [GuruRuangUjianController::class, 'destroy'])->name('destroy');
            Route::get('/{ruang_ujian_id}/soal/create', [GuruSoalUjianController::class,'create'])->name('soal.create');
            Route::post('/{ruang_ujian_id}/soal/store', [GuruSoalUjianController::class,'store'])->name('soal.store');
            Route::get('/{ruang_ujian_id}/soal/{soal_id}/edit', [GuruSoalUjianController::class,'edit'])->name('soal.edit');
            Route::put('/{ruang_ujian_id}/soal/{soal_id}/update', [GuruSoalUjianController::class,'update'])->name('soal.update');
            Route::delete('/{ruang_ujian_id}/soal/{soal_id}/delete', [GuruSoalUjianController::class,'destroy'])->name('soal.destroy');

            Route::post('{ruangUjian}/penilaian/{hasilUjian}',[GuruRuangUjianController::class, 'simpanPenilaian'])->name('penilaian.simpan');
            });
         /* Profil Guru */
        Route::get('/profil', [GuruProfilController::class, 'index'])->name('profil');
        Route::put('/profil/update-profil', [GuruProfilController::class, 'updateProfil'])->name('profil.update-profil');
        Route::put('/profil/update-password', [GuruProfilController::class, 'updatePassword'])->name('profil.update-password');
    });

    /* Route Admin */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        /* manajemen-pengguna */
        Route::get('/manajemen-pengguna', [AdminManajemenPenggunaController::class, 'index'])->name('manajemen-pengguna');
        Route::get('/manajemen-pengguna/create', [AdminManajemenPenggunaController::class, 'create'])->name('manajemen-pengguna.create');
        Route::post('/manajemen-pengguna', [AdminManajemenPenggunaController::class, 'store'])->name('manajemen-pengguna.store');
        Route::get('/manajemen-pengguna/{user}/edit', [AdminManajemenPenggunaController::class, 'edit'])->name('manajemen-pengguna.edit');
        Route::put('/manajemen-pengguna/{user}', [AdminManajemenPenggunaController::class, 'update'])->name('manajemen-pengguna.update');
        Route::delete('/manajemen-pengguna/{user}', [AdminManajemenPenggunaController::class, 'destroy'])->name('manajemen-pengguna.destroy');

        /* Ruang Belajar */
        Route::get('/ruang-belajar', [AdminRuangBelajarController::class, 'index'])->name('ruang-belajar.index');
        Route::get('/ruang-belajar/create', [AdminRuangBelajarController::class, 'create'])->name('ruang-belajar.create');
        Route::post('/ruang-belajar/store', [AdminRuangBelajarController::class, 'store'])->name('ruang-belajar.store');
        Route::delete('/ruang-belajar/{id}', [AdminRuangBelajarController::class, 'destroy'])->name('ruang-belajar.destroy');
        /* Laporan Statistik */
        Route::get('/laporan-statistik', [AdminLaporanStatistikController::class, 'index'])->name('laporan-statistik');

    });

});



