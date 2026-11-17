<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Submateri;
use App\Models\SubmateriProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\RuangBelajar;
use App\Models\Tahapan;
use Illuminate\Support\Facades\DB;

class DashboardBelajarController extends Controller
{

    public function index(Materi $materi)
    {
        $user = Auth::user();

        // Pastikan siswa sudah mengambil materi secara mandiri.
        abort_unless(
            $materi->siswa()
                ->where('users.id', $user->id)
                ->exists(),
            403,
            'Anda belum mengambil materi ini.'
        );

        $materi->load([
            'submateris' => function ($query) {
                $query->where('status', 'terbit')
                    ->orderBy('urutan');
            }
        ]);

        return $this->renderPetaPetualangan(
            collect([$materi]),
            $user
        );
    }


    /**
     * ==========================================================
     * DASHBOARD MATERI MELALUI RUANG BELAJAR
     * ==========================================================
     */
    public function indexRuangBelajar(
        RuangBelajar $ruangBelajar,
        Tahapan $tahapan
    ) {
        $user = Auth::user();

        // Pastikan siswa terdaftar di Ruang Belajar.
        abort_unless(
            $ruangBelajar->siswa()
                ->where('users.id', $user->id)
                ->exists(),
            403,
            'Anda belum terdaftar di Ruang Belajar ini.'
        );

        // Pastikan tahapan berasal dari Ruang Belajar yang benar.
        abort_unless(
            (int) $tahapan->ruang_belajar_id === (int) $ruangBelajar->id
            && $tahapan->tipe === 'materi',
            404
        );

        // Ambil materi yang secara khusus dipilih guru.
        $materi = $tahapan->ruangMateri()
            ->with([
                'submateris' => function ($query) {
                    $query->where('status', 'terbit')
                        ->orderBy('urutan');
                }
            ])
            ->firstOrFail();

        return $this->renderPetaPetualangan(
            collect([$materi]),
            $user,
            [
                'ruangBelajar' => $ruangBelajar,
                'tahapan' => $tahapan,
                'ruangMateri' => $materi,
            ]
        );
    }


    /**
     * ==========================================================
     * RENDER PETA PETUALANGAN
     * Digunakan bersama oleh jalur mandiri dan Ruang Belajar.
     * ==========================================================
     */
    private function renderPetaPetualangan(
        $materis,
        $user,
        $extra = []
    ) {
        // Ambil seluruh ID submateri yang ditampilkan.
        $allSubmateriIds = $materis
            ->flatMap(function ($materi) {
                return $materi->submateris->pluck('id');
            })
            ->unique()
            ->values();

        // Ambil progres selesai dari tabel bersama.
        $completedIds = SubmateriProgress::where('user_id', $user->id)
            ->whereIn('submateri_id', $allSubmateriIds)
            ->whereNotNull('completed_at')
            ->pluck('submateri_id')
            ->toArray();

        // XP keseluruhan siswa.
        $totalXp = max(0, (int) $user->totalXp());

        $xpNeeded = 1000;

        $level = intdiv($totalXp, $xpNeeded) + 1;

        $xpInLevel = $totalXp % $xpNeeded;

        $xpPercentage = round(
            ($xpInLevel / $xpNeeded) * 100,
            2
        );

        // Hitung progres materi yang sedang ditampilkan.
        $totalSubmateri = $allSubmateriIds->count();

        $completedIdsNormalized = collect($completedIds)
            ->map(fn ($id) => (string) $id)
            ->unique()
            ->all();

        $allSubmateriIdsNormalized = $allSubmateriIds
            ->map(fn ($id) => (string) $id)
            ->all();

        $totalCompleted = count(
            array_intersect(
                $allSubmateriIdsNormalized,
                $completedIdsNormalized
            )
        );

        $overallProgress = $totalSubmateri > 0
            ? round(
                ($totalCompleted / $totalSubmateri) * 100,
                2
            )
            : 0;

        // XP dari misi submateri yang sudah diselesaikan.
        $xpMisiSelesai = (int) SubmateriProgress::where(
            'user_id',
            $user->id
        )
            ->whereNotNull('completed_at')
            ->sum('xp_earned');

        return view(
            'siswa.aktivitas-materi.dashboard.index',
            array_merge([
                'user' => $user,
                'materis' => $materis,
                'completedIds' => $completedIds,
                'totalXp' => $totalXp,
                'level' => $level,
                'xpInLevel' => $xpInLevel,
                'xpNeeded' => $xpNeeded,
                'xpPercentage' => $xpPercentage,
                'totalSubmateri' => $totalSubmateri,
                'totalCompleted' => $totalCompleted,
                'overallProgress' => $overallProgress,
                'xpMisiSelesai' => $xpMisiSelesai,
            ], $extra)
        );
    }


