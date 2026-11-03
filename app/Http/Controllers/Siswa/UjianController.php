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

        // Jika ujian sudah selesai, arahkan ke halaman hasil
        if ($hasilUjian->status === 'selesai') {
            return redirect()->route('siswa.ujian.hasil', $hasilUjian->id);
        }

        $ruangUjian = $hasilUjian->ruangUjian;

        // Periksa batas waktu ujian
        $batasWaktu = $hasilUjian->started_at
            ->copy()
            ->addMinutes($ruangUjian->durasi_menit);

        if (now()->greaterThanOrEqualTo($batasWaktu)) {
            return $this->selesaikanUjian($hasilUjian);
        }

        // Ambil soal tanpa membocorkan jawaban benar dan pembahasan
        $soalUjians = $ruangUjian->soal()
            ->orderBy('urutan')
            ->get()
            ->makeHidden(['jawaban_benar', 'pembahasan']);

        // Ambil jawaban siswa yang sudah tersimpan
        $jawabanSaya = $hasilUjian->jawaban
            ->keyBy('soal_ujian_id');

        return view('siswa.ujian.kerjakan', compact(
            'hasilUjian',
            'ruangUjian',
            'soalUjians',
            'jawabanSaya',
            'batasWaktu'
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
            'jawaban.*' => ['nullable', 'string'],
        ]);

        $hasilUjian = HasilUjian::where('user_id', Auth::id())
            ->findOrFail($hasil_id);

        if ($hasilUjian->status === 'selesai') {
            return redirect()
                ->route('siswa.ujian.hasil', ['hasil_id' => $hasilUjian->id])
                ->with('info', 'Ujian sudah pernah diselesaikan.');
        }

        // Jawaban dari form tetap diproses, termasuk ketika waktu sudah habis.
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

            // Ambil dan kunci hasil ujian
            $hasilUjian = HasilUjian::where('user_id', Auth::id())
                ->lockForUpdate()
                ->findOrFail($hasilUjian->id);

            // Jika sudah selesai, pastikan progres tahapan tersinkron
            if ($hasilUjian->status === 'selesai') {
                $this->sinkronkanProgresTahapan($hasilUjian);

                return redirect()
                    ->route('siswa.ujian.hasil', [
                        'hasil_id' => $hasilUjian->id,
                    ])
                    ->with('info', 'Ujian sudah pernah diselesaikan.');
            }

            // Ambil soal dari Ruang Ujian
            $ruangUjian = RuangUjian::with('soal')
                ->findOrFail($hasilUjian->ruang_ujian_id);

            $soalUjians = $ruangUjian->soal;

            $jumlahBenar = 0;
            $jumlahSalah = 0;
            $totalExp = 0;

            // ==========================================
            // PENILAIAN JAWABAN
            // ==========================================

            foreach ($soalUjians as $soal) {

                $jawabanSiswa = $jawabanRequest[$soal->id] ?? null;

                $benar = false;
                $expDiperoleh = 0;

                // Pilihan ganda
                if ($soal->tipe === 'pilihan_ganda') {

                    $benar = $jawabanSiswa !== null
                        && trim((string) $jawabanSiswa) !== ''
                        && strtoupper(trim((string) $jawabanSiswa))
                            === strtoupper(trim((string) $soal->jawaban_benar));

                    if ($benar) {
                        $jumlahBenar++;
                        $expDiperoleh = (int) $soal->exp;
                    } else {
                        $jumlahSalah++;
                    }
                }

                // Esai disimpan untuk penilaian guru.
                // Belum mendapatkan EXP otomatis.

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
            // PERHITUNGAN NILAI
            // ==========================================

            // Esai belum dihitung sampai diperiksa guru
            $totalPilihanGanda = $soalUjians
                ->where('tipe', 'pilihan_ganda')
                ->count();

            $nilai = $totalPilihanGanda > 0
                ? ($jumlahBenar / $totalPilihanGanda) * 100
                : 0;

            // ==========================================
            // SIMPAN HASIL UJIAN
            // ==========================================

            $hasilUjian->update([
                'total_soal' => $soalUjians->count(),
                'jumlah_benar' => $jumlahBenar,
                'jumlah_salah' => $jumlahSalah,
                'nilai' => round($nilai, 2),
                'exp_diperoleh' => $totalExp,
                'status' => 'selesai',
                'finished_at' => now(),
            ]);

            // Refresh agar nilai hasil terbaru digunakan
            $hasilUjian->refresh();

            // ==========================================
            // SINKRONISASI PROGRES TAHAPAN
            // ==========================================

            $this->sinkronkanProgresTahapan($hasilUjian);

            return redirect()
                ->route('siswa.ujian.hasil', [
                    'hasil_id' => $hasilUjian->id,
                ])
                ->with('success', 'Ujian berhasil dikumpulkan!');
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

        return view('siswa.ujian.hasil', compact('hasilUjian'));
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
