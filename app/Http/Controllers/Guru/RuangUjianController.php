<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use App\Models\HasilUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class RuangUjianController extends Controller
{
     public function index(Request $request)
    {
        $guruId = Auth::id();

        $query = RuangUjian::where('guru_id', $guruId)
            ->withCount('soal')
            ->withSum('soal', 'exp')
            ->withCount('hasilUjian')
            ->latest();

        // Pencarian berdasarkan judul ruang ujian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('judul', 'like', "%{$search}%");
        }

        // Filter status
        if ($request->filled('status') &&
            in_array($request->status, ['draft', 'aktif', 'nonaktif'])) {

            $query->where('status', $request->status);
        }

        $ruangUjians = $query->paginate(10)->withQueryString();

        // Statistik ruang ujian milik guru
        $statistik = [
            'total' => RuangUjian::where('guru_id', $guruId)->count(),

            'aktif' => RuangUjian::where('guru_id', $guruId)
                ->where('status', 'aktif')
                ->count(),

            'draft' => RuangUjian::where('guru_id', $guruId)
                ->where('status', 'draft')
                ->count(),

            'nonaktif' => RuangUjian::where('guru_id', $guruId)
                ->where('status', 'nonaktif')
                ->count(),
        ];

        return view('guru.ruang-ujian.index', compact(
            'ruangUjians',
            'statistik'
        ));
    }

    /**
     * Menampilkan halaman form pembuatan ruang ujian.
     */
    public function create()
    {
        return view('guru.ruang-ujian.create');
    }

    /**
     * Menyimpan ruang ujian baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'durasi_menit' => [
                'required',
                'integer',
                'min:1',
                'max:600',
            ],

            'maksimal_percobaan' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],

            'acak_soal' => [
                'nullable',
                'boolean',
            ],

            'acak_jawaban' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'aktif', 'nonaktif']),
            ],
        ]);

        $validated['guru_id'] = Auth::id();

        // Checkbox yang tidak dicentang akan bernilai false
        $validated['acak_soal'] = $request->boolean('acak_soal');
        $validated['acak_jawaban'] = $request->boolean('acak_jawaban');

        $ruangUjian = RuangUjian::create($validated);

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Ruang ujian berhasil dibuat. Silakan tambahkan soal ujian.');
    }

    /**
     * Menampilkan detail ruang ujian beserta soal-soalnya.
     */
    public function show($id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->with([
                'soal',
                'hasilUjian.siswa',
                'hasilUjian.jawaban.soal',
            ])
            ->withCount('soal')
            ->withSum('soal', 'exp')
            ->findOrFail($id);

        $totalExp = (int) ($ruangUjian->soal_sum_exp ?? 0);

        return view('guru.ruang-ujian.show', compact(
            'ruangUjian',
            'totalExp'
        ));
    }

    public function simpanPenilaian(Request $request, $ruangUjianId, $hasilUjianId)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruangUjianId);

        $hasilUjian = HasilUjian::where('ruang_ujian_id', $ruangUjian->id)
            ->where('status', 'selesai')
            ->findOrFail($hasilUjianId);

        $validated = $request->validate([
            'nilai' => ['required', 'array'],
            'nilai.*' => ['nullable', 'numeric', 'min:0'],

            'catatan' => ['nullable', 'array'],
            'catatan.*' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            DB::transaction(function () use ($validated, $hasilUjian) {

                $hasil = HasilUjian::whereKey($hasilUjian->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $jawaban = $hasil->jawaban()
                    ->with('soal')
                    ->get()
                    ->keyBy('id');

                // Simpan nilai dan catatan guru.
                foreach ($validated['nilai'] as $jawabanId => $nilai) {

                    if ($nilai === null || $nilai === '') {
                        continue;
                    }

                    $item = $jawaban->get($jawabanId);

                    if (!$item || !$item->soal) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'nilai' => 'Jawaban siswa tidak ditemukan.',
                        ]);
                    }

                    if ($item->soal->tipe !== 'esai') {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'nilai' => 'Hanya jawaban esai yang dapat dinilai manual.',
                        ]);
                    }

                    $skorMaksimal = (float) (
                        $item->soal->skor_maksimal ?? 100
                    );

                    if ((float) $nilai > $skorMaksimal) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'nilai' => "Nilai soal nomor {$item->soal->urutan} maksimal {$skorMaksimal}.",
                        ]);
                    }

                    $item->update([
                        'skor_esai' => $nilai,
                        'catatan_guru' => $validated['catatan'][$jawabanId] ?? null,
                        'dinilai_pada' => now(),
                    ]);
                }

                // Ambil ulang jawaban setelah penilaian disimpan.
                $jawabanTerbaru = $hasil->jawaban()
                    ->with('soal')
                    ->get();

                $jawabanEsai = $jawabanTerbaru->filter(function ($item) {
                    return $item->soal?->tipe === 'esai';
                });

                $semuaEsaiDinilai = $jawabanEsai->every(function ($item) {
                    return $item->skor_esai !== null;
                });

                // Nilai akhir hanya diperbarui jika seluruh esai telah dinilai.
                if ($semuaEsaiDinilai) {

                    $totalSkor = 0;
                    $totalMaksimal = 0;

                    foreach ($jawabanTerbaru as $item) {

                        $soal = $item->soal;

                        if (!$soal) {
                            continue;
                        }

                        $skorMaksimal = (float) (
                            $soal->skor_maksimal ?? 100
                        );

                        $totalMaksimal += $skorMaksimal;

                        if ($soal->tipe === 'esai') {
                            $totalSkor += (float) $item->skor_esai;
                        } elseif ($item->benar) {
                            $totalSkor += $skorMaksimal;
                        }
                    }

                    $nilaiAkhir = $totalMaksimal > 0
                        ? round(($totalSkor / $totalMaksimal) * 100, 2)
                        : 0;

                    $hasil->update([
                        'nilai' => $nilaiAkhir,
                    ]);

                    $hasil->refresh();

                    // Sinkronkan progres setelah semua esai selesai dinilai.
                    if (method_exists($this, 'sinkronkanProgresTahapan')) {
                        $this->sinkronkanProgresTahapan($hasil);
                    }
                }
            });

            return redirect()
                ->route('guru.ruang-ujian.show', $ruangUjian->id)
                ->with('success', 'Penilaian jawaban siswa berhasil disimpan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('guru.ruang-ujian.show', $ruangUjian->id)
                ->with(
                    'error',
                    config('app.debug')
                        ? 'Error: ' . $e->getMessage()
                        : 'Terjadi kesalahan saat menyimpan penilaian. Periksa log aplikasi.'
                );
        }
    }

    /**
     * Menampilkan form edit ruang ujian.
     */
    public function edit($id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($id);

        return view('guru.ruang-ujian.edit', compact('ruangUjian'));
    }

    /**
     * Memperbarui informasi ruang ujian.
     */
    public function update(Request $request, $id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'durasi_menit' => [
                'required',
                'integer',
                'min:1',
                'max:600',
            ],

            'maksimal_percobaan' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],

            'acak_soal' => [
                'nullable',
                'boolean',
            ],

            'acak_jawaban' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'aktif', 'nonaktif']),
            ],
        ]);

        $validated['acak_soal'] = $request->boolean('acak_soal');
        $validated['acak_jawaban'] = $request->boolean('acak_jawaban');

        $ruangUjian->update($validated);

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Ruang ujian berhasil diperbarui.');
    }

    /**
     * Menghapus ruang ujian.
     */
    public function destroy($id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->with([
                'hasilUjian.jawaban',
                'soal',
            ])
            ->findOrFail($id);

        try {
            DB::transaction(function () use ($ruangUjian) {

                // Hapus seluruh jawaban siswa dari setiap hasil ujian.
                foreach ($ruangUjian->hasilUjian as $hasil) {
                    $hasil->jawaban()->delete();
                }

                // Hapus seluruh hasil pengerjaan siswa.
                $ruangUjian->hasilUjian()->delete();

                // Hapus seluruh soal ujian.
                $ruangUjian->soal()->delete();

                // Hapus ruang ujian.
                $ruangUjian->delete();
            });

            return redirect()
                ->route('guru.ruang-ujian.index')
                ->with('success', 'Ruang ujian beserta seluruh data terkait berhasil dihapus.');

        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                config('app.debug')
                    ? 'Gagal menghapus ruang ujian: ' . $e->getMessage()
                    : 'Terjadi kesalahan saat menghapus ruang ujian.'
            );
        }
    }
}
