<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\SubmateriProgress;


class LeaderboardController extends Controller
{

 public function index(Request $request)
    {
        // Jumlah siswa per halaman
        $perPage = 10;

        /*
        |--------------------------------------------------------------------------
        | 1. AMBIL SELURUH SISWA
        |--------------------------------------------------------------------------
        */

        $allStudents = User::query()
            ->where('role', 'siswa')
            ->get()
            ->map(function ($student) {

                // XP GLOBAL dari model User
                $student->total_xp = max(
                    0,
                    (int) $student->totalXp()
                );

                // Level: 1000 XP = naik 1 level
                $student->level_game = intdiv(
                    $student->total_xp,
                    1000
                ) + 1;

                // XP pada level saat ini
                $student->xp_in_level =
                    $student->total_xp % 1000;

                // Persentase progres level
                $student->xp_percentage =
                    ($student->xp_in_level / 1000) * 100;

                // Jumlah misi yang diselesaikan
                $student->total_misi = SubmateriProgress::query()
                    ->where('user_id', $student->id)
                    ->whereNotNull('completed_at')
                    ->distinct()
                    ->count('submateri_id');

                return $student;
            })

            /*
            |--------------------------------------------------------------------------
            | 2. URUTKAN BERDASARKAN XP GLOBAL
            |--------------------------------------------------------------------------
            */

            ->sortBy([
                ['total_xp', 'desc'],
                ['total_misi', 'desc'],
                ['id', 'asc'],
            ])
            ->values();

        /*
        |--------------------------------------------------------------------------
        | 3. TENTUKAN RANKING GLOBAL
        |--------------------------------------------------------------------------
        */

        $allStudents->each(function ($student, $index) {
            $student->peringkat = $index + 1;
        });

        /*
        |--------------------------------------------------------------------------
        | 4. PODIUM 3 BESAR
        |--------------------------------------------------------------------------
        */

        $topThree = $allStudents
            ->take(3)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | 5. STATISTIK SELURUH SISWA
        |--------------------------------------------------------------------------
        */

        $totalSiswa = $allStudents->count();

        $totalXp = $allStudents->sum('total_xp');

        $totalMisi = $allStudents->sum('total_misi');

        $highestXp = $allStudents->max('total_xp') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | 6. PAGINATION
        |--------------------------------------------------------------------------
        */

        $page = max(
            1,
            (int) LengthAwarePaginator::resolveCurrentPage()
        );

        // Ambil 10 siswa sesuai halaman
        $currentPageStudents = $allStudents
            ->forPage($page, $perPage)
            ->values();

        // Buat pagination Laravel
        $leaderboard = new LengthAwarePaginator(
            $currentPageStudents,
            $allStudents->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 7. RETURN VIEW GURU
        |--------------------------------------------------------------------------
        */

        return view('guru.leaderboard.index', compact(
            'leaderboard',
            'topThree',
            'totalSiswa',
            'totalXp',
            'totalMisi',
            'highestXp'
        ));
    }

}
