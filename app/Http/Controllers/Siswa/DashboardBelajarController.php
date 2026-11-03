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

        // Materi yang sudah diambil siswa
        $materis = Materi::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->with(['submateris' => function ($query) {
            $query->where('status', 'terbit')
                  ->orderBy('urutan');
        }])
        ->latest()
        ->get();

        // Submateri yang sudah diselesaikan
        $completedIds = SubmateriProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->pluck('submateri_id')
            ->toArray();

        $totalXp = $user->totalXp();

        // Level: setiap 100 EXP naik satu level
        $level = (int) floor($totalXp / 100) + 1;

        // EXP untuk level selanjutnya
        $xpInLevel = $totalXp % 100;
        $xpNeeded = 100;
        $xpPercentage = ($xpInLevel / $xpNeeded) * 100;

        // Level: setiap 100 XP naik satu level
        $level = (int) floor($totalXp / 100) + 1;

        // XP untuk level selanjutnya
        $xpInLevel = $totalXp % 100;
        $xpNeeded = 100;
        $xpPercentage = ($xpInLevel / $xpNeeded) * 100;

        // Statistik pembelajaran
        $totalSubmateri = $materis->sum(function ($materi) {
            return $materi->submateris->count();
        });

        $totalCompleted = count(array_intersect(
            $completedIds,
            $materis->flatMap->submateris->pluck('id')->toArray()
        ));

        $overallProgress = $totalSubmateri > 0
            ? round(($totalCompleted / $totalSubmateri) * 100)
            : 0;

        return view('siswa.aktivitas-materi.dashboard.index', compact(
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
            'overallProgress'
        ));
    }
    public function showSubmateri($materiId, $submateriId)
    {
        $user = Auth::user();

        $materi = Materi::whereHas('users', function ($query) use ($user) {
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

        // 1. Pastikan materi sudah diambil siswa
        $materi = Materi::whereHas('siswa', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->findOrFail($materiId);

        // 2. Pastikan submateri termasuk dalam materi dan sudah terbit
        $submateri = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->findOrFail($submateriId);

        try {
            DB::transaction(function () use ($user, $materi, $submateri) {

                // 3. Cek apakah sudah pernah diselesaikan
                $progress = SubmateriProgress::where('user_id', $user->id)
                    ->where('submateri_id', $submateri->id)
                    ->lockForUpdate()
                    ->first();

                // Jangan berikan EXP dua kali
                if ($progress && $progress->completed_at !== null) {
                    return;
                }

                // 4. Cari submateri sebelumnya yang berstatus terbit
                $previousSubmateri = Submateri::where('materi_id', $materi->id)
                    ->where('status', 'terbit')
                    ->where('urutan', '<', $submateri->urutan)
                    ->orderByDesc('urutan')
                    ->first();

                // 5. Pastikan submateri sebelumnya sudah selesai
                if ($previousSubmateri) {
                    $previousCompleted = SubmateriProgress::where(
                        'user_id',
                        $user->id
                    )
                        ->where('submateri_id', $previousSubmateri->id)
                        ->whereNotNull('completed_at')
                        ->exists();

                    if (!$previousCompleted) {
                        abort(403, 'Selesaikan submateri sebelumnya terlebih dahulu.');
                    }
                }

                // 6. Tentukan EXP
                $xp = $submateri->xp_reward ?? 25;

                // 7. Simpan progres
                if (!$progress) {
                    $progress = new SubmateriProgress();

                    $progress->user_id = $user->id;
                    $progress->submateri_id = $submateri->id;
                }

                $progress->xp_earned = $xp;
                $progress->completed_at = now();
                $progress->save();
            });

            return redirect()
                ->route('dashboard-belajar')
                ->with('success', 'Selamat! Submateri berhasil diselesaikan.');

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
