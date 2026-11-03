<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tahapan;
use App\Models\RuangBelajar;
use App\Models\RuangUjian;
use App\Models\Materi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TahapanKontenController extends Controller
{
    private function getTahapan($ruang_belajar_id, $tahapan_id)
    {
        $ruangBelajar = RuangBelajar::findOrFail($ruang_belajar_id);

        $pemilikId = $ruangBelajar->guru_id ?? $ruangBelajar->user_id;

        abort_unless((int) $pemilikId === (int) auth()->id(), 403);

        $tahapan = Tahapan::where('ruang_belajar_id', $ruangBelajar->id)
            ->findOrFail($tahapan_id);

        return [$ruangBelajar, $tahapan];
    }

    /**
     * Menampilkan halaman pengisian konten sesuai tipe tahapan.
     */
    public function create($ruang_belajar_id, $tahapan_id)
    {
        [$ruangBelajar, $tahapan] = $this->getTahapan(
            $ruang_belajar_id,
            $tahapan_id
        );

        // Khusus Pre-Test dan Post-Test
        if (in_array($tahapan->tipe, ['pre_test', 'post_test'])) {

            $ruangUjians = RuangUjian::where('guru_id', auth()->id())
                ->where('status', 'aktif')
                ->has('soal')
                ->withCount('soal')
                ->orderByDesc('created_at')
                ->get();

            return view(
                'guru.tahapan-ruang-belajar.konten.ujian',
                compact('ruangBelajar', 'tahapan', 'ruangUjians')
            );
        }

        // Khusus Materi
        if ($tahapan->tipe === 'materi') {

            $ruangMateris = Materi::where('user_id', auth()->id())
                ->withCount('subMateris')
                ->withSum('subMateris', 'xp_reward')
                ->orderByDesc('created_at')
                ->get();

            return view(
                'guru.tahapan-ruang-belajar.konten.materi',
                compact('ruangBelajar', 'tahapan', 'ruangMateris')
            );
        }

        // Tipe aktivitas lainnya
        $views = [
            'jeda_hening' => 'guru.tahapan-ruang-belajar.konten.jeda-hening',
            'apersepsi' => 'guru.tahapan-ruang-belajar.konten.apersepsi',
            'ice_breaking' => 'guru.tahapan-ruang-belajar.konten.ice-breaking',
        ];

        abort_unless(isset($views[$tahapan->tipe]), 404);

        $konten = $tahapan->konten ?? [];

        return view(
            $views[$tahapan->tipe],
            compact('ruangBelajar', 'tahapan', 'konten')
        );
    }

    /**
     * Menyimpan konten aktivitas baru.
     */
    public function store(Request $request, $ruang_belajar_id, $tahapan_id)
    {
        [$ruangBelajar, $tahapan] = $this->getTahapan(
            $ruang_belajar_id,
            $tahapan_id
        );

        // ==========================================
        // 1. KHUSUS PRE-TEST DAN POST-TEST
        // ==========================================
        if (in_array($tahapan->tipe, ['pre_test', 'post_test'])) {

            $validated = $request->validate([
                'ruang_ujian_id' => 'required|integer|exists:ruang_ujians,id',
            ]);

            $ruangUjian = RuangUjian::where('guru_id', auth()->id())
                ->where('status', 'aktif')
                ->has('soal')
                ->findOrFail($validated['ruang_ujian_id']);

            DB::transaction(function () use ($tahapan, $ruangUjian) {
                $tahapan->update([
                    'ruang_ujian_id' => $ruangUjian->id,
                    'ruang_materi_id' => null,
                    'xp_reward' => 0,
                ]);
            });

            return redirect()
                ->route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id)
                ->with(
                    'success',
                    $tahapan->tipe === 'pre_test'
                        ? 'Ruang Ujian berhasil dipasang sebagai Pre-Test.'
                        : 'Ruang Ujian berhasil dipasang sebagai Post-Test.'
                );
        }

        // ==========================================
        // 2. KHUSUS MATERI
        // ==========================================
        if ($tahapan->tipe === 'materi') {

            $validated = $request->validate([
                'ruang_materi_id' => 'required|integer|exists:materis,id',
            ]);

            // Pastikan materi merupakan milik Guru yang login.
            $materi = Materi::where('user_id', auth()->id())
                ->findOrFail($validated['ruang_materi_id']);

            DB::transaction(function () use ($tahapan, $materi) {
                $tahapan->update([
                    'ruang_materi_id' => $materi->id,
                    'ruang_ujian_id' => null,
                    'konten' => null,
                    'xp_reward' => 0,
                ]);
            });

            return redirect()
                ->route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id)
                ->with('success', 'Ruang Materi berhasil dipasang pada tahapan pembelajaran.');
        }

        // ==========================================
        // 3. TIPE AKTIVITAS LAINNYA
        // ==========================================
        $konten = $this->validateKonten($request, $tahapan->tipe);

        DB::transaction(function () use ($tahapan, $konten) {
            $tahapan->update([
                'konten' => $konten,
                'ruang_ujian_id' => null,
                'ruang_materi_id' => null,
            ]);
        });

        return redirect()
            ->route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id)
            ->with('success', 'Konten aktivitas berhasil disimpan.');
    }

    /**
     * Menampilkan halaman edit konten.
     */
    public function edit($ruang_belajar_id, $tahapan_id)
    {
        return $this->create($ruang_belajar_id, $tahapan_id);
    }

    /**
     * Memperbarui konten aktivitas.
     */
    public function update(Request $request, $ruang_belajar_id, $tahapan_id)
    {
        return $this->store($request, $ruang_belajar_id, $tahapan_id);
    }

    /**
     * Validasi berdasarkan tipe aktivitas.
     */
    private function validateKonten(Request $request, $tipe)
    {
        switch ($tipe) {

            case 'jeda_hening':

                return $request->validate([
                    'instruksi' => 'required|string',
                    'durasi' => 'required|integer|min:10|max:600',
                    'check_in.aktif' => 'required|boolean',
                    'check_in.pertanyaan' => 'required_if:check_in.aktif,1|nullable|string',
                    'check_in.pilihan' => 'required_if:check_in.aktif,1|array|min:2',
                    'check_in.pilihan.*' => 'required|string|max:255',
                ]);

            case 'apersepsi':

                return $request->validate([
                    'materi.isi' => 'required|string',
                    'forum.aktif' => 'required|boolean',
                    'forum.judul' => 'nullable|string|max:255',
                    'forum.pertanyaan' => 'required_if:forum.aktif,1|nullable|string',
                    'forum.batas_jawaban' => 'nullable|integer|min:1',
                ]);

            case 'ice_breaking':

                return $request->validate([
                    'aktivitas' => 'required|array|min:1',

                    'aktivitas.*.id' => 'required|string',
                    'aktivitas.*.tipe' => 'required|in:youtube,susun_kode',
                    'aktivitas.*.judul' => 'required|string|max:255',
                    'aktivitas.*.deskripsi' => 'nullable|string',

                    'aktivitas.*.url' => 'required_if:aktivitas.*.tipe,youtube|nullable|url',

                    'aktivitas.*.konfigurasi' => 'nullable|array',
                    'aktivitas.*.konfigurasi.bahasa' => 'nullable|in:javascript,php,python,html',
                    'aktivitas.*.konfigurasi.instruksi' => 'nullable|string',
                    'aktivitas.*.konfigurasi.potongan_kode' => 'required_if:aktivitas.*.tipe,susun_kode|array|min:2',
                    'aktivitas.*.konfigurasi.potongan_kode.*' => 'required|string',
                    'aktivitas.*.konfigurasi.urutan_benar' => 'required_if:aktivitas.*.tipe,susun_kode|array',
                    'aktivitas.*.konfigurasi.urutan_benar.*' => 'required|integer|min:1',
                ]);

            default:
                abort(422, 'Tipe aktivitas tidak dikenali.');
        }
    }
}
