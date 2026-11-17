<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use App\Models\SoalUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SoalUjianController extends Controller
{
    public function create($ruang_ujian_id)
    {
        // Pastikan ruang ujian milik guru yang sedang login
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->withCount('soal')
            ->findOrFail($ruang_ujian_id);

        // Menentukan urutan soal berikutnya
        $urutanBerikutnya = $ruangUjian->soal()->max('urutan') + 1;

        return view('guru.ruang-ujian.soal.create', compact(
            'ruangUjian',
            'urutanBerikutnya'
        ));
    }

    /**
     * Menyimpan soal baru.
     */
    public function store(Request $request, $ruang_ujian_id)
    {
        // =====================================================
        // 1. PASTIKAN RUANG UJIAN MILIK GURU YANG LOGIN
        // =====================================================

        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);


        // =====================================================
        // 2. VALIDASI DATA UTAMA
        // =====================================================

        $validated = $request->validate([

            'pertanyaan' => [
                'required',
                'string',
            ],

            'tipe' => [
                'required',
                Rule::in(['pilihan_ganda', 'esai']),
            ],

            // Pilihan ganda
            'opsi' => [
                'required_if:tipe,pilihan_ganda',
                'nullable',
                'array',
                'min:2',
            ],

            'opsi.*.kode' => [
                'required_if:tipe,pilihan_ganda',
                'nullable',
                'string',
                'max:5',
            ],

            'opsi.*.teks' => [
                'required_if:tipe,pilihan_ganda',
                'nullable',
                'string',
            ],

            'jawaban_benar' => [
                'required_if:tipe,pilihan_ganda',
                'nullable',
                'string',
            ],

            // Jawaban acuan esai
            'jawaban_acuan' => [
                'required_if:tipe,esai',
                'nullable',
                'string',
            ],

            // Skor maksimal esai
            'skor_maksimal' => [
                'required_if:tipe,esai',
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],

            // Rubrik penilaian
            'rubrik_penilaian' => [
                'required_if:tipe,esai',
                'nullable',
                'array',
                'min:1',
            ],

            'rubrik_penilaian.*.nama' => [
                'required_if:tipe,esai',
                'nullable',
                'string',
                'max:100',
            ],

            'rubrik_penilaian.*.bobot' => [
                'required_if:tipe,esai',
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'rubrik_penilaian.*.deskripsi' => [
                'required_if:tipe,esai',
                'nullable',
                'string',
            ],

            // EXP
            'exp' => [
                'required',
                'integer',
                'min:0',
                'max:1000',
            ],

            // Pembahasan
            'pembahasan' => [
                'nullable',
                'string',
            ],

        ], [

            'pertanyaan.required' =>
                'Pertanyaan wajib diisi.',

            'tipe.required' =>
                'Tipe soal wajib dipilih.',

            'opsi.required_if' =>
                'Pilihan jawaban wajib ditambahkan.',

            'opsi.min' =>
                'Minimal harus tersedia 2 pilihan jawaban.',

            'opsi.*.kode.required_if' =>
                'Kode pilihan jawaban wajib diisi.',

            'opsi.*.teks.required_if' =>
                'Isi pilihan jawaban wajib diisi.',

            'jawaban_benar.required_if' =>
                'Kunci jawaban wajib dipilih.',

            'jawaban_acuan.required_if' =>
                'Jawaban acuan esai wajib diisi.',

            'skor_maksimal.required_if' =>
                'Skor maksimal esai wajib diisi.',

            'rubrik_penilaian.required_if' =>
                'Rubrik penilaian esai wajib dibuat.',

            'rubrik_penilaian.min' =>
                'Minimal harus ada satu kriteria penilaian.',

            'exp.required' =>
                'EXP soal wajib diisi.',

        ]);


        // =====================================================
        // 3. VALIDASI KHUSUS PILIHAN GANDA
        // =====================================================

        if ($validated['tipe'] === 'pilihan_ganda') {

            $opsi = $validated['opsi'] ?? [];

            // Pastikan kode opsi tidak duplikat
            $kodeOpsi = collect($opsi)
                ->pluck('kode')
                ->values();

            if ($kodeOpsi->unique()->count() !== $kodeOpsi->count()) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'opsi' => 'Kode pilihan jawaban tidak boleh duplikat.',
                    ]);
            }

            // Pastikan seluruh teks pilihan tidak kosong
            foreach ($opsi as $item) {

                if (empty(trim($item['teks'] ?? ''))) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'opsi' => 'Semua pilihan jawaban harus diisi.',
                        ]);
                }
            }

            // Pastikan kunci jawaban tersedia
            if (!in_array(
                $validated['jawaban_benar'],
                $kodeOpsi->toArray(),
                true
            )) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'jawaban_benar' =>
                            'Kunci jawaban harus sesuai dengan kode pilihan yang tersedia.',
                    ]);
            }
        }


        // =====================================================
        // 4. VALIDASI KHUSUS ESAI
        // =====================================================

        if ($validated['tipe'] === 'esai') {

            $rubrik = $validated['rubrik_penilaian'] ?? [];

            // Hitung seluruh bobot
            $totalBobot = collect($rubrik)->sum(function ($item) {
                return (int) $item['bobot'];
            });

            if ($totalBobot !== 100) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'rubrik_penilaian' =>
                            'Total bobot seluruh kriteria harus tepat 100%. Total saat ini: '
                            . $totalBobot . '%.',
                    ]);
            }

            // Pastikan nama kriteria tidak duplikat
            $namaKriteria = collect($rubrik)
                ->pluck('nama')
                ->map(fn ($nama) => mb_strtolower(trim($nama)));

            if ($namaKriteria->unique()->count() !== $namaKriteria->count()) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'rubrik_penilaian' =>
                            'Nama kriteria penilaian tidak boleh duplikat.',
                    ]);
            }
        }


        // =====================================================
        // 5. SIMPAN SOAL MENGGUNAKAN TRANSACTION
        // =====================================================

        DB::transaction(function () use ($validated, $ruangUjian) {

            // Kunci baris ruang ujian agar urutan tidak mudah bentrok
            $ruangTerkunci = RuangUjian::whereKey($ruangUjian->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Tentukan urutan soal
            $urutan = ($ruangTerkunci->soal()->max('urutan') ?? 0) + 1;

            // Simpan soal
            SoalUjian::create([

                'ruang_ujian_id' => $ruangTerkunci->id,

                'urutan' => $urutan,

                'pertanyaan' => $validated['pertanyaan'],

                'tipe' => $validated['tipe'],

                // Pilihan jawaban
                'opsi' => $validated['tipe'] === 'pilihan_ganda'
                    ? $validated['opsi']
                    : null,

                // Kunci jawaban
                'jawaban_benar' => $validated['tipe'] === 'pilihan_ganda'
                    ? $validated['jawaban_benar']
                    : null,

                // Jawaban acuan esai
                'jawaban_acuan' => $validated['tipe'] === 'esai'
                    ? $validated['jawaban_acuan']
                    : null,

                // Rubrik esai
                'rubrik_penilaian' => $validated['tipe'] === 'esai'
                    ? $validated['rubrik_penilaian']
                    : null,

                // Skor maksimal
                'skor_maksimal' => $validated['tipe'] === 'esai'
                    ? $validated['skor_maksimal']
                    : 100,

                'exp' => $validated['exp'],

                'pembahasan' => $validated['pembahasan'] ?? null,

            ]);
        });


        // =====================================================
        // 6. REDIRECT
        // =====================================================

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Soal berhasil ditambahkan.');

    }

    public function edit($ruang_ujian_id, $soal_id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);

        $soal = SoalUjian::where('ruang_ujian_id', $ruangUjian->id)
            ->findOrFail($soal_id);

        return view('guru.ruang-ujian.soal.edit', compact(
            'ruangUjian',
            'soal'
        ));
    }
    public function update(Request $request, $ruang_ujian_id, $soal_id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);

        $soal = SoalUjian::where('ruang_ujian_id', $ruangUjian->id)
            ->findOrFail($soal_id);

        $validated = $request->validate([
            'pertanyaan' => ['required', 'string'],
            'tipe' => ['required', Rule::in(['pilihan_ganda', 'esai'])],
            'opsi' => ['nullable', 'array'],
            'opsi.*.kode' => ['required_if:tipe,pilihan_ganda', 'nullable', 'string', 'max:5'],
            'opsi.*.teks' => ['required_if:tipe,pilihan_ganda', 'nullable', 'string'],
            'jawaban_benar' => ['required_if:tipe,pilihan_ganda', 'nullable', 'string'],
            'exp' => ['required', 'integer', 'min:0', 'max:1000'],
            'pembahasan' => ['nullable', 'string'],
        ]);

        if ($validated['tipe'] === 'pilihan_ganda') {
            $opsi = $validated['opsi'] ?? [];

            if (count($opsi) < 2) {
                return back()->withInput()->withErrors([
                    'opsi' => 'Minimal harus tersedia 2 pilihan jawaban.',
                ]);
            }

            $kodeOpsi = collect($opsi)->pluck('kode')->toArray();

            if (!in_array($validated['jawaban_benar'], $kodeOpsi)) {
                return back()->withInput()->withErrors([
                    'jawaban_benar' => 'Kunci jawaban tidak sesuai dengan pilihan yang tersedia.',
                ]);
            }
        }

        $soal->update([
            'pertanyaan' => $validated['pertanyaan'],
            'tipe' => $validated['tipe'],
            'opsi' => $validated['tipe'] === 'pilihan_ganda'
                ? $validated['opsi']
                : null,
            'jawaban_benar' => $validated['tipe'] === 'pilihan_ganda'
                ? $validated['jawaban_benar']
                : null,
            'exp' => $validated['exp'],
            'pembahasan' => $validated['pembahasan'] ?? null,
        ]);

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Soal berhasil diperbarui.');
    }
    public function destroy($ruang_ujian_id, $soal_id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);

        $soal = SoalUjian::where('ruang_ujian_id', $ruangUjian->id)
            ->findOrFail($soal_id);

        // Cegah penghapusan jika soal sudah pernah dijawab siswa.
        if ($soal->jawabanUjian()->exists()) {
            return redirect()
                ->route('guru.ruang-ujian.show', $ruangUjian->id)
                ->with('error', 'Soal tidak dapat dihapus karena sudah pernah dikerjakan siswa.');
        }

        $soal->delete();

        // Susun ulang nomor urut soal setelah penghapusan.
        $ruangUjian->soal()
            ->orderBy('urutan')
            ->get()
            ->values()
            ->each(function ($item, $index) {
                $item->update([
                    'urutan' => $index + 1,
                ]);
            });

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Soal berhasil dihapus.');
    }
}
