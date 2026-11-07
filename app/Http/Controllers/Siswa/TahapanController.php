<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use App\Models\TahapanUser;
use App\Models\HasilUjian;
use App\Models\SubmateriProgress;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TahapanController extends Controller
{
    public function index($id)
    {
        $userId = Auth::id();

        // Ambil ruang belajar, tahapan, progres siswa, dan submateri yang diterbitkan.
        $ruangBelajar = RuangBelajar::with([
            'tahapans' => function ($query) use ($userId) {
                $query->orderBy('urutan', 'asc')
                    ->orderBy('id', 'asc')
                    ->with([
                        'userProgress' => function ($q) use ($userId) {
                            $q->where('user_id', $userId);
                        },
                        'ruangMateri.submateris' => function ($q) {
                            $q->where('status', 'terbit')
                                ->orderBy('urutan')
                                ->orderBy('id');
                        },
                    ]);
            },
        ])->findOrFail($id);

        $sudahTerdaftar = $ruangBelajar->siswa()
            ->where('users.id', $userId)
            ->exists();

        abort_unless($sudahTerdaftar, 403, 'Anda belum terdaftar di ruang belajar ini.');

        $tahapans = $ruangBelajar->tahapans;

        // Ambil ID submateri unik agar materi yang dipakai berulang tidak dihitung dua kali.
        $submateris = $tahapans
            ->filter(fn ($tahapan) => $tahapan->tipe === 'materi' && $tahapan->ruangMateri)
            ->flatMap(fn ($tahapan) => $tahapan->ruangMateri->submateris)
            ->unique('id')
            ->values();

        $submateriIds = $submateris->pluck('id');

        $progressSubmateri = $submateriIds->isEmpty()
            ? collect()
            : SubmateriProgress::query()
                ->where('user_id', $userId)
                ->whereIn('submateri_id', $submateriIds)
                ->whereNotNull('completed_at')
                ->get()
                ->keyBy('submateri_id');

        // Sinkronkan tahapan Materi yang seluruh misinya sudah selesai.
        // Tidak menambah EXP tahapan karena EXP misi tersimpan di SubmateriProgress.
        foreach ($tahapans as $tahapan) {
            if ($tahapan->tipe !== 'materi' || !$tahapan->ruangMateri) {
                continue;
            }

            $idsMateri = $tahapan->ruangMateri->submateris->pluck('id');
            if ($idsMateri->isEmpty()) {
                continue;
            }

            $semuaMisiSelesai = $idsMateri->every(
                fn ($submateriId) => $progressSubmateri->has($submateriId)
            );

            if (!$semuaMisiSelesai) {
                continue;
            }

            $progress = $tahapan->userProgress->first();
            if ($progress?->status === 'selesai') {
                continue;
            }

            $progress = TahapanUser::updateOrCreate(
                [
                    'user_id' => $userId,
                    'tahapan_id' => $tahapan->id,
                ],
                [
                    'status' => 'selesai',
                    'completed_at' => now(),
                    'exp_didapat' => 0,
                ]
            );

            // Perbarui relasi yang telah dimuat agar status tampilan langsung sesuai.
            $tahapan->setRelation('userProgress', collect([$progress]));
        }

        // Tentukan tahapan aktif dan terkunci secara berurutan.
        $adaTahapanSebelumnyaBelumSelesai = false;
        foreach ($tahapans as $tahapan) {
            $progress = $tahapan->userProgress->first();

            if ($progress?->status === 'selesai') {
                $statusTampilan = 'selesai';
            } elseif (!$adaTahapanSebelumnyaBelumSelesai) {
                $statusTampilan = 'aktif';
                $adaTahapanSebelumnyaBelumSelesai = true;
            } else {
                $statusTampilan = 'terkunci';
            }

            $tahapan->status_tampilan = $statusTampilan;
        }

        $totalTahapan = $tahapans->count();
        $tahapanSelesai = $tahapans->filter(
            fn ($tahapan) => $tahapan->userProgress->first()?->status === 'selesai'
        )->count();

        $progressPersen = $totalTahapan > 0
            ? round(($tahapanSelesai / $totalTahapan) * 100)
            : 0;

        // EXP dari tahapan biasa (termasuk ujian), tidak dari tahapan Materi.
        $tahapanBiasa = $tahapans->reject(fn ($tahapan) => $tahapan->tipe === 'materi');

        $totalExpTahapan = (int) $tahapanBiasa->sum(
            fn ($tahapan) => max(0, (int) ($tahapan->xp_reward ?? 0))
        );

        $expDiperolehTahapan = (int) $tahapanBiasa->sum(function ($tahapan) {
            $progress = $tahapan->userProgress->first();
            return $progress?->status === 'selesai'
                ? max(0, (int) ($progress->exp_didapat ?? 0))
                : 0;
        });

        // EXP dari seluruh submateri terbit yang digunakan ruang belajar ini.
        $totalExpMateri = (int) $submateris->sum(
            fn ($submateri) => max(0, (int) ($submateri->xp_reward ?? 0))
        );

        $expDiperolehMateri = (int) $progressSubmateri->sum(
            fn ($progress) => max(0, (int) ($progress->xp_earned ?? 0))
        );

        $totalExp = $totalExpTahapan + $totalExpMateri;
        $expDiperoleh = $expDiperolehTahapan + $expDiperolehMateri;

        $tahapanTersisa = max(0, $totalTahapan - $tahapanSelesai);
        $semuaTahapanSelesai = $totalTahapan > 0 && $tahapanSelesai === $totalTahapan;

        return view('siswa.ruang-belajar.tahapan.index', compact(
            'ruangBelajar',
            'tahapans',
            'totalTahapan',
            'tahapanSelesai',
            'tahapanTersisa',
            'progressPersen',
            'totalExp',
            'expDiperoleh',
            'totalExpTahapan',
            'expDiperolehTahapan',
            'totalExpMateri',
            'expDiperolehMateri',
            'semuaTahapanSelesai'
        ));
    }


    public function show($ruang_belajar_id, $tahapan_id)
    {
        $userId = Auth::id();
        abort_unless($userId, 401);

        $ruangBelajar = RuangBelajar::with([
            'tahapans' => function ($query) use ($userId) {
                $query->orderBy('urutan')->orderBy('id')
                    ->with(['userProgress' => function ($progressQuery) use ($userId) {
                        $progressQuery->where('user_id', $userId);
                    }]);
            },
        ])->findOrFail($ruang_belajar_id);

        abort_unless(
            $ruangBelajar->siswa()->where('users.id', $userId)->exists(),
            403,
            'Anda belum terdaftar di ruang belajar ini.'
        );

        $tahapans = $ruangBelajar->tahapans;
        $tahapan = $tahapans->firstWhere('id', (int) $tahapan_id);
        abort_if(!$tahapan, 404, 'Tahapan tidak ditemukan.');

        $tahapanAktif = $tahapans->first(function ($item) {
            return $item->userProgress->first()?->status !== 'selesai';
        });

        $progress = $tahapan->userProgress->first();
        $bolehDiakses = $progress?->status === 'selesai'
            || ($tahapanAktif && (int) $tahapanAktif->id === (int) $tahapan->id);

        abort_unless($bolehDiakses, 403, 'Selesaikan tahapan sebelumnya terlebih dahulu.');

        // PRE-TEST / POST-TEST

if (in_array($tahapan->tipe, ['pre_test', 'post_test'], true)) {

    // Ambil ujian yang dipilih guru pada tahapan ini
    $ruangUjian = $tahapan->ruangUjian()
        ->with(['guru', 'soal'])
        ->first();

    abort_if(
        !$ruangUjian,
        404,
        'Guru belum memilih Ruang Ujian untuk tahapan ini.'
    );

    abort_if(
        $ruangUjian->status !== 'aktif',
        403,
        'Ruang Ujian yang dipilih belum aktif.'
    );

    abort_if(
        $ruangUjian->soal->isEmpty(),
        403,
        'Ruang Ujian belum memiliki soal.'
    );

    // Cari hasil ujian yang terkait dengan tahapan ini
    $hasilUjian = HasilUjian::where('user_id', $userId)
        ->where('ruang_ujian_id', $ruangUjian->id)
        ->where('tahapan_id', $tahapan->id)
        ->first();

    // Jika selesai, sinkronkan progres tahapan
    if ($hasilUjian && $hasilUjian->status === 'selesai') {

        DB::transaction(function () use (
            $userId,
            $tahapan,
            $hasilUjian
        ) {
            $progress = TahapanUser::where('user_id', $userId)
                ->where('tahapan_id', $tahapan->id)
                ->lockForUpdate()
                ->first();

            if (!$progress || $progress->status !== 'selesai') {

                TahapanUser::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'tahapan_id' => $tahapan->id,
                    ],
                    [
                        'status' => 'selesai',
                        'exp_didapat' =>
                            (int) ($hasilUjian->exp_diperoleh ?? 0),
                        'jawaban' => [
                            'hasil_ujian_id' => $hasilUjian->id,
                            'nilai' => $hasilUjian->nilai,
                            'jumlah_benar' => $hasilUjian->jumlah_benar,
                            'jumlah_salah' => $hasilUjian->jumlah_salah,
                        ],
                        'completed_at' =>
                            $hasilUjian->finished_at ?? now(),
                    ]
                );
            }
        });
    }

    // Selalu masuk ke halaman detail terlebih dahulu
    return redirect()->route('siswa.ujian.detail', [
        'ruang_ujian_id' => $ruangUjian->id,
        'tahapan_id' => $tahapan->id,
        'ruang_belajar_id' => $ruangBelajar->id,
    ]);
}
        // RUANG MATERI: tampilkan dashboard materi yang ditautkan guru.
        if ($tahapan->tipe === 'materi') {
            $user = Auth::user();

            $tahapan->load([
                'ruangMateri.submateris' => function ($query) {
                    // Hanya materi terbit yang dapat dipelajari siswa.
                    $query->where('status', 'terbit')
                        ->orderBy('urutan')
                        ->orderBy('id');
                },
            ]);

            $ruangMateri = $tahapan->ruangMateri;
            abort_if(!$ruangMateri, 404, 'Ruang Materi belum dipilih oleh guru.');

            // Model Materi mendefinisikan relasi submateris() (huruf s kecil).
            // Blade memerlukan kumpulan Materi, bukan kumpulan Submateri.
            $materis = collect([$ruangMateri]);
            $submateris = $ruangMateri->submateris;
            $submateriIds = $submateris->pluck('id');

            $progressSubmateri = $submateriIds->isEmpty()
                ? collect()
                : SubmateriProgress::query()
                    ->where('user_id', $userId)
                    ->whereIn('submateri_id', $submateriIds)
                    ->get()
                    ->keyBy('submateri_id');

            $progressSelesai = $progressSubmateri->filter(function ($item) {
                return $item->completed_at !== null;
            });

            $completedIds = $progressSelesai->keys()->all();
            $totalSubmateri = $submateris->count();
            $totalCompleted = $progressSelesai->count();
            $jumlahSelesai = $totalCompleted;
            $overallProgress = $totalSubmateri > 0
                ? round(($totalCompleted / $totalSubmateri) * 100)
                : 0;

            // Sinkronkan status tahapan ketika seluruh submateri terbit selesai.
            // Jangan menambahkan XP lagi: XP sudah tersimpan per submateri.
            if ($totalSubmateri > 0 && $totalCompleted >= $totalSubmateri) {
                DB::transaction(function () use ($userId, $tahapan) {
                    $progresTahapan = TahapanUser::query()
                        ->where('user_id', $userId)
                        ->where('tahapan_id', $tahapan->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$progresTahapan || $progresTahapan->status !== 'selesai') {
                        TahapanUser::updateOrCreate(
                            ['user_id' => $userId, 'tahapan_id' => $tahapan->id],
                            [
                                'status' => 'selesai',
                                'exp_didapat' => 0,
                                'completed_at' => now(),
                            ]
                        );
                    }
                });
            }

            // Total XP yang tersedia berasal dari reward setiap submateri.
            $totalXP = (int) $submateris->sum(function ($submateri) {
                return (int) ($submateri->xp_reward ?? 0);
            });

            // Total XP yang sudah diperoleh siswa
            $xpDiperoleh = (int) $progressSelesai->sum(function ($item) {
                return (int) ($item->xp_earned ?? 0);
            });

            // XP yang diperoleh dari misi yang selesai
            $xpMisiSelesai = $xpDiperoleh;

            // Variabel tambahan untuk widget XP pada dashboard materi.
            $xpTersisa = max(0, $totalXP - $xpDiperoleh);
            $xpProgressPercentage = $totalXP > 0
                ? round(min(100, ($xpDiperoleh / $totalXP) * 100), 1)
                : 0;

            // Level global: 1000 XP per level.
            $totalXp = max(0, (int) $user->totalXp());
            $xpPerLevel = 1000;
            $level = intdiv($totalXp, $xpPerLevel) + 1;
            $xpInLevel = $totalXp % $xpPerLevel;
            $xpNeeded = $xpPerLevel;
            $xpPercentage = round(($xpInLevel / $xpNeeded) * 100, 1);

            return view('siswa.aktivitas-materi.dashboard.index', compact(
                'user', 'ruangBelajar', 'tahapan', 'ruangMateri', 'materis',
                'progressSubmateri', 'completedIds', 'totalXp', 'level',
                'xpInLevel', 'xpNeeded', 'xpPercentage', 'totalSubmateri',
                'totalCompleted', 'overallProgress', 'totalXP', 'xpDiperoleh',
                'jumlahSelesai', 'xpMisiSelesai', 'xpTersisa', 'xpProgressPercentage'
            ));
        }

        $konten = $tahapan->konten ?? [];
        if (is_string($konten)) {
            $konten = json_decode($konten, true) ?: [];
        }
        if (!is_array($konten)) {
            $konten = [];
        }

        $view = match ($tahapan->tipe) {
            'jeda_hening', 'jeda_hening_checkin', 'checkin'
                => 'siswa.ruang-belajar.tahapan.konten.jeda-hening',
            'apersepsi' => 'siswa.ruang-belajar.tahapan.konten.apersepsi',
            'ice_breaking' => 'siswa.ruang-belajar.tahapan.konten.ice-breaking',
            default => abort(404, 'Tipe tahapan tidak ditemukan.'),
        };

        $jawabanSaya = '';
        $jawabanTeman = collect();
        $jumlahJawaban = 0;
        $forumAktif = false;

        if ($tahapan->tipe === 'apersepsi') {
            $forumAktif = filter_var(
                data_get($konten, 'forum.aktif', false),
                FILTER_VALIDATE_BOOLEAN
            );

            $jawabanTersimpan = $progress?->jawaban ?? [];
            if (is_string($jawabanTersimpan)) {
                $jawabanTersimpan = json_decode($jawabanTersimpan, true) ?: [];
            }
            if (!is_array($jawabanTersimpan)) {
                $jawabanTersimpan = [];
            }

            $jawabanSaya = trim((string) (
                data_get($jawabanTersimpan, 'forum')
                ?? data_get($jawabanTersimpan, 'jawaban.forum')
                ?? ''
            ));

            if ($forumAktif && $jawabanSaya !== '') {
                // Ambil ID siswa terdaftar melalui relasi RuangBelajar::siswa().
                $siswaIds = $ruangBelajar->siswa()->pluck('users.id');

                $jawabanValid = TahapanUser::query()
                    ->with('user')
                    ->where('tahapan_id', $tahapan->id)
                    ->whereIn('user_id', $siswaIds)
                    ->whereNotNull('jawaban')
                    ->orderByDesc('updated_at')
                    ->get()
                    ->filter(function ($item) {
                        $data = $item->jawaban;
                        if (is_string($data)) {
                            $data = json_decode($data, true) ?: [];
                        }
                        return trim((string) (
                            data_get($data, 'forum')
                            ?? data_get($data, 'jawaban.forum')
                            ?? ''
                        )) !== '';
                    });

                $jumlahJawaban = $jawabanValid->count();
                $jawabanTeman = $jawabanValid
                    ->reject(fn ($item) => (int) $item->user_id === (int) $userId)
                    ->values();
            }
        }

        // Jangan kirim kunci jawaban permainan susun kode ke Blade.
        if ($tahapan->tipe === 'ice_breaking') {
            foreach ($konten['aktivitas'] ?? [] as $index => $aktivitas) {
                if (($aktivitas['tipe'] ?? null) === 'susun_kode') {
                    unset(
                        $konten['aktivitas'][$index]['konfigurasi']['urutan_benar'],
                        $konten['aktivitas'][$index]['konfigurasi']['urutan_benar_text']
                    );
                }
            }
        }

        // View tahapan non-materi hanya membutuhkan variabel yang tersedia
        // di semua cabang, bukan statistik khusus dashboard materi.
        return view($view, compact(
            'ruangBelajar', 'tahapan', 'konten',
            'jawabanSaya', 'jawabanTeman', 'jumlahJawaban', 'forumAktif'
        ));
    }


    public function selesaikan(Request $request, $ruang_belajar_id, $tahapan_id)
    {
        $userId = Auth::id();

        // ==========================================
        // 1. VALIDASI RUANG BELAJAR DAN SISWA
        // ==========================================

        $ruangBelajar = RuangBelajar::findOrFail($ruang_belajar_id);

        $sudahTerdaftar = $ruangBelajar->siswa()
            ->where('users.id', $userId)
            ->exists();

        abort_unless($sudahTerdaftar, 403);

        // Pastikan tahapan milik ruang belajar
        $tahapan = Tahapan::where('ruang_belajar_id', $ruang_belajar_id)
            ->findOrFail($tahapan_id);

        // ==========================================
        // 2. CEK PROGRES TAHAPAN SEBELUMNYA
        // ==========================================

        $tahapansSebelumnya = Tahapan::where('ruang_belajar_id', $ruang_belajar_id)
            ->where('urutan', '<', $tahapan->urutan)
            ->orderBy('urutan')
            ->get();

        foreach ($tahapansSebelumnya as $sebelumnya) {

            $progressSebelumnya = TahapanUser::where('user_id', $userId)
                ->where('tahapan_id', $sebelumnya->id)
                ->first();

            if (!$progressSebelumnya || $progressSebelumnya->status !== 'selesai') {
                return back()->with(
                    'error',
                    'Selesaikan tahapan sebelumnya terlebih dahulu.'
                );
            }
        }

        // ==========================================
        // 3. PENANGANAN PRE-TEST DAN POST-TEST
        // ==========================================


if (in_array($tahapan->tipe, ['pre_test', 'post_test'], true)) {

    $ruangUjian = $tahapan->ruangUjian()
        ->where('status', 'aktif')
        ->first();

    if (!$ruangUjian) {
        return back()->with(
            'error',
            'Ruang Ujian belum dipilih atau belum aktif.'
        );
    }

    $hasilUjian = HasilUjian::where('user_id', $userId)
        ->where('ruang_ujian_id', $ruangUjian->id)
        ->where('tahapan_id', $tahapan->id)
        ->where('status', 'selesai')
        ->first();

    if (!$hasilUjian) {
        return redirect()->route('siswa.ujian.detail', [
            'ruang_ujian_id' => $ruangUjian->id,
            'tahapan_id' => $tahapan->id,
            'ruang_belajar_id' => $ruang_belajar_id,
        ])->with(
            'error',
            'Selesaikan ujian terlebih dahulu.'
        );
    }

    $expDidapat = (int) ($hasilUjian->exp_diperoleh ?? 0);

    DB::transaction(function () use (
        $userId,
        $tahapan,
        $hasilUjian,
        $expDidapat
    ) {
        $progress = TahapanUser::where('user_id', $userId)
            ->where('tahapan_id', $tahapan->id)
            ->lockForUpdate()
            ->first();

        if ($progress && $progress->status === 'selesai') {
            return;
        }

        TahapanUser::updateOrCreate(
            [
                'user_id' => $userId,
                'tahapan_id' => $tahapan->id,
            ],
            [
                'status' => 'selesai',
                'exp_didapat' => $expDidapat,
                'jawaban' => [
                    'hasil_ujian_id' => $hasilUjian->id,
                    'nilai' => $hasilUjian->nilai,
                    'jumlah_benar' => $hasilUjian->jumlah_benar,
                    'jumlah_salah' => $hasilUjian->jumlah_salah,
                ],
                'completed_at' =>
                    $hasilUjian->finished_at ?? now(),
            ]
        );
    });

    return redirect()
        ->route('siswa.ruang-belajar.tahapan', [
            'id' => $ruang_belajar_id,
        ])
        ->with(
            'success',
            "Tahapan ujian selesai! Kamu memperoleh {$expDidapat} EXP."
        );
}


        // ==========================================
        // 4. VALIDASI INPUT TAHAPAN BIASA
        // ==========================================

        $validated = $request->validate([
            'jawaban' => ['nullable', 'array'],
            'jawaban.*' => ['nullable'],
            'jawaban.*.*' => ['sometimes', 'integer', 'min:1'],

            'selesai' => ['nullable', 'array'],
            'selesai.*' => ['nullable', 'in:1'],

            'check_in_jawaban' => ['nullable', 'string', 'max:1000'],
            'durasi_terpenuhi' => ['nullable', 'in:1'],
        ]);

        // Ambil konfigurasi tahapan
        $konten = $tahapan->konten ?? [];

        if (is_string($konten)) {
            $konten = json_decode($konten, true) ?? [];
        }

        // ==========================================
        // 4A. VALIDASI APERSEPSI INTERAKTIF
        // ==========================================
        // Jawaban forum dikirim lebih dahulu melalui simpanJawabanApersepsi().
        // Penyelesaian hanya diizinkan jika jawaban sudah tersimpan.
        if ($tahapan->tipe === 'apersepsi') {
            $forumAktif = filter_var(
                data_get($konten, 'forum.aktif', false),
                FILTER_VALIDATE_BOOLEAN
            );

            if ($forumAktif) {
                $progressApersepsi = TahapanUser::where('user_id', $userId)
                    ->where('tahapan_id', $tahapan->id)
                    ->first();

                $jawabanTersimpan = $progressApersepsi?->jawaban ?? [];
                if (is_string($jawabanTersimpan)) {
                    $jawabanTersimpan = json_decode($jawabanTersimpan, true) ?: [];
                }

                if (!is_array($jawabanTersimpan) ||
                    trim((string) data_get($jawabanTersimpan, 'forum', '')) === '') {
                    return back()->with('error',
                        'Kirim jawaban pertanyaan pemantik terlebih dahulu sebelum menyelesaikan apersepsi.'
                    );
                }
            }
        }

        // ==========================================
        // 5. VALIDASI JEDA HENING
        // ==========================================

        if (in_array($tahapan->tipe, [
            'jeda_hening',
            'jeda_hening_checkin',
            'checkin',
        ])) {

            $durasi = (int) ($konten['durasi'] ?? 0);

            if ($durasi > 0 && !$request->filled('durasi_terpenuhi')) {
                return back()->with(
                    'error',
                    'Selesaikan durasi Jeda Hening terlebih dahulu.'
                );
            }

            $checkInAktif = $konten['check_in']['aktif'] ?? false;

            if ($checkInAktif && !$request->filled('check_in_jawaban')) {
                return back()->with(
                    'error',
                    'Silakan isi refleksi terlebih dahulu.'
                );
            }
        }

        // ==========================================
        // 6. VALIDASI ICE BREAKING
        // ==========================================

        if ($tahapan->tipe === 'ice_breaking') {

            $aktivitasList = $konten['aktivitas'] ?? [];

            foreach ($aktivitasList as $index => $aktivitas) {

                $tipeAktivitas = $aktivitas['tipe'] ?? '';

                $activityId = $aktivitas['id'] ?? 'aktivitas_' . $index;

                // Validasi video YouTube
                if ($tipeAktivitas === 'youtube') {

                    if (
                        ($validated['selesai'][$activityId] ?? null) !== '1' &&
                        ($validated['selesai'][$activityId] ?? null) !== 1
                    ) {
                        return back()
                            ->withInput()
                            ->with(
                                'error',
                                'Selesaikan seluruh aktivitas video terlebih dahulu.'
                            );
                    }
                }

                // Validasi permainan susun kode
                if ($tipeAktivitas === 'susun_kode') {

                    $potonganKode = $aktivitas['konfigurasi']['potongan_kode'] ?? [];

                    $jumlahPotongan = count($potonganKode);

                    $jawabanAktivitas = $validated['jawaban'][$activityId] ?? [];

                    if (
                        !is_array($jawabanAktivitas) ||
                        count($jawabanAktivitas) !== $jumlahPotongan
                    ) {
                        return back()
                            ->withInput()
                            ->with(
                                'error',
                                'Lengkapi seluruh kotak permainan susun kode.'
                            );
                    }

                    // Pastikan indeks potongan valid dan tidak duplikat
                    $indeksValid = range(1, $jumlahPotongan);

                    $jawabanAngka = array_map('intval', $jawabanAktivitas);

                    if (
                        count(array_unique($jawabanAngka)) !== $jumlahPotongan ||
                        array_diff($jawabanAngka, $indeksValid) ||
                        array_diff($indeksValid, $jawabanAngka)
                    ) {
                        return back()
                            ->withInput()
                            ->with(
                                'error',
                                'Urutan potongan kode tidak valid. Silakan susun kembali.'
                            );
                    }
                }
            }
        }

        // ==========================================
        // 7. SIMPAN JAWABAN DAN PROGRES SISWA
        // ==========================================

        $expDidapat = 0;
        $sudahSelesai = false;
        $forumBelumDijawab = false;

        DB::transaction(function () use (
            $userId,
            $tahapan,
            $validated,
            $konten,
            &$expDidapat,
            &$sudahSelesai,
            &$forumBelumDijawab
        ) {
            $progress = TahapanUser::where('user_id', $userId)
                ->where('tahapan_id', $tahapan->id)
                ->lockForUpdate()
                ->first();

            // Mencegah penyelesaian dan pemberian EXP berulang.
            if ($progress && $progress->status === 'selesai') {
                $sudahSelesai = true;
                return;
            }

            // Ambil jawaban lama agar jawaban forum tidak tertimpa.
            $jawabanLama = $progress?->jawaban ?? [];
            if (is_string($jawabanLama)) {
                $jawabanLama = json_decode($jawabanLama, true) ?: [];
            }
            if (!is_array($jawabanLama)) {
                $jawabanLama = [];
            }

            if ($tahapan->tipe === 'apersepsi') {
                $forumAktif = filter_var(
                    data_get($konten, 'forum.aktif', false),
                    FILTER_VALIDATE_BOOLEAN
                );

                // Periksa ulang setelah lock agar tidak terjadi race condition.
                if ($forumAktif && trim((string) data_get($jawabanLama, 'forum', '')) === '') {
                    $forumBelumDijawab = true;
                    return;
                }

                // Untuk apersepsi, simpan jawaban lama apa adanya.
                $jawabanSiswa = $jawabanLama;
            } else {
                // Pertahankan data lain dan perbarui field aktivitas biasa.
                $jawabanSiswa = array_merge($jawabanLama, [
                    'jawaban' => $validated['jawaban'] ?? [],
                    'selesai' => $validated['selesai'] ?? [],
                    'check_in_jawaban' => $validated['check_in_jawaban'] ?? null,
                ]);
            }

            $expDidapat = max(0, (int) ($tahapan->xp_reward ?? 0));

            TahapanUser::updateOrCreate(
                [
                    'user_id' => $userId,
                    'tahapan_id' => $tahapan->id,
                ],
                [
                    'status' => 'selesai',
                    'exp_didapat' => $expDidapat,
                    'jawaban' => $jawabanSiswa,
                    'completed_at' => now(),
                ]
            );
        });

        if ($forumBelumDijawab) {
            return back()->with('error',
                'Jawaban pertanyaan pemantik belum tersimpan. Silakan kirim jawaban terlebih dahulu.'
            );
        }

        if ($sudahSelesai) {
            return redirect()
                ->route('siswa.ruang-belajar.tahapan', ['id' => $ruang_belajar_id])
                ->with('success', 'Tahapan ini sudah pernah diselesaikan. XP tidak diberikan ulang.');
        }

        // ==========================================
        // 8. REDIRECT SETELAH BERHASIL
        // ==========================================

        return redirect()
            ->route('siswa.ruang-belajar.tahapan', [
                'id' => $ruang_belajar_id,
            ])
            ->with(
                'success',
                $expDidapat > 0
                    ? "Tahapan berhasil diselesaikan! Kamu mendapatkan {$expDidapat} EXP."
                    : 'Tahapan berhasil diselesaikan!'
            );
    }
    public function simpanJawabanApersepsi(
        Request $request,
        $ruang_belajar_id,
        $tahapan_id
    ) {
        $userId = Auth::id();

        $ruangBelajar = RuangBelajar::findOrFail($ruang_belajar_id);

        abort_unless(
            $ruangBelajar->siswa()
                ->where('users.id', $userId)
                ->exists(),
            403
        );

        $tahapan = Tahapan::where(
            'ruang_belajar_id',
            $ruangBelajar->id
        )
            ->where('tipe', 'apersepsi')
            ->findOrFail($tahapan_id);

        // Pastikan siswa tidak melewati tahapan sebelumnya.
        $tahapanSebelumnya = Tahapan::where(
            'ruang_belajar_id',
            $ruangBelajar->id
        )
            ->where('urutan', '<', $tahapan->urutan)
            ->pluck('id');

        $jumlahSelesai = TahapanUser::where('user_id', $userId)
            ->whereIn('tahapan_id', $tahapanSebelumnya)
            ->where('status', 'selesai')
            ->distinct()
            ->count('tahapan_id');

        abort_unless(
            $jumlahSelesai === $tahapanSebelumnya->count(),
            403,
            'Selesaikan tahapan sebelumnya terlebih dahulu.'
        );

        $konten = $tahapan->konten ?? [];

        $forumAktif = filter_var(
            data_get($konten, 'forum.aktif', false),
            FILTER_VALIDATE_BOOLEAN
        );

        abort_unless($forumAktif, 403, 'Forum tidak aktif.');

        $validated = $request->validate([
            'jawaban.forum' => [
                'required',
                'string',
                'min:1',
                'max:5000',
            ],
        ]);

        $jawaban = trim($validated['jawaban']['forum']);

        if ($jawaban === '') {
            return back()
                ->withErrors([
                    'jawaban.forum' => 'Jawaban wajib diisi.',
                ])
                ->withInput();
        }

        DB::transaction(function () use (
            $userId,
            $tahapan,
            $jawaban
        ) {
            $progress = TahapanUser::firstOrCreate(
                [
                    'user_id' => $userId,
                    'tahapan_id' => $tahapan->id,
                ],
                [
                    'status' => 'aktif',
                    'exp_didapat' => 0,
                ]
            );

            // Jangan mengubah jawaban setelah tahapan selesai.
            if ($progress->status === 'selesai') {
                return;
            }

            $dataJawaban = $progress->jawaban ?? [];

            if (!is_array($dataJawaban)) {
                $dataJawaban = json_decode($dataJawaban, true) ?: [];
            }

            $dataJawaban['forum'] = $jawaban;

            $progress->jawaban = $dataJawaban;
            $progress->save();
        });

        return redirect()
            ->route('siswa.ruang-belajar.tahapan.show', [
                'ruang_belajar_id' => $ruang_belajar_id,
                'tahapan_id' => $tahapan_id,
            ])
            ->with('success', 'Jawaban berhasil dikirim!');
    }
    private function sinkronkanPenyelesaianMateri(
        $tahapan,
        int $userId
    ): bool {
        $materi = $tahapan->ruangMateri;

        if (!$materi) {
            return false;
        }

        $submateriIds = $materi->submateris()
            ->where('status', 'terbit')
            ->pluck('id');

        // Materi kosong tidak otomatis dianggap selesai.
        if ($submateriIds->isEmpty()) {
            return false;
        }

        $jumlahSelesai = SubmateriProgress::query()
            ->where('user_id', $userId)
            ->whereIn('submateri_id', $submateriIds)
            ->whereNotNull('completed_at')
            ->distinct()
            ->count('submateri_id');

        if ($jumlahSelesai < $submateriIds->count()) {
            return false;
        }

        TahapanUser::updateOrCreate(
            [
                'user_id' => $userId,
                'tahapan_id' => $tahapan->id,
            ],
            [
                'status' => 'selesai',
                'completed_at' => now(),

                // XP submateri sudah dicatat di SubmateriProgress.
                // Jangan menambahkan XP yang sama dua kali.
                'exp_didapat' => 0,
            ]
        );

        return true;
    }
}
