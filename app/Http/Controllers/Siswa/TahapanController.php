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

        // Ambil ruang belajar beserta tahapan dan progres siswa
        $ruangBelajar = RuangBelajar::with([
            'tahapans' => function ($query) use ($userId) {
                $query->orderBy('urutan', 'asc')
                    ->with([
                        'userProgress' => function ($q) use ($userId) {
                            $q->where('user_id', $userId);
                        }
                    ]);
            }
        ])->findOrFail($id);

        $sudahTerdaftar = $ruangBelajar->siswa()
            ->where('users.id', $userId)
            ->exists();

        if (!$sudahTerdaftar) {
            abort(403, 'Anda belum terdaftar di ruang belajar ini.');
        }

        $tahapans = $ruangBelajar->tahapans;

        $adaTahapanSebelumnyaBelumSelesai = false;

        foreach ($tahapans as $tahapan) {

            $progress = $tahapan->userProgress->first();

            $statusProgress = $progress?->status;

            if ($statusProgress === 'selesai') {

                $statusTampilan = 'selesai';

            } elseif (!$adaTahapanSebelumnyaBelumSelesai) {

                // Tahapan pertama yang belum selesai menjadi aktif
                $statusTampilan = 'aktif';

                $adaTahapanSebelumnyaBelumSelesai = true;

            } else {

                // Tahapan selanjutnya terkunci
                $statusTampilan = 'terkunci';
            }

            $tahapan->status_tampilan = $statusTampilan;
        }

        $totalTahapan = $tahapans->count();

        $tahapanSelesai = $tahapans->filter(function ($tahapan) {
            return $tahapan->userProgress->first()?->status === 'selesai';
        })->count();

        // Persentase progres
        $progressPersen = $totalTahapan > 0
            ? round(($tahapanSelesai / $totalTahapan) * 100)
            : 0;

        $totalExp = $tahapans->sum(function ($tahapan) {
            return (int) ($tahapan->xp_reward ?? 0);
        });


        $expDiperoleh = $tahapans->sum(function ($tahapan) {
            return (int) ($tahapan->userProgress->first()?->exp_didapat ?? 0);
        });

        $tahapanTersisa = $totalTahapan - $tahapanSelesai;

        $semuaTahapanSelesai = $totalTahapan > 0
            && $tahapanSelesai === $totalTahapan;

        return view('siswa.ruang-belajar.tahapan.index',
            compact(
                'ruangBelajar',
                'tahapans',
                'totalTahapan',
                'tahapanSelesai',
                'tahapanTersisa',
                'progressPersen',
                'totalExp',
                'expDiperoleh',
                'semuaTahapanSelesai'
            )
        );
    }

    public function show($ruang_belajar_id, $tahapan_id)
    {
        $userId = Auth::id();

        // ==========================================
        // AMBIL RUANG BELAJAR DAN TAHAPAN
        // ==========================================

        $ruangBelajar = RuangBelajar::with([
            'tahapans' => function ($query) use ($userId) {
                $query->orderBy('urutan', 'asc')
                    ->with([
                        'userProgress' => function ($q) use ($userId) {
                            $q->where('user_id', $userId);
                        }
                    ]);
            }
        ])->findOrFail($ruang_belajar_id);

        // Pastikan siswa sudah terdaftar
        $sudahTerdaftar = $ruangBelajar->siswa()
            ->where('users.id', $userId)
            ->exists();

        abort_unless($sudahTerdaftar, 403);

        $tahapans = $ruangBelajar->tahapans;

        // Cari tahapan yang sedang dibuka
        $tahapan = $tahapans->firstWhere('id', (int) $tahapan_id);

        abort_if(!$tahapan, 404);

        // ==========================================
        // PEMERIKSAAN AKSES TAHAPAN
        // ==========================================

        // Cari tahapan pertama yang belum selesai
        $tahapanAktif = $tahapans->first(function ($item) {
            return $item->userProgress->first()?->status !== 'selesai';
        });

        $progress = $tahapan->userProgress->first();

        $bolehDiakses = $progress?->status === 'selesai'
            || ($tahapanAktif && $tahapanAktif->id === $tahapan->id);

        abort_unless(
            $bolehDiakses,
            403,
            'Selesaikan tahapan sebelumnya terlebih dahulu.'
        );

        // ==========================================
        // PENANGANAN PRE-TEST DAN POST-TEST
        // ==========================================

        if (in_array($tahapan->tipe, ['pre_test', 'post_test'])) {

            // Ambil Ruang Ujian yang sudah dipilih guru
            $ruangUjian = $tahapan->ruangUjian()
                ->with(['guru', 'soal'])
                ->first();

            // Pastikan Ruang Ujian sudah dipilih
            abort_if(
                !$ruangUjian,
                404,
                'Ruang Ujian untuk tahapan ini belum dikonfigurasi oleh guru.'
            );

            // Pastikan ujian aktif dan memiliki soal
            abort_if(
                $ruangUjian->status !== 'aktif' || $ruangUjian->soal->isEmpty(),
                403,
                'Ruang Ujian belum aktif atau belum memiliki soal.'
            );

            // Cari hasil ujian siswa
            $hasilUjian = HasilUjian::where('user_id', $userId)
                ->where('ruang_ujian_id', $ruangUjian->id)
                ->first();

            // Jika ujian sudah selesai
            if ($hasilUjian && $hasilUjian->status === 'selesai') {

                TahapanUser::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'tahapan_id' => $tahapan->id,
                    ],
                    [
                        'status' => 'selesai',
                        'exp_didapat' => (int) $hasilUjian->exp_diperoleh,
                        'completed_at' => $hasilUjian->finished_at ?? now(),
                    ]
                );

                return redirect()->route('siswa.ujian.hasil', [
                    'hasil_id' => $hasilUjian->id,
                ]);
            }

            // Jika ujian sudah dimulai tetapi belum selesai
            if ($hasilUjian && $hasilUjian->status === 'berlangsung') {

                return redirect()->route('siswa.ujian.kerjakan', [
                    'hasil_id' => $hasilUjian->id,
                ]);
            }

            // Jika belum pernah mengerjakan
            return view(
                'siswa.ruang-belajar.tahapan.konten.ujian',
                compact(
                    'ruangBelajar',
                    'tahapan',
                    'ruangUjian',
                    'hasilUjian'
                )
            );
        }

        // ==========================================
        // PENANGANAN TAHAPAN MATERI
        // ==========================================

        if ($tahapan->tipe === 'materi') {

            $user = Auth::user();

            // Ambil Ruang Materi yang terhubung dengan tahapan
            $tahapan->load([
                'ruangMateri.subMateris' => function ($query) {
                    $query->where('status', 'terbit')
                        ->orderBy('urutan', 'asc');
                }
            ]);

            $ruangMateri = $tahapan->ruangMateri;

            abort_if(
                !$ruangMateri,
                404,
                'Materi untuk tahapan ini belum dikonfigurasi oleh guru.'
            );

            // Jadikan satu materi sebagai collection
            $materis = collect([$ruangMateri]);

            // Ambil seluruh ID submateri
            $submateriIds = $ruangMateri->subMateris->pluck('id');

            // Ambil progres siswa
            $progressSubmateri = SubmateriProgress::where('user_id', $userId)
                ->whereIn('submateri_id', $submateriIds)
                ->get()
                ->keyBy('submateri_id');

            // Ambil ID submateri yang sudah selesai
            $completedIds = $progressSubmateri
                ->filter(function ($progress) {
                    return !is_null($progress->completed_at);
                })
                ->keys()
                ->toArray();

            // Total XP global siswa
            $totalXp = $user->totalXp();

            // Level siswa
            $level = (int) floor($totalXp / 100) + 1;

            $xpInLevel = $totalXp % 100;
            $xpNeeded = 100;
            $xpPercentage = ($xpInLevel / $xpNeeded) * 100;

            // Statistik khusus materi ini
            $totalSubmateri = $ruangMateri->subMateris->count();
            $totalCompleted = count($completedIds);

            $overallProgress = $totalSubmateri > 0
                ? round(($totalCompleted / $totalSubmateri) * 100)
                : 0;

            // XP khusus materi ini
            $totalXP = (int) $ruangMateri->subMateris->sum('xp_reward');

            $xpDiperoleh = (int) $progressSubmateri
                ->filter(function ($progress) {
                    return !is_null($progress->completed_at);
                })
                ->sum('xp_earned');

            $jumlahSelesai = $totalCompleted;

            return view(
                'siswa.aktivitas-materi.dashboard.index',
                compact(
                    'user',
                    'ruangBelajar',
                    'tahapan',
                    'ruangMateri',
                    'materis',
                    'progressSubmateri',
                    'completedIds',
                    'totalXp',
                    'level',
                    'xpInLevel',
                    'xpNeeded',
                    'xpPercentage',
                    'totalSubmateri',
                    'totalCompleted',
                    'overallProgress',
                    'totalXP',
                    'xpDiperoleh',
                    'jumlahSelesai'
                )
            );
        }

        // ==========================================
        // PENANGANAN TIPE TAHAPAN LAINNYA
        // ==========================================

        $konten = $tahapan->konten ?? [];

        if (is_string($konten)) {
            $konten = json_decode($konten, true) ?? [];
        }

        $view = match ($tahapan->tipe) {

            'jeda_hening',
            'jeda_hening_checkin',
            'checkin' => 'siswa.ruang-belajar.tahapan.konten.jeda-hening',

            'apersepsi' => 'siswa.ruang-belajar.tahapan.konten.apersepsi',

            'ice_breaking' => 'siswa.ruang-belajar.tahapan.konten.ice-breaking',

            default => abort(404, 'Tipe tahapan tidak ditemukan.')
        };

        // Hilangkan kunci jawaban dari aktivitas susun kode
        if ($tahapan->tipe === 'ice_breaking') {

            foreach ($konten['aktivitas'] ?? [] as &$aktivitas) {

                if (($aktivitas['tipe'] ?? null) === 'susun_kode') {

                    unset(
                        $aktivitas['konfigurasi']['urutan_benar'],
                        $aktivitas['konfigurasi']['urutan_benar_text']
                    );
                }
            }

            unset($aktivitas);
        }

        return view(
            $view,
            compact(
                'ruangBelajar',
                'tahapan',
                'konten'
            )
        );
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

        if (in_array($tahapan->tipe, ['pre_test', 'post_test'])) {

            // Ambil Ruang Ujian yang sudah dipilih guru
            $ruangUjian = $tahapan->ruangUjian()
                ->where('status', 'aktif')
                ->first();

            if (!$ruangUjian) {
                return back()->with(
                    'error',
                    'Ruang Ujian belum dipilih atau belum aktif.'
                );
            }

            // Cari hasil ujian siswa
            $hasilUjian = HasilUjian::where('user_id', $userId)
                ->where('ruang_ujian_id', $ruangUjian->id)
                ->first();

            if (!$hasilUjian) {
                return back()->with(
                    'error',
                    'Anda belum mengerjakan ujian ini.'
                );
            }

            // Ujian harus benar-benar selesai
            if ($hasilUjian->status !== 'selesai') {
                return back()->with(
                    'error',
                    'Selesaikan ujian terlebih dahulu.'
                );
            }

            // Pastikan hasil ujian memang terkait dengan tahapan ini
            if ((int) $hasilUjian->tahapan_id !== (int) $tahapan->id) {
                return back()->with(
                    'error',
                    'Hasil ujian tidak sesuai dengan tahapan ini.'
                );
            }

            $expDidapat = (int) $hasilUjian->exp_diperoleh;

            // Sinkronkan progres tahapan dengan hasil ujian
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

                // Jangan berikan EXP dua kali
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
                        'completed_at' => $hasilUjian->finished_at ?? now(),
                    ]
                );
            });

            return redirect()
                ->route('siswa.ruang-belajar.tahapan', [
                    'id' => $ruang_belajar_id,
                ])
                ->with(
                    'success',
                    "Ujian berhasil diselesaikan! Kamu mendapatkan {$expDidapat} EXP."
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

        $jawabanSiswa = [
            'jawaban' => $validated['jawaban'] ?? [],
            'selesai' => $validated['selesai'] ?? [],
            'check_in_jawaban' => $validated['check_in_jawaban'] ?? null,
        ];

        $expDidapat = 0;

        DB::transaction(function () use (
            $userId,
            $tahapan,
            $jawabanSiswa,
            &$expDidapat
        ) {

            $progress = TahapanUser::where('user_id', $userId)
                ->where('tahapan_id', $tahapan->id)
                ->lockForUpdate()
                ->first();

            // Cegah pemberian EXP berulang
            if ($progress && $progress->status === 'selesai') {
                return;
            }

            $expDidapat = (int) ($tahapan->xp_reward ?? 0);

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
}