    /**
     * ==========================================================
     * TAMPILKAN SUBMATERI - JALUR MANDIRI
     * ==========================================================
     */
    public function showSubmateri($materiId, $submateriId)
    {
        $user = Auth::user();

        // Validasi pengambilan materi secara mandiri.
        $materi = Materi::whereHas('siswa', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->findOrFail($materiId);

        return $this->renderSubmateri(
            $materi,
            $submateriId,
            $user
        );
    }


    /**
     * ==========================================================
     * TAMPILKAN SUBMATERI - JALUR RUANG BELAJAR
     * ==========================================================
     */
    public function showSubmateriRuangBelajar(
        $ruangBelajarId,
        $tahapanId,
        $materiId,
        $submateriId
    ) {
        $user = Auth::user();

        // Validasi Ruang Belajar.
        $ruangBelajar = RuangBelajar::findOrFail($ruangBelajarId);

        abort_unless(
            $ruangBelajar->siswa()
                ->where('users.id', $user->id)
                ->exists(),
            403
        );

        // Validasi tahapan dan tipe materi.
        $tahapan = Tahapan::where('ruang_belajar_id', $ruangBelajar->id)
            ->where('tipe', 'materi')
            ->findOrFail($tahapanId);

        // Pastikan materi pada URL adalah materi pilihan guru.
        $materi = $tahapan->ruangMateri()
            ->where('materis.id', $materiId)
            ->firstOrFail();

        return $this->renderSubmateri(
            $materi,
            $submateriId,
            $user,
            [
                'ruangBelajar' => $ruangBelajar,
                'tahapan' => $tahapan,
            ]
        );
    }


    /**
     * ==========================================================
     * LOGIKA TAMPIL SUBMATERI BERSAMA
     * ==========================================================
     */
    private function renderSubmateri(
        Materi $materi,
        $submateriId,
        $user,
        $extra = []
    ) {
        $submateri = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->findOrFail($submateriId);

        $blocks = $submateri->konten_builder;

        if (is_string($blocks)) {
            $blocks = json_decode($blocks, true) ?? [];
        }

        $blocks = is_array($blocks)
            ? array_values($blocks)
            : [];

        // Progres global siswa.
        $completedIds = SubmateriProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->pluck('submateri_id')
            ->toArray();

        // Ambil submateri sebelumnya.
        $previous = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->where('urutan', '<', $submateri->urutan)
            ->orderByDesc('urutan')
            ->first();

        // Validasi urutan.
        if (
            $previous &&
            !in_array($previous->id, $completedIds)
        ) {
            abort(
                403,
                'Selesaikan submateri sebelumnya terlebih dahulu.'
            );
        }

        $isCompleted = in_array(
            $submateri->id,
            $completedIds
        );

        return view(
            'siswa.aktivitas-materi.kerjakan.show',
            array_merge([
                'materi' => $materi,
                'submateri' => $submateri,
                'blocks' => $blocks,
                'isCompleted' => $isCompleted,
            ], $extra)
        );
    }


    /**
     * ==========================================================
     * SELESAIKAN SUBMATERI - JALUR MANDIRI
     * ==========================================================
     */
    public function completeSubmateri($materiId, $submateriId)
    {
        $user = Auth::user();

        $materi = Materi::whereHas('siswa', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->findOrFail($materiId);

        $submateri = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->findOrFail($submateriId);

        $earnedXp = $this->simpanProgress(
            $user,
            $materi,
            $submateri
        );

        return redirect()
            ->route(
                'siswa.ruang-materi.dashboard-belajar',
                $materi->id
            )
            ->with('success', 'Submateri berhasil diselesaikan!')
            ->with('earned_xp', $earnedXp)
            ->with('completed_submateri', $submateri->judul_sub);
    }


    /**
     * ==========================================================
     * SELESAIKAN SUBMATERI - JALUR RUANG BELAJAR
     * ==========================================================
     */

    public function completeSubmateriRuangBelajar(
        $ruangBelajarId,
        $tahapanId,
        $materiId,
        $submateriId
    ) {
        $user = Auth::user();

        $ruangBelajar = RuangBelajar::findOrFail($ruangBelajarId);

        abort_unless(
            $ruangBelajar->siswa()
                ->where('users.id', $user->id)
                ->exists(),
            403
        );

        $tahapan = Tahapan::where('ruang_belajar_id', $ruangBelajar->id)
            ->where('tipe', 'materi')
            ->findOrFail($tahapanId);

        $materi = $tahapan->ruangMateri()
            ->where('materis.id', $materiId)
            ->firstOrFail();

        $submateri = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->findOrFail($submateriId);

        // Simpan progres dan XP.
        $earnedXp = $this->simpanProgress(
            $user,
            $materi,
            $submateri
        );

        // Periksa seluruh submateri materi yang ditugaskan.
        $allSubmateriIds = Submateri::where('materi_id', $materi->id)
            ->where('status', 'terbit')
            ->pluck('id');

        $totalSubmateri = $allSubmateriIds->count();

        $totalCompleted = SubmateriProgress::where('user_id', $user->id)
            ->whereIn('submateri_id', $allSubmateriIds)
            ->whereNotNull('completed_at')
            ->count();

        $allCompleted = $totalSubmateri > 0
            && $totalCompleted >= $totalSubmateri;

        // Jika seluruh submateri selesai, tandai tahapan sebagai selesai.
        if ($allCompleted) {
            \App\Models\TahapanUser::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'tahapan_id' => $tahapan->id,
                ],
                [
                    'status' => 'selesai',
                    'exp_didapat' => 0,
                    'completed_at' => now(),
                ]
            );
        }

        // Selalu kembali ke dashboard materi dalam konteks Ruang Belajar.
        return redirect()
            ->route(
                'siswa.ruang-materi.ruang-belajar.dashboard',
                [
                    'ruangBelajar' => $ruangBelajar->id,
                    'tahapan' => $tahapan->id,
                ]
            )
            ->with('success', 'Submateri berhasil diselesaikan!')
            ->with('earned_xp', $earnedXp)
            ->with('completed_submateri', $submateri->judul_sub)
            ->with('all_submateri_completed', $allCompleted);
    }



    /**
     * ==========================================================
     * PENYIMPANAN PROGRES BERSAMA
     * ==========================================================
     *
     * Jalur mandiri dan Ruang Belajar menggunakan method ini.
     * XP hanya diberikan sekali per user dan submateri.
     */
    private function simpanProgress(
        $user,
        Materi $materi,
        Submateri $submateri
    ) {
        return DB::transaction(function () use (
            $user,
            $materi,
            $submateri
        ) {
            // Kunci data siswa untuk menghindari penyelesaian
            // bersamaan yang memberikan XP ganda.
            DB::table('users')
                ->where('id', $user->id)
                ->lockForUpdate()
                ->first();

            $progress = SubmateriProgress::where(
                'user_id',
                $user->id
            )
                ->where('submateri_id', $submateri->id)
                ->lockForUpdate()
                ->first();

            // Jika sudah selesai, tidak memberikan XP lagi.
            if ($progress && $progress->completed_at !== null) {
                return 0;
            }

            // Validasi submateri sebelumnya.
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
    }

}
