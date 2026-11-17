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
        $perPage = 10;

        /*
        |--------------------------------------------------------------------------
        | 1. AMBIL DATA SISWA YANG LOGIN
        |--------------------------------------------------------------------------
        */

        $loggedInStudent = Auth::user();

        // Ambil sekolah siswa yang sedang login
        $schoolName = $loggedInStudent->school_name;

        /*
        |--------------------------------------------------------------------------
        | 2. AMBIL SISWA BERDASARKAN SEKOLAH
        |--------------------------------------------------------------------------
        */

        $studentsQuery = User::query()
            ->where('role', 'siswa')
            ->where('school_name', $schoolName);

        $allStudents = $studentsQuery
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

                // IDENTITAS SISWA
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
        | 3. URUTKAN BERDASARKAN XP
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
        | 4. TENTUKAN PERINGKAT SEKOLAH
        |--------------------------------------------------------------------------
        */

        $allStudents->each(function ($student, $index) {

            $student->peringkat = $index + 1;

        });

        /*
        |--------------------------------------------------------------------------
        | 5. AMBIL TOP 3 SISWA
        |--------------------------------------------------------------------------
        */

        $topThree = $allStudents
            ->take(3)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | 6. AMBIL PERINGKAT SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $currentStudent = $allStudents->firstWhere(
            'id',
            $loggedInStudent->id
        );

        /*
        |--------------------------------------------------------------------------
        | 7. PAGINATION
        |--------------------------------------------------------------------------
        */

        $page = max(
            1,
            (int) LengthAwarePaginator::resolveCurrentPage()
        );

        $currentPageStudents = $allStudents
            ->forPage($page, $perPage)
            ->values();

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
        | 8. RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('siswa.leaderboard.index', compact(
            'leaderboard',
            'topThree',
            'currentStudent',
            'schoolName'
        ));
    }
}