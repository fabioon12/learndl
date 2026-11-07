<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Submateri;
use App\Models\SubmateriProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardBelajarController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $materis = Materi::whereHas('siswa', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->with([
            'submateris' => function ($query) {
                $query->where('status', 'terbit')
                    ->orderBy('urutan');
            }
        ])
        ->latest()
        ->get();

        $completedIds = SubmateriProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->pluck('submateri_id')
            ->toArray();

        $totalXp = max(0, (int) SubmateriProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->sum('xp_earned'));

        $xpNeeded = 1000;


        $level = intdiv($totalXp, $xpNeeded) + 1;

        $xpInLevel = $totalXp % $xpNeeded;

        // Persentase menuju level berikutnya
        $xpPercentage = round(
            ($xpInLevel / $xpNeeded) * 100,
            2
        );

        $allSubmateriIds = $materis
            ->flatMap(function ($materi) {
                return $materi->submateris->pluck('id');
            })
            ->unique()
            ->map(fn ($id) => (string) $id)
            ->all();

        $totalSubmateri = count($allSubmateriIds);

        $completedIdsNormalized = collect($completedIds)
            ->map(fn ($id) => (string) $id)
            ->unique()
            ->all();

        $totalCompleted = count(
            array_intersect(
                $allSubmateriIds,
                $completedIdsNormalized
            )
        );

        $overallProgress = $totalSubmateri > 0
            ? round(($totalCompleted / $totalSubmateri) * 100, 2)
            : 0;

        $xpMisiSelesai = SubmateriProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->sum('xp_earned');
        return view(
            'siswa.aktivitas-materi.dashboard.index',
            compact(
                'user',
                'materis',
                'completedIds',
                'totalXp',
                'level',
                'xpInLevel',
                'xpNeeded',
                'xpPercentage',
                'totalSubmateri',
                'totalCompleted',
                'overallProgress',
                'xpMisiSelesai'
            )
        );
    }

    public function showSubmateri($materiId, $submateriId)
    {
        $user = Auth::user();

        $materi = Materi::whereHas('siswa', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->findOrFail($materiId);

        $submateri = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->findOrFail($submateriId);

        $blocks = $submateri->konten_builder;

        if (is_string($blocks)) {
            $blocks = json_decode($blocks, true) ?? [];
        }

        $blocks = is_array($blocks) ? array_values($blocks) : [];

        $completedIds = \App\Models\SubmateriProgress::where(
            'user_id', $user->id
        )->whereNotNull('completed_at')
            ->pluck('submateri_id')
            ->toArray();

        $previous = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->where('urutan', '<', $submateri->urutan)
            ->orderByDesc('urutan')
            ->first();

        if ($previous && !in_array($previous->id, $completedIds)) {
            abort(403, 'Selesaikan submateri sebelumnya terlebih dahulu.');
        }

        $isCompleted = in_array($submateri->id, $completedIds);

        return view('siswa.aktivitas-materi.kerjakan.show', compact(
            'materi',
            'submateri',
            'blocks',
            'isCompleted'
        ));
    }
    


    public function completeSubmateri($materiId, $submateriId)
    {
        $user = Auth::user();

        $materi = Materi::whereHas('siswa', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->findOrFail($materiId);

        $submateri = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->findOrFail($submateriId);

        try {
            $earnedXp = DB::transaction(function () use (
                $user,
                $materi,
                $submateri
            ) {
                $progress = SubmateriProgress::where(
                    'user_id',
                    $user->id
                )
                    ->where('submateri_id', $submateri->id)
                    ->lockForUpdate()
                    ->first();

                // Sudah selesai: jangan berikan XP dua kali
                if ($progress && $progress->completed_at !== null) {
                    return 0;
                }

                $previousSubmateri = Submateri::where(
                    'materi_id',
                    $materi->id
                )
                    ->where('status', 'terbit')
                    ->where('urutan', '<', $submateri->urutan)
                    ->orderByDesc('urutan')
                    ->first();

                if ($previousSubmateri) {
                    $previousCompleted = SubmateriProgress::where(
                        'user_id',
                        $user->id
                    )
                        ->where(
                            'submateri_id',
                            $previousSubmateri->id
                        )
                        ->whereNotNull('completed_at')
                        ->exists();

                    if (!$previousCompleted) {
                        abort(
                            403,
                            'Selesaikan submateri sebelumnya terlebih dahulu.'
                        );
                    }
                }

                $xp = (int) ($submateri->xp_reward ?? 25);

                if (!$progress) {
                    $progress = new SubmateriProgress();
                    $progress->user_id = $user->id;
                    $progress->submateri_id = $submateri->id;
                }

                $progress->xp_earned = $xp;
                $progress->completed_at = now();
                $progress->save();

                return $xp;
            });

            return redirect()
                ->route(
                    'siswa.ruang-materi.dashboard-belajar',
                    $materi->id
                )
                ->with('success', 'Submateri berhasil diselesaikan!')
                ->with('earned_xp', $earnedXp)
                ->with('completed_submateri', $submateri->judul_sub);

        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            throw $e;

        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat menyimpan progres pembelajaran.'
            );
        }
    }



}
