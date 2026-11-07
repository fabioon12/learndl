<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use App\Models\TahapanUser;
use App\Models\HasilUjian;
use App\Models\SubmateriProgress;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | 1. DATA MATERI YANG DIIKUTI SISWA
        |--------------------------------------------------------------------------
        */

        $materis = $user->enrolledMateris()
            ->with([
                'subMateris' => function ($query) {
                    $query->where('status', 'terbit')
                        ->orderBy('urutan');
                },

                'subMateris.progress' => function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->whereNotNull('completed_at');
                }
            ])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 2. HITUNG PROGRESS SETIAP MATERI
        |--------------------------------------------------------------------------
        */

        $materis->each(function ($materi) {
            $totalSubmateri = $materi->subMateris->count();

            $selesaiSubmateri = $materi->subMateris
                ->filter(function ($submateri) {
                    return $submateri->progress->isNotEmpty();
                })
                ->count();

            $materi->total_submateri = $totalSubmateri;
            $materi->selesai_submateri = $selesaiSubmateri;

            $materi->progress_persen = $totalSubmateri > 0
                ? round(($selesaiSubmateri / $totalSubmateri) * 100)
                : 0;
        });

        /*
        |--------------------------------------------------------------------------
        | 3. STATISTIK PEMBELAJARAN
        |--------------------------------------------------------------------------
        */

        $jumlahMateri = $materis->count();

        $totalSubmateri = $materis->sum('total_submateri');

        $selesaiSubmateri = $materis->sum('selesai_submateri');

        $progressKeseluruhan = $totalSubmateri > 0
            ? round(($selesaiSubmateri / $totalSubmateri) * 100)
            : 0;

        $jumlahRuangBelajar = $user->enrolledRuangBelajars()->count();

        $jumlahSubmateriSelesai = $user->submateriProgress()
            ->whereNotNull('completed_at')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 4. HITUNG TOTAL XP
        |--------------------------------------------------------------------------
        */

        $totalXp = (int) $user->totalXp();

        /*
        |--------------------------------------------------------------------------
        | 5. HITUNG XP HARI INI
        |--------------------------------------------------------------------------
        */

        $xpMateriHariIni = $user->submateriProgress()
            ->whereNotNull('completed_at')
            ->whereDate('completed_at', $today)
            ->sum('xp_earned');

        $xpTahapanHariIni = $user->tahapanProgress()
            ->where('status', 'selesai')
            ->whereDate('completed_at', $today)
            ->whereHas('tahapan', function ($query) {
                $query->whereNotIn('tipe', [
                    'pre_test',
                    'post_test'
                ]);
            })
            ->sum('exp_didapat');

        $xpUjianHariIni = $user->hasilUjian()
            ->where('status', 'selesai')
            ->whereDate('finished_at', $today)
            ->sum('exp_diperoleh');

        $xpHariIni = (int) (
            $xpMateriHariIni +
            $xpTahapanHariIni +
            $xpUjianHariIni
        );

        /*
        |--------------------------------------------------------------------------
        | 6. SISTEM LEVEL - 1000 XP PER LEVEL
        |--------------------------------------------------------------------------
        */

        $xpPerLevel = 1000;

        $level = (int) floor($totalXp / $xpPerLevel) + 1;

        $xpLevelSaatIni = $totalXp % $xpPerLevel;

        $progressLevel = round(
            ($xpLevelSaatIni / $xpPerLevel) * 100
        );

        /*
        |--------------------------------------------------------------------------
        | 7. DATA LEADERBOARD
        |--------------------------------------------------------------------------
        */

        // Ambil jumlah misi selesai setiap siswa sekaligus.
        $totalMisiSiswa = SubmateriProgress::query()
            ->selectRaw(
                'user_id, COUNT(DISTINCT submateri_id) as total_misi'
            )
            ->whereNotNull('completed_at')
            ->groupBy('user_id')
            ->pluck('total_misi', 'user_id');

        // Ambil seluruh siswa.
        $allStudents = User::query()
            ->where('role', 'siswa')
            ->get()
            ->map(function ($student) use ($totalMisiSiswa, $xpPerLevel) {

                $student->total_xp = max(
                    0,
                    (int) $student->totalXp()
                );

                $student->level_game = intdiv(
                    $student->total_xp,
                    $xpPerLevel
                ) + 1;

                $student->xp_in_level = (
                    $student->total_xp % $xpPerLevel
                );

                $student->xp_percentage = (
                    $student->xp_in_level / $xpPerLevel
                ) * 100;

                $student->total_misi = (int) (
                    $totalMisiSiswa[$student->id] ?? 0
                );

                return $student;
            });

        // Urutkan berdasarkan XP, jumlah misi, kemudian ID.
        $allStudents = $allStudents
            ->sortBy([
                ['total_xp', 'desc'],
                ['total_misi', 'desc'],
                ['id', 'asc'],
            ])
            ->values();

        // Tentukan peringkat masing-masing siswa.
        $allStudents->each(function ($student, $index) {
            $student->peringkat = $index + 1;
        });

        // Ambil tiga siswa dengan peringkat tertinggi.
        $topThree = $allStudents
            ->take(3)
            ->values();

        // Ambil data peringkat siswa yang sedang login.
        $currentStudent = $allStudents
            ->firstWhere('id', $user->id);

        /*
        |--------------------------------------------------------------------------
        | 8. KIRIM DATA KE DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('siswa.dashboard.index', compact(
            'user',
            'materis',

            // Statistik pembelajaran
            'jumlahMateri',
            'jumlahRuangBelajar',
            'totalSubmateri',
            'selesaiSubmateri',
            'jumlahSubmateriSelesai',
            'progressKeseluruhan',

            // XP dan level
            'totalXp',
            'xpHariIni',
            'level',
            'xpLevelSaatIni',
            'xpPerLevel',
            'progressLevel',

            // Leaderboard
            'topThree',
            'currentStudent'
        ));
    }
}