<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubmateriProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // Jumlah siswa per halaman
        $perPage = 10;

        /*
        |--------------------------------------------------------------------------
        | 1. AMBIL SELURUH SISWA DAN HITUNG XP
        |--------------------------------------------------------------------------
        */

        $allStudents = User::query()
            ->where('role', 'siswa')
            ->get()
            ->map(function ($student) {

                // XP GLOBAL
                $student->total_xp = max(
                    0,
                    (int) $student->totalXp()
                );

                // LEVEL (1000 XP = 1 LEVEL)
                $student->level_game = intdiv(
                    $student->total_xp,
                    1000
                ) + 1;

                // XP PADA LEVEL SAAT INI
                $student->xp_in_level =
                    $student->total_xp % 1000;

                // PERSENTASE PROGRESS LEVEL
                $student->xp_percentage =
                    ($student->xp_in_level / 1000) * 100;

                // JUMLAH MISI SELESAI
                $student->total_misi = SubmateriProgress::query()
                    ->where('user_id', $student->id)
                    ->whereNotNull('completed_at')
                    ->distinct()
                    ->count('submateri_id');

                /*
                |--------------------------------------------------------------------------
                | IDENTITAS SISWA
                |--------------------------------------------------------------------------
                */

                $student->jurusan =
                    $student->major_or_subject;

                $student->nama_offering =
                    $student->offering;

                $student->asal_sekolah =
                    $student->school_name;

                return $student;
            });

        /*
        |--------------------------------------------------------------------------
        | 2. URUTKAN BERDASARKAN XP GLOBAL
        |--------------------------------------------------------------------------
        */

        $allStudents = $allStudents
            ->sortBy([
                ['total_xp', 'desc'],
                ['total_misi', 'desc'],
                ['id', 'asc'],
            ])
            ->values();

        /*
        |--------------------------------------------------------------------------
        | 3. TENTUKAN PERINGKAT GLOBAL
        |--------------------------------------------------------------------------
        */

        $allStudents->each(function ($student, $index) {

            $student->peringkat = $index + 1;

        });

        /*
        |--------------------------------------------------------------------------
        | 4. AMBIL TOP 3 CHAMPIONS
        |--------------------------------------------------------------------------
        */

        $topThree = $allStudents
            ->take(3)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | 5. AMBIL PERINGKAT SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $currentStudent = $allStudents->firstWhere(
            'id',
            Auth::id()
        );

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
        | 7. RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('siswa.leaderboard.index', compact(
            'leaderboard',
            'topThree',
            'currentStudent'
        ));
    }
}
