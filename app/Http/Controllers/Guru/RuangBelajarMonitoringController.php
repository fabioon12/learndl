<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use App\Models\Tahapan;
use App\Models\TahapanUser;

class RuangBelajarMonitoringController extends Controller
{
      public function index($ruang_belajar)
    {
        // 1. Ambil ruang belajar beserta seluruh tahapannya
        $ruangBelajar = RuangBelajar::with('tahapans')
            ->findOrFail($ruang_belajar);

        $tahapans = $ruangBelajar->tahapans;

        $tahapanIds = $tahapans->pluck('id');

        // 2. Ambil siswa beserta progresnya
        $ruangBelajar->load([
            'siswa.tahapanProgress' => function ($query) use ($tahapanIds) {
                $query->whereIn('tahapan_id', $tahapanIds);
            }
        ]);

        // 3. Olah progres masing-masing siswa
        $monitoringSiswa = $ruangBelajar->siswa->map(
            function ($siswa) use ($tahapans) {

                $totalTahapan = $tahapans->count();

                // Kelompokkan progres berdasarkan tahapan
                $progress = $siswa->tahapanProgress
                    ->keyBy('tahapan_id');

                // Hitung tahapan selesai
                $tahapanSelesai = $tahapans->filter(
                    function ($tahapan) use ($progress) {
                        return optional(
                            $progress->get($tahapan->id)
                        )->status === 'selesai';
                    }
                );

                $totalSelesai = $tahapanSelesai->count();

                // Hitung persentase
                $persentase = $totalTahapan > 0
                    ? round(($totalSelesai / $totalTahapan) * 100)
                    : 0;

                // Cari tahapan pertama yang belum selesai
                $tahapanAktif = $tahapans->first(
                    function ($tahapan) use ($progress) {

                        $dataProgress = $progress->get($tahapan->id);

                        return !$dataProgress ||
                            $dataProgress->status !== 'selesai';
                    }
                );

                // Cari tahapan terakhir yang selesai
                $tahapanTerakhir = $tahapanSelesai->last();

                // Tentukan status keseluruhan
                if ($totalTahapan === 0 || $totalSelesai === 0) {
                    $status = 'belum_dimulai';
                } elseif ($totalSelesai === $totalTahapan) {
                    $status = 'selesai';
                } else {
                    $status = 'sedang_berlangsung';
                }

                // Tambahkan informasi monitoring ke objek siswa
                $siswa->monitoring = [
                    'total_tahapan' => $totalTahapan,
                    'tahapan_selesai' => $totalSelesai,
                    'persentase' => $persentase,
                    'status' => $status,

                    'tahapan_aktif' => $tahapanAktif,

                    'tahapan_terakhir' => $tahapanTerakhir,

                    'progress' => $progress,
                ];

                return $siswa;
            }
        );

        // 4. Statistik keseluruhan ruang belajar
        $totalSiswa = $monitoringSiswa->count();

        $totalSelesai = $monitoringSiswa
            ->where('monitoring.status', 'selesai')
            ->count();

        $totalBerlangsung = $monitoringSiswa
            ->where('monitoring.status', 'sedang_berlangsung')
            ->count();

        $totalBelumMulai = $monitoringSiswa
            ->where('monitoring.status', 'belum_dimulai')
            ->count();

        $rataRataProgress = $totalSiswa > 0
            ? round(
                $monitoringSiswa->avg('monitoring.persentase')
            )
            : 0;

        return view(
            'guru.ruang-belajar.monitoring.index',
            compact(
                'ruangBelajar',
                'monitoringSiswa',
                'totalSiswa',
                'totalSelesai',
                'totalBerlangsung',
                'totalBelumMulai',
                'rataRataProgress'
            )
        );
    }

    public function showTahapan($ruang_belajar, $tahapan)
    {
        // 1. Ambil ruang belajar beserta siswa dan tahapannya
        $ruangBelajar = RuangBelajar::with([
            'siswa',
            'tahapans'
        ])->findOrFail($ruang_belajar);

        // 2. Pastikan tahapan merupakan milik ruang belajar tersebut
        $tahapan = $ruangBelajar->tahapans()
            ->where('id', $tahapan)
            ->firstOrFail();

        // 3. Validasi kepemilikan ruang belajar
        $userId = auth()->id();

        abort_unless(
            (int) $ruangBelajar->guru_id === (int) $userId ||
            (int) $ruangBelajar->user_id === (int) $userId,
            403
        );

        // 4. Ambil seluruh siswa yang terdaftar di ruang belajar
        $daftarSiswa = $ruangBelajar->siswa;

        // 5. Ambil seluruh progres siswa pada tahapan yang dipilih
        $progressSiswa = TahapanUser::with('user')
            ->where('tahapan_id', $tahapan->id)
            ->get()
            ->keyBy('user_id');

        // 6. Gabungkan data siswa dengan progres masing-masing
        $aktivitasSiswa = $daftarSiswa->map(function ($siswa) use ($progressSiswa) {

            $progress = $progressSiswa->get($siswa->id);

            return [
                'siswa' => $siswa,
                'progress' => $progress,
                'status' => $progress->status ?? 'belum_dimulai',
                'jawaban' => $progress->jawaban ?? [],
                'completed_at' => $progress->completed_at ?? null,
                'updated_at' => $progress->updated_at ?? null,
                'exp_didapat' => $progress->exp_didapat ?? 0,
            ];
        });

        // 7. Statistik monitoring
        $totalSiswa = $daftarSiswa->count();

        $totalDimulai = $aktivitasSiswa->filter(function ($item) {
            return $item['progress'] !== null;
        })->count();

        $totalSelesai = $aktivitasSiswa->filter(function ($item) {
            return $item['status'] === 'completed'
                || $item['status'] === 'selesai';
        })->count();

        $totalBelumDimulai = $totalSiswa - $totalDimulai;

        $persentaseSelesai = $totalSiswa > 0
            ? round(($totalSelesai / $totalSiswa) * 100)
            : 0;

        // 8. Tentukan tipe tahapan
        $tipeTahapan = strtolower(
            str_replace('_', '-', $tahapan->tipe ?? '')
        );

        // 9. Ambil konfigurasi konten tahapan
        $konten = $tahapan->konten ?? [];

        // 10. Data jawaban forum untuk tipe Apersepsi
        $jawabanSiswa = $aktivitasSiswa
            ->filter(function ($item) {
                return filled(data_get($item['jawaban'], 'forum'));
            })
            ->map(function ($item) {
                return (object) [
                    'user' => $item['siswa'],
                    'jawaban' => $item['jawaban'],
                    'updated_at' => $item['updated_at'],
                ];
            })
            ->values();

        return view(
            'guru.ruang-belajar.monitoring.tahapan',
            compact(
                'ruangBelajar',
                'tahapan',
                'tipeTahapan',
                'konten',
                'daftarSiswa',
                'progressSiswa',
                'aktivitasSiswa',
                'jawabanSiswa',
                'totalSiswa',
                'totalDimulai',
                'totalSelesai',
                'totalBelumDimulai',
                'persentaseSelesai'
            )
        );
    }

}
