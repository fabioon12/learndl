<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use App\Models\JawabanUjian;
use App\Models\HasilUjian;
use App\Models\Tahapan;
use App\Models\TahapanUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UjianController extends Controller
{
    public function index()
    {
        $siswaId = Auth::id();

        $ruangUjians = RuangUjian::query()
            ->where('status', 'aktif')
            ->withCount('soal')
            ->withSum('soal', 'exp')
            ->with([
                'hasilUjian' => function ($query) use ($siswaId) {
                    $query->where('user_id', $siswaId)
                        ->latest();
                }
            ])
            ->latest()
            ->get();

        // Tentukan status ujian berdasarkan hasil pengerjaan siswa.
        $ruangUjians->each(function ($ujian) {

            $hasil = $ujian->hasilUjian->first();

            $ujian->hasil_saya = $hasil;

            if (!$hasil) {
                $ujian->status_siswa = 'tersedia';
            } elseif ($hasil->status === 'berlangsung') {
                $ujian->status_siswa = 'berlangsung';
            } else {
                $ujian->status_siswa = 'selesai';
            }
        });

        // Statistik ujian siswa.
        $totalUjian = $ruangUjians->count();

        $totalTersedia = $ruangUjians
            ->where('status_siswa', 'tersedia')
            ->count();

        $totalBerlangsung = $ruangUjians
            ->where('status_siswa', 'berlangsung')
            ->count();

        $totalSelesai = $ruangUjians
            ->where('status_siswa', 'selesai')
            ->count();

        return view('siswa.ujian.index', compact(
            'ruangUjians',
            'totalUjian',
            'totalTersedia',
            'totalBerlangsung',
            'totalSelesai'
        ));
    }
    public function detailMandiri($ruang_ujian_id)
    {
        $ruangUjian = RuangUjian::query()
            ->where('status', 'aktif')
            ->withCount('soal')
            ->withSum('soal', 'exp')
            ->findOrFail($ruang_ujian_id);

        if ($ruangUjian->soal_count < 1) {
            return redirect()
                ->route('siswa.ujian.index')
                ->with('error', 'Ujian belum memiliki soal.');
        }

        $hasilUjian = HasilUjian::where(
            'ruang_ujian_id',
            $ruangUjian->id
        )
            ->where('user_id', Auth::id())
            ->first();

        return view('siswa.ujian.detail', compact(
            'ruangUjian',
            'hasilUjian'
        ));
    }
    public function mulaiMandiri($ruang_ujian_id)
    {
        $siswaId = Auth::id();

        $hasil = DB::transaction(function () use (
            $ruang_ujian_id,
            $siswaId
        ) {

            $ruangUjian = RuangUjian::where('status', 'aktif')
                ->lockForUpdate()
                ->findOrFail($ruang_ujian_id);

            $totalSoal = $ruangUjian->soal()->count();

            if ($totalSoal < 1) {
                return null;
            }

            // Periksa apakah siswa sudah pernah mengambil ujian.
            $hasil = HasilUjian::where(
                'user_id',
                $siswaId
            )
                ->where(
                    'ruang_ujian_id',
                    $ruangUjian->id
                )
                ->first();

            // Jika belum pernah, buat hasil ujian baru.
            if (!$hasil) {
                $hasil = HasilUjian::create([
                    'ruang_ujian_id' => $ruangUjian->id,
                    'user_id' => $siswaId,
                    'tahapan_id' => null,
                    'total_soal' => $totalSoal,
                    'jumlah_benar' => 0,
                    'jumlah_salah' => 0,
                    'nilai' => 0,
                    'exp_diperoleh' => 0,
                    'status' => 'berlangsung',
                    'started_at' => now(),
                ]);
            }

            return $hasil;
        });

        if (!$hasil) {
            return back()->with(
                'error',
                'Ujian belum memiliki soal.'
            );
        }

        // Jika sudah selesai, arahkan ke halaman nilai.
        if ($hasil->status === 'selesai') {
            return redirect()->route(
                'siswa.ujian.hasil',
                $hasil->id
            )->with('info', 'Kamu sudah menyelesaikan ujian ini.');
        }

        // Jika masih berlangsung, arahkan ke pengerjaan.
        return redirect()->route(
            'siswa.ujian.kerjakan',
            $hasil->id
        );
    }
    public function kerjakan($hasil_id)
    {
        $hasilUjian = HasilUjian::with([
            'ruangUjian',
            'jawaban'
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($hasil_id);

        // Ujian yang sudah selesai tidak dapat dikerjakan kembali.
        if ($hasilUjian->status === 'selesai') {
            return redirect()->route(
                'siswa.ujian.hasil',
                $hasilUjian->id
            );
        }

        $ruangUjian = $hasilUjian->ruangUjian;

        // Pastikan waktu mulai sudah tercatat.
        if (!$hasilUjian->started_at) {
            abort(409, 'Waktu mulai ujian belum tercatat.');
        }

        // Hitung batas waktu ujian.
        $batasWaktu = $hasilUjian->started_at
            ->copy()
            ->addMinutes((int) $ruangUjian->durasi_menit);

        // Jika waktu habis, langsung selesaikan ujian.
        if (now()->greaterThanOrEqualTo($batasWaktu)) {
            return $this->selesaikanUjian($hasilUjian);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Soal
        |--------------------------------------------------------------------------
        | Hanya ambil kolom yang dibutuhkan siswa.
        | Kunci jawaban, pembahasan, dan rubrik penilaian tidak dikirim
        | ke halaman pengerjaan ujian.
        */

        $soalUjians = $ruangUjian->soal()
            ->select([
                'id',
                'ruang_ujian_id',
                'urutan',
                'pertanyaan',
                'tipe',
                'opsi',
                'exp',
            ])
            ->orderBy('urutan')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil Jawaban Siswa
        |--------------------------------------------------------------------------
        | Format:
        | [
        |     soal_id => jawaban_siswa
        | ]
        */

        $daftarIdSoal = $soalUjians->pluck('id');

        $jawabanAwal = $hasilUjian->jawaban
            ->whereIn('soal_ujian_id', $daftarIdSoal)
            ->mapWithKeys(function ($item) {
                return [
                    $item->soal_ujian_id => $item->jawaban_siswa
                ];
            })
            ->all();

        // Data untuk timer.
        $sisaDetik = max(
            0,
            now()->diffInSeconds($batasWaktu, false)
        );

        return view('siswa.ujian.kerjakan', compact(
            'hasilUjian',
            'ruangUjian',
            'soalUjians',
            'jawabanAwal',
            'batasWaktu',
            'sisaDetik'
        ));
    }

    private function sinkronkanProgresTahapan(HasilUjian $hasilUjian)
    {
        // Ujian mandiri tidak membutuhkan progres tahapan
        if (!$hasilUjian->tahapan_id) {
            return;
        }

        // Pastikan ujian sudah selesai
        if ($hasilUjian->status !== 'selesai') {
            return;
        }

        // Pastikan ujian sesuai dengan tahapan Pre-Test/Post-Test
        $tahapan = Tahapan::where('id', $hasilUjian->tahapan_id)
            ->where('ruang_ujian_id', $hasilUjian->ruang_ujian_id)
            ->whereIn('tipe', ['pre_test', 'post_test'])
            ->first();

        if (!$tahapan) {
            return;
        }

        TahapanUser::updateOrCreate(
            [
                'user_id' => $hasilUjian->user_id,
                'tahapan_id' => $tahapan->id,
            ],
            [
                'status' => 'selesai',

                // Salinan informasi EXP ujian.
                // Tidak dijumlahkan lagi dalam EXP global.
                'exp_didapat' => (int) $hasilUjian->exp_diperoleh,

                'jawaban' => [
                    'hasil_ujian_id' => $hasilUjian->id,
                    'nilai' => $hasilUjian->nilai,
                    'jumlah_benar' => $hasilUjian->jumlah_benar,
                    'jumlah_salah' => $hasilUjian->jumlah_salah,
                ],

                'completed_at' => $hasilUjian->finished_at ?? now(),
            ]
        );
    }

    public function selesaikan(Request $request, $hasil_id)
    {
        $validated = $request->validate([
            'jawaban' => ['nullable', 'array'],
            'jawaban.*' => ['nullable', 'string', 'max:20000'],
        ]);

        $hasilUjian = HasilUjian::where('user_id', Auth::id())
            ->findOrFail($hasil_id);

        if ($hasilUjian->status === 'selesai') {
            return redirect()
                ->route('siswa.ujian.hasil', [
                    'hasil_id' => $hasilUjian->id,
                ])
                ->with('info', 'Ujian sudah pernah diselesaikan.');
        }

        return $this->prosesPenilaian(
            $hasilUjian,
            $validated['jawaban'] ?? []
        );
    }
    private function selesaikanUjian(HasilUjian $hasilUjian)
    {
        $jawabanTersimpan = JawabanUjian::where(
            'hasil_ujian_id',
            $hasilUjian->id
        )
            ->get()
            ->keyBy('soal_ujian_id');

        $jawabanRequest = [];

        foreach ($jawabanTersimpan as $soalId => $jawaban) {
            $jawabanRequest[$soalId] = $jawaban->jawaban_siswa;
        }

        return $this->prosesPenilaian(
            $hasilUjian,
            $jawabanRequest
        );
    }
    private function prosesPenilaian(
        HasilUjian $hasilUjian,
        array $jawabanRequest
    ) {
        return DB::transaction(function () use (
            $hasilUjian,
            $jawabanRequest
        ) {

            // Kunci hasil ujian untuk mencegah proses pengumpulan ganda.
            $hasilUjian = HasilUjian::where('user_id', Auth::id())
                ->lockForUpdate()
                ->findOrFail($hasilUjian->id);

            if ($hasilUjian->status === 'selesai') {

                return redirect()
                    ->route('siswa.ujian.hasil', [
                        'hasil_id' => $hasilUjian->id,
                    ])
                    ->with('info', 'Ujian sudah pernah diselesaikan.');
            }

            // Ambil seluruh soal ujian.
            $ruangUjian = RuangUjian::with('soal')
                ->findOrFail($hasilUjian->ruang_ujian_id);

            $soalUjians = $ruangUjian->soal
                ->sortBy('urutan')
                ->values();

            $daftarIdSoal = $soalUjians->pluck('id')->all();

            // Abaikan ID soal yang bukan bagian dari ujian ini.
            $jawabanRequest = array_intersect_key(
                $jawabanRequest,
                array_flip($daftarIdSoal)
            );

            $jumlahBenar = 0;
            $jumlahSalah = 0;
            $totalExp = 0;

            $jumlahEsai = 0;
            $jumlahPilihanGanda = 0;

            // ==========================================
            // PROSES PENILAIAN SETIAP SOAL
            // ==========================================

            foreach ($soalUjians as $soal) {

                $jawabanSiswa = $jawabanRequest[$soal->id] ?? null;

                // Normalisasi jawaban kosong.
                if (
                    $jawabanSiswa !== null &&
                    trim((string) $jawabanSiswa) === ''
                ) {
                    $jawabanSiswa = null;
                }

                $benar = false;
                $expDiperoleh = 0;

                if ($soal->tipe === 'pilihan_ganda') {

                    $jumlahPilihanGanda++;

                    $benar = $jawabanSiswa !== null
                        && strtoupper(trim((string) $jawabanSiswa))
                            === strtoupper(trim((string) $soal->jawaban_benar));

                    if ($benar) {
                        $jumlahBenar++;

                        $expDiperoleh = (int) $soal->exp;
                    } else {
                        $jumlahSalah++;
                    }

                } elseif ($soal->tipe === 'esai') {

                    $jumlahEsai++;

                    // Esai tidak dinilai otomatis.
                    // Nilai esai akan diberikan oleh guru.
                    $benar = false;
                    $expDiperoleh = 0;

                }

                // Simpan jawaban siswa.
                JawabanUjian::updateOrCreate(
                    [
                        'hasil_ujian_id' => $hasilUjian->id,
                        'soal_ujian_id' => $soal->id,
                    ],
                    [
                        'jawaban_siswa' => $jawabanSiswa,
                        'benar' => $benar,
                        'exp_diperoleh' => $expDiperoleh,
                    ]
                );

                $totalExp += $expDiperoleh;
            }

            // ==========================================
            // NILAI SEMENTARA PILIHAN GANDA
            // ==========================================

            $nilaiSementara = $jumlahPilihanGanda > 0
                ? ($jumlahBenar / $jumlahPilihanGanda) * 100
                : 0;

            // ==========================================
            // SIMPAN HASIL UJIAN
            // ==========================================

            $hasilUjian->update([
                'total_soal' => $soalUjians->count(),
                'jumlah_benar' => $jumlahBenar,
                'jumlah_salah' => $jumlahSalah,
                'nilai' => round($nilaiSementara, 2),
                'exp_diperoleh' => $totalExp,
                'status' => 'selesai',
                'finished_at' => now(),
            ]);

            $hasilUjian->refresh();

            // ==========================================
            // SINKRONISASI PROGRES TAHAPAN
            // ==========================================

            // Jika tidak ada esai, nilai sudah final.
            // Jika ada esai, tunggu sampai guru selesai mengoreksi.
            if ($jumlahEsai === 0) {
                $this->sinkronkanProgresTahapan($hasilUjian);
            }

            return redirect()
                ->route('siswa.ujian.hasil', [
                    'hasil_id' => $hasilUjian->id,
                ])
                ->with(
                    'success',
                    $jumlahEsai > 0
                        ? 'Ujian berhasil dikumpulkan. Jawaban esai menunggu penilaian guru.'
                        : 'Ujian berhasil dikumpulkan dan dinilai.'
                );
        });
    }
    public function hasil($hasil_id)
    {
        $hasilUjian = HasilUjian::with([
            'ruangUjian.guru',
            'jawaban.soal',
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($hasil_id);

        if ($hasilUjian->status !== 'selesai') {
            return redirect()
                ->route('siswa.ujian.kerjakan', $hasilUjian->id)
                ->with('warning', 'Ujian belum selesai.');
        }

        $jawaban = $hasilUjian->jawaban;

        // Pisahkan jawaban berdasarkan tipe soal.
        $jawabanPilihanGanda = $jawaban->filter(function ($item) {
            return $item->soal?->tipe === 'pilihan_ganda';
        });

        $jawabanEsai = $jawaban->filter(function ($item) {
            return $item->soal?->tipe === 'esai';
        });

        $jumlahEsai = $jawabanEsai->count();

        // Esai dianggap sudah dinilai jika skor_esai tidak null.
        $esaiBelumDinilai = $jawabanEsai->filter(function ($item) {
            return $item->skor_esai === null;
        });

        $jumlahEsaiBelumDinilai = $esaiBelumDinilai->count();

        $semuaEsaiDinilai = $jumlahEsaiBelumDinilai === 0;

        // ==========================================
        // HITUNG NILAI PILIHAN GANDA
        // ==========================================

        $totalMaksimalPG = $jawabanPilihanGanda->sum(function ($item) {
            return (float) ($item->soal?->skor_maksimal ?? 100);
        });

        $totalSkorPG = $jawabanPilihanGanda->sum(function ($item) {
            if (!$item->benar) {
                return 0;
            }

            return (float) ($item->soal?->skor_maksimal ?? 100);
        });

        $nilaiPilihanGanda = $totalMaksimalPG > 0
            ? ($totalSkorPG / $totalMaksimalPG) * 100
            : 0;

        // ==========================================
        // HITUNG NILAI ESAI
        // ==========================================

        $totalMaksimalEsai = $jawabanEsai->sum(function ($item) {
            return (float) ($item->soal?->skor_maksimal ?? 100);
        });

        $totalSkorEsai = $jawabanEsai->sum(function ($item) {
            return $item->skor_esai !== null
                ? (float) $item->skor_esai
                : 0;
        });

        // ==========================================
        // NILAI AKHIR / SEMENTARA
        // ==========================================

        if ($semuaEsaiDinilai) {

            $totalMaksimal = $totalMaksimalPG + $totalMaksimalEsai;

            $totalSkor = $totalSkorPG + $totalSkorEsai;

            $nilaiTampil = $totalMaksimal > 0
                ? ($totalSkor / $totalMaksimal) * 100
                : 0;

        } else {

            // Selama esai belum selesai dikoreksi,
            // jangan memasukkan esai ke nilai akhir.
            $nilaiTampil = $nilaiPilihanGanda;
        }

        $nilaiTampil = round($nilaiTampil, 2);

        // ==========================================
        // DURASI
        // ==========================================

        $durasi = $hasilUjian->started_at && $hasilUjian->finished_at
            ? max(
                0,
                $hasilUjian->started_at->diffInMinutes(
                    $hasilUjian->finished_at
                )
            )
            : 0;

        // ==========================================
        // DATA HASIL
        // ==========================================

        $jumlahBenar = (int) $hasilUjian->jumlah_benar;
        $jumlahSalah = (int) $hasilUjian->jumlah_salah;
        $totalSoal = (int) $hasilUjian->total_soal;
        $totalExp = (int) $hasilUjian->exp_diperoleh;

        return view('siswa.ujian.hasil', compact(
            'hasilUjian',
            'jawaban',
            'jawabanPilihanGanda',
            'jawabanEsai',
            'jumlahEsai',
            'jumlahEsaiBelumDinilai',
            'semuaEsaiDinilai',
            'nilaiTampil',
            'nilaiPilihanGanda',
            'totalSkorEsai',
            'totalMaksimalEsai',
            'jumlahBenar',
            'jumlahSalah',
            'totalSoal',
            'totalExp',
            'durasi'
        ));
    }
    public function mulaiDariTahapan($ruang_ujian_id, $tahapan_id)
    {
        $userId = Auth::id();

        $tahapan = Tahapan::with('ruangBelajar')
            ->where('id', $tahapan_id)
            ->where('ruang_ujian_id', $ruang_ujian_id)
            ->whereIn('tipe', ['pre_test', 'post_test'])
            ->firstOrFail();

        $ruangBelajar = $tahapan->ruangBelajar;

        abort_unless(
            $ruangBelajar->siswa()->where('users.id', $userId)->exists(),
            403
        );

        $ruangUjian = RuangUjian::with('soal')
            ->where('id', $ruang_ujian_id)
            ->where('status', 'aktif')
            ->firstOrFail();

        abort_if($ruangUjian->soal->isEmpty(), 403);

        // Cegah siswa mengerjakan ujian yang sama lebih dari sekali
        $hasilUjian = HasilUjian::where('user_id', $userId)
            ->where('ruang_ujian_id', $ruangUjian->id)
            ->first();

        if ($hasilUjian) {
            if ($hasilUjian->status === 'selesai') {
                return redirect()->route('siswa.ujian.hasil', [
                    'hasil_id' => $hasilUjian->id,
                ]);
            }

            return redirect()->route('siswa.ujian.kerjakan', [
                'hasil_id' => $hasilUjian->id,
            ]);
        }

        $hasilUjian = HasilUjian::create([
            'ruang_ujian_id' => $ruangUjian->id,
            'user_id' => $userId,
            'tahapan_id' => $tahapan->id,
            'total_soal' => $ruangUjian->soal->count(),
            'jumlah_benar' => 0,
            'jumlah_salah' => 0,
            'nilai' => 0,
            'exp_diperoleh' => 0,
            'status' => 'berlangsung',
            'started_at' => now(),
        ]);

        return redirect()->route('siswa.ujian.kerjakan', [
            'hasil_id' => $hasilUjian->id,
        ]);
    }
}
